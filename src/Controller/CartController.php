<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use App\Entity\Cart;
use App\Entity\Books;

class CartController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/cart", name="cart")
     */
    public function index(): Response
    {
        $cart = $this->getUser()->getCart();

        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
        ]);
    }

    /**
     * @Route("/cart/{id}", name="cart_list")
     */
    public function cartList(Books $book): Response
    {
        $user = $this->getUser();
        $cart = $user->getCart();
        if (!$cart) {
            $cart = new Cart();
            $cart->setUser($user);
        }

        $cart->addBook($book);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($cart);
        $entityManager->flush();

        return $this->redirectToRoute('bookList');
    }

    /**
     * @Route("cart/delete/{id}", name="cart_delete")
     */
    public function delete(Books $book): Response
    {

        // if ($this->isCsrfTokenValid('delete' . $comment->getId(), $request->request->get('_token'))) {
        $cart = $this->getUser()->getCart();
        $cart->removeBook($book);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        // }

        return $this->redirectToRoute('cart');
    }
}
