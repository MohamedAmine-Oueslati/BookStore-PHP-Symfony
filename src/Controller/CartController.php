<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function index(): Response
    {

        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }

    /**
     * @Route("/cart/{id}", name="cart_list")
     */
    public function cartList(Security $security, Books $book): Response
    {
        $user = $security->getUser();
        if (!$user->getCart()) {
            $cart = new Cart();
            $cart->setUser($user)
                ->addBook($book);
        } else {
            $cart = $user->getCart();
            $cart->addBook($book);
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($cart);
        $entityManager->flush();

        // dump($id);



        return $this->forward('App\Controller\StoreController::bookList');
    }
}
