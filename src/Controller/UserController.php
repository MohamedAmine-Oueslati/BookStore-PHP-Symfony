<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Security\AppAuthenticator;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

use App\Form\RegisterType;
use App\Entity\User;
use App\Entity\Profile;
use App\Entity\Cart;
use App\Mailer\RegisterMail;

class UserController extends AbstractController
{
    /**
     * @Route("/Register", name="register")
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $encoder,
        RegisterMail $mailer,
        AppAuthenticator $authenticator,
        GuardAuthenticatorHandler $guardHandler
    ): Response {
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            $cart = new Cart();
            $profile = new Profile();
            $user->setCart($cart);
            $user->setProfile($profile);

            $entityManager->persist($user);
            $entityManager->flush();

            $mailer->sendMail($user);

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,          // the User object you just created
                $request,
                $authenticator, // authenticator whose onAuthenticationSuccess you want to use
                'main'          // the name of your firewall in security.yaml
            );
            // return $this->redirectToRoute('bookList');
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
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/Logout", name="logout")
     */
    public function logout()
    {
        // throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
