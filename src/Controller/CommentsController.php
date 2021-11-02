<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Form\CommentType;
use App\Entity\Comments;
use App\Entity\Books;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/comments")
 */
class CommentsController extends AbstractController
{
    /**
     * @Route("/", name="comments_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('comments/index.html.twig', []);
    }

    /**
     * @Route("/new", name="comments_new", methods={"GET","POST"})
     */
    public function new(Security $security, $comment, $book): Response
    {

        $user = $security->getUser();
        $comment->setCreatedAt(new \DateTime())
            ->setBook($book)
            ->setAuthor($user);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($comment);
        $entityManager->flush();

        return $this->render('comments/new.html.twig', []);
    }

    /**
     * @Route("/{id}/edit", name="comments_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Comments $comment): Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('details', ['id' => $comment->getBook()->getId()]);
        }

        return $this->render('comments/edit.html.twig', [
            'comment' => $comment,
            'formComment' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="comments_delete")
     */
    public function delete(Request $request, Comments $comment): Response
    {
        // if ($this->isCsrfTokenValid('delete' . $comment->getId(), $request->request->get('_token'))) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($comment);
        $entityManager->flush();
        // }

        return $this->redirectToRoute('details', ['id' => $comment->getBook()->getId()]);
    }
}
