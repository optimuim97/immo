<?php

namespace App\Controller\Offer;

use App\Entity\Offer;
use App\Repository\AgentRepository;
use App\Repository\OfferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

class GetOfferController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private  AgentRepository $agentRepo,
        private OfferRepository $offerRepo
    ) {
    }

    #[Route('/get-offers', methods: ['GET'])]
    public function __invoke(Request $request)
    {
        $offers = $this->offerRepo->findBy([
            "createdAt" => "DESC"
        ]);

        return $this->json(
            responseSuccess(
                'Liste des offres',
                Response::HTTP_OK,
                data: $offers
            ),
            Response::HTTP_OK,
            context: ['groups' => "offer"]
        );
    }
}
