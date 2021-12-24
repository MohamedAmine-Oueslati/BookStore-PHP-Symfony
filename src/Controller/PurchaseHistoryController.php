<?php

namespace App\Controller;

use App\Repository\PurchaseHistoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PurchaseHistoryController extends AbstractController
{
    /**
     * @Route("/purchaseHistory", name="purchase_history")
     */
    public function index(PurchaseHistoryRepository $purchaseHistoryRepo): Response
    {
        $user = $this->getUser();
        $purchaseHistory = $purchaseHistoryRepo->findBy(['user' => $user]);
        // dd($purchaseHistory);

        return $this->render('purchase_history/index.html.twig', [
            'purchaseHistory' => $purchaseHistory,
        ]);
    }
}
