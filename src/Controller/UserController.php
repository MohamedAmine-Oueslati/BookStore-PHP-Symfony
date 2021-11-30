<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use App\Form\RegisterType;
use App\Entity\Users;
use App\Mailer\RegisterMail;

class UserController extends AbstractController
{
    /**
     * @Route("/Register", name="register")
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $encoder,
        RegisterMail $mailer
    ): Response {
        $entityManager = $this->getDoctrine()->getManager();

        $user = new Users();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            $entityManager->persist($user);
            $entityManager->flush();

            $mailer->sendMail($user);

            return $this->redirectToRoute('bookList');
        }

        return $this->render('user/register.html.twig', [
            'formUser' => $form->createView(),
        ]);
    }

    /**
     * @Route("/Login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('user/login.html.twig', [
            'lastUsername' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/Logout", name="logout")
     */
    public function logout()
    {
    }
}
