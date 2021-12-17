<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Mailer\ContactMail;
use App\Repository\BlogRepository;

class StoreController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(BlogRepository $blogRepo): Response
    {

        $blog = $blogRepo->findBy(array(), array('createdAt' => 'DESC'), 3);

        // session_start();
        // dd(unserialize($_SESSION["_sf2_attributes"]["_security_main"]));


        return $this->render('store/home.html.twig', [
            'blog' => $blog,
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about(): Response
    {
        return $this->render('store/about.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, ContactMail $mailer): Response
    {

        $contact = ["dateSent" => new \DateTime()];
        $form = $this->createFormBuilder($contact)
            ->add('fullname', TextType::class)
            ->add('email', TextType::class)
            ->add('subject', TextType::class)
            ->add('message', TextareaType::class)
            ->add('submit', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $mailer->sendMail($data);

            $this->addFlash(
                'success',
                "Thanks {$data['fullname']} for reaching out! We’re thrilled to hear from you"
            );

            unset($form);
            return $this->redirectToRoute('contact');
        }

        return $this->render('store/contact.html.twig', [
            'controller_name' => 'BookController',
            'formContact' => $form->createView(),
        ]);
    }

    /**
     * @Route("/faq", name="faq")
     */
    public function faq(): Response
    {
        return $this->render('store/faq.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }
}
