<?php

namespace App\Controller\Offer;

use App\Repository\AgentRepository;
use App\Repository\OfferRepository;
use Doctrine\Common\Collections\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
        $limit = $request->query->get('limit') ?? null;
        $order = $request->query->get('order') ?? null;

        if(!in_array(strtolower($order), ["desc", "asc"])){
            return $this->json(["error"=> "order sense not  exist"], Response::HTTP_NOT_FOUND);
        }
        
        $offers = $this->offerRepo->findBy([], ['created_at'=> "DESC"], ctype_digit($limit) ? (int) $limit : 10);

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
