<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use App\Entity\Books;
use App\Entity\PurchaseHistory;
use App\Entity\BookPurchased;
use App\Repository\BooksRepository;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function index(SessionInterface $session, BooksRepository $booksRepo): Response
    {
        $cart = $session->get('cart', []);

        $dataCart = [];
        $total = 0;

        foreach ($cart as $id => $quantity) {
            $book = $booksRepo->find($id);
            $dataCart[] = [
                "book" => $book,
                "quantity" => $quantity
            ];

            $total += $book->getPrice() * $quantity;
        }

        return $this->render('cart/index.html.twig', [
            'dataCart' => $dataCart,
            'total' => $total
        ]);
    }

    /**
     * @Route("/cart/increase/{id}", name="cart_increase_quantity")
     */
    public function increaseBookQuantity(SessionInterface $session, Books $book): Response
    {
        $cart = $session->get('cart', []);
        $id = $book->getId();

        if (!empty($cart[$id])) {
            $cart[$id]++;
            $session->set('cart', $cart);

            return $this->redirectToRoute('cart');
        } else {
            $cart[$id] = 1;
            $session->set('cart', $cart);

            return $this->redirectToRoute('bookList');
        }
    }

    /**
     * @Route("cart/decrease/{id}", name="cart_decrease_quantity")
     */
    public function decreaseBookQuantity(SessionInterface $session, Books $book): Response
    {
        $cart = $session->get('cart', []);
        $id = $book->getId();

        if ($cart[$id] > 1) {
            $cart[$id]--;
        } else {
            unset($cart[$id]);
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("cart/remove/{id}", name="cart_remove_book")
     */
    public function removeBook(SessionInterface $session, Books $book): Response
    {
        $cart = $session->get('cart', []);
        $id = $book->getId();

        unset($cart[$id]);

        $session->set('cart', $cart);

        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("cart/purchase", name="cart_purchase")
     */
    public function makePurchase(SessionInterface $session, BooksRepository $booksRepo): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $cart = $session->get('cart', []);
        $purchaseHistory = new PurchaseHistory();
        $total = 0;

        foreach ($cart as $id => $quantity) {
            $book = $booksRepo->find($id);

            $bookPurchased = new BookPurchased();
            $bookPurchased->setBook($book)
                ->setQuantity($quantity);

            $entityManager->persist($bookPurchased);

            $purchaseHistory->addBook($bookPurchased);

            $total += $book->getPrice() * $quantity;
        }

        $purchaseHistory->setTotal($total)
            ->setUser($this->getUser())
            ->setOrderPlaced(new \DateTime());

        $entityManager->persist($purchaseHistory);
        $entityManager->flush();

        $session->remove('cart');

        return $this->redirectToRoute('bookList');
    }
}
