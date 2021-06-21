<?php

namespace App\Controller;

use App\Repository\PromoRepository;
use App\Service\PromoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    private $promoRepository;

    public function __construct(PromoRepository $promoRepository)
    {
        $this->promoRepository = $promoRepository;
    }

    /**
     * @Route("/manage/promo", name="admin")
     */
    public function index(): Response
    {
        $promos = $this->promoRepository->findAll();

        return $this->render('admin/managePromo.html.twig', [
            'promos' => $promos,
        ]);
    }

    /**
     * @Route("/manage/promo/{id}", name="remove_promo", methods={"DELETE"})
     */
    public function removePromo(PromoService $promoService, int $id): JsonResponse{
        return $promoService->removePromo($id);
    }

}