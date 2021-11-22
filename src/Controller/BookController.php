<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

use App\Form\BookType;
use App\Entity\Books;
use App\Repository\BooksRepository;
use App\Form\CommentType;
use App\Entity\Comments;
use App\Form\SearchType;
use App\Entity\Search;

class BookController extends AbstractController
{

    /**
     * @Route("/Book/{id}", name="details")
     */
    public function details(Books $book, PaginatorInterface $paginator, Request $request): Response
    {
        $comment = new Comments();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->forward('App\Controller\CommentsController::new', [
                'comment' => $comment,
                'book' => $book,
            ]);
            return $this->redirectToRoute('details', ['id' => $book->getId()]);
        }

        $commentPerPage = $paginator->paginate(
            $book->getComments(),
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('book/details.html.twig', [
            'book' => $book,
            'comments' => $commentPerPage,
            'formComment' => $form->createView(),
        ]);
    }

    /**
     * @Route("/BookList", name="bookList")
     */
    public function bookList(BooksRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {

        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);

        $books = $repo->findAllQuery($search);
        $bookPerPage = $paginator->paginate(
            $books,
            $request->query->getInt('page', 1),
            8
        );

        return $this->render('book/books.html.twig', [
            'controller_name' => 'BookController',
            'books' => $bookPerPage,
            'formSearch' => $form->createView(),
        ]);
    }

    /**
     * @Route("/AddBook", name="AddBook")
     */
    public function addBook(request $request): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        $book = new Books();
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book->setAvailibility(true)
                ->setDatePublished(new \DateTime());
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('bookList');
        }

        return $this->render('book/orders.html.twig', [
            'formBook' => $form->createView(),
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('book/home.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about(): Response
    {
        return $this->render('book/about.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        return $this->render('book/contact.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    /**
     * @Route("/faq", name="faq")
     */
    public function faq(): Response
    {
        return $this->render('book/faq.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }
}
