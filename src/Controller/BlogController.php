<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use App\Form\BlogType;
use App\Entity\Blog;
use App\Repository\BlogRepository;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(BlogRepository $blogRepo): Response
    {

        $blog = $blogRepo->findAll();

        return $this->render('blog/index.html.twig', [
            'blog' => $blog,
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/addPost", name="addPost")
     */
    public function addPost(request $request): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        $blog = new Blog();
        $form = $this->createForm(BlogType::class, $blog);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $blog->setCreatedAt(new \DateTime())
                ->setUser($this->getUser());
            $entityManager->persist($blog);
            $entityManager->flush();

            return $this->redirectToRoute('blog');
        }

        return $this->render('blog/addPost.html.twig', [
            'formBlog' => $form->createView(),
        ]);
    }
}
