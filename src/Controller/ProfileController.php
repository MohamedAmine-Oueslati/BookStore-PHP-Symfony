<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use App\Entity\User;
use App\Form\ProfileType;


/**
 * @IsGranted("ROLE_USER")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/profile/{id}", name="profile")
     */
    public function index(Request $request, User $user): Response
    {
        $profile = $user->getProfile();

        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        $this->forward('App\Controller\ProfileController::edit', [
            'user' => $user,
            'form' => $form,
            'request' => $request
        ]);

        return $this->render('profile/index.html.twig', [
            'formProfile' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
     * @Route("/edit", name="profile_edit")
     */
    public function edit($user, $form, $request): Response
    {

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setUsername($request->request->get('username'));
            $user->setEmail($request->request->get('email'));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('profile');
        }

        return $this->render('profile/edit.html.twig', []);
    }
}
