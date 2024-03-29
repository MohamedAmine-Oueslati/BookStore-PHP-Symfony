<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use App\Entity\Books;
use App\Entity\Ratings;
use App\Entity\Comments;
use App\Entity\Search;
use App\Repository\BooksRepository;
use App\Repository\RatingsRepository;
use App\Form\BookType;
use App\Form\CommentType;
use App\Form\SearchType;

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

        $ratings = $book->getRatings();
        $rating = 0;
        if (count($ratings) > 0) {
            foreach ($ratings as $rate) {
                $rating += $rate->getValue();
            }
            $rating = $rating / count($ratings);
        }

        $commentPerPage = $paginator->paginate(
            $book->getComments(),
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('book/details.html.twig', [
            'rating' => $rating,
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

        return $this->render('book/list.html.twig', [
            'controller_name' => 'BookController',
            'books' => $bookPerPage,
            'formSearch' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
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

        return $this->render('book/add.html.twig', [
            'formBook' => $form->createView(),
        ]);
    }

    /**
     * @Route("/rateBook", name="rate_book")
     */
    public function rateBook(BooksRepository $booksRepo, RatingsRepository $ratingsRepo, request $request): Response
    {
        $rate = $request->request->get('rating');
        $bookId = $request->request->get('bookId');

        $entityManager = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $book = $booksRepo->findOneBy(['id' => $bookId]);
        $rating = $ratingsRepo->findOneBy(['user' => $user, 'book' => $book]);

        if ($rating) {
            $rating->setValue($rate);
        } else {
            $rating = new Ratings();

            $rating->setBook($book)
                ->setUser($user)
                ->setValue($rate);

            $entityManager->persist($rating);
        }
        $entityManager->flush();

        $bookRatings = $book->getRatings();
        $newWebRating = 0;
        foreach ($bookRatings as $bookRating) {
            $newWebRating += $bookRating->getValue();
        }
        $newWebRating = round($newWebRating / count($bookRatings), 1);


        return new Response($newWebRating);
    }
}
