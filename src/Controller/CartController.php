<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

use App\Entity\Cart;
use App\Entity\Books;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function index(Security $security): Response
    {

        $user = $security->getUser();
        $cart = $user->getCart();
        // dd($cart);

        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
        ]);
    }

    /**
     * @Route("/cart/{id}", name="cart_list")
     */
    public function cartList(Security $security, Books $book): Response
    {
        $user = $security->getUser();
        $cart = $user->getCart();
        if (!$cart) {
            $cart = new Cart();
            $cart->setUser($user);
        }

        $cart->addBook($book);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($cart);
        $entityManager->flush();

        // return $this->forward('App\Controller\BookController::bookList');
        return $this->redirectToRoute('bookList');
    }

    /**
     * @Route("cart/delete/{id}", name="cart_delete")
     */
    public function delete(Security $security, Books $book): Response
    {

        // if ($this->isCsrfTokenValid('delete' . $comment->getId(), $request->request->get('_token'))) {
        $cart = $security->getUser()->getCart();
        $cart->removeBook($book);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        // }

        return $this->redirectToRoute('cart');
    }
}
