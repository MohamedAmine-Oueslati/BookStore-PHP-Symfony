<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use App\Entity\Books;
use App\Repository\BooksRepository;
use Symfony\Component\HttpFoundation\Request;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function index(SessionInterface $session, BooksRepository $booksRepo, Request $request): Response
    {

        $output = $request->request->get('output');
        if ($output !== null) {
            return $this->redirectToRoute('bookList');
        }

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
        } else {
            $cart[$id] = 1;
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute('cart');
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
}
