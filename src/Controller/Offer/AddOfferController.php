<?php

namespace App\Controller\Offer;

use App\Entity\Offer;
use App\Repository\AgentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

class AddOfferController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em, private  AgentRepository $agentRepo)
    {
    }

    #[Route('/add-offer', methods: ['POST'])]
    public function __invoke(Request $request)
    {
        $data = handleData($request, [
            "title",
            "address_name",
            "conditions",
            "description"
        ]);

        if (isset($data['errors'])) {
            return $this->json($data, Response::HTTP_BAD_REQUEST);
        }

        $agent = $this->agentRepo->findOneBy([
            "immoUser" => $this->getUser()
        ]);

        $offer = new Offer();
        $offer
            ->setTitle($data['title'])
            ->setAddressName($data["address_name"])
            ->setConditions($data["conditions"])
            ->setDescription($data['description'])
            ->setLat($data['lat'] ?? "")
            ->setLon($data['lon'] ?? "")
            ->setReference(Uuid::v4())
            ->setAgent($agent)
            ->setDisplayStatus(true);

        $this->em->persist($offer);
        $this->em->flush();

        return $this->json(
            responseSuccess(
                'Offre ajouté',
                Response::HTTP_CREATED,
                data: $offer
            ),
            Response::HTTP_CREATED,
            context: ['groups' => "offer"]
        );
    }
}
