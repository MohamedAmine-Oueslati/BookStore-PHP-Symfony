<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\LoginType;
use App\Form\RegisterType;
use App\Entity\Users;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/Register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = new Users();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('bookList');
        }

        return $this->render('store/register.html.twig', [
            'formUser' => $form->createView(),
        ]);
    }

    /**
     * @Route("/Login", name="login")
     */
    public function login(): Response
    {
        // $user = new Users();
        // $form = $this->createForm(LoginType::class, $user);

        // $form->handleRequest($request);

        // $loginUser = $this->getDoctrine()
        //     ->getRepository(Users::class)
        //     ->findOneBy(['email' => $user->getEmail()]);

        // if ($loginUser && $loginUser->getPassword() === $user->getPassword()) {
        //     return $this->redirectToRoute('bookList');
        // 
        return $this->render('store/login.html.twig', [
            // 'formUser' => $form->createView(),
        ]);
    }

    /**
     * @Route("/Logout", name="logout")
     */
    public function logout()
    {
    }
}
