<?php

namespace App\Controller\Company;

use App\Entity\Agent;
use App\Entity\Company;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CompanyController extends AbstractController
{

    /**
     * Class constructor.
     */
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    #[Route('create-company', methods: ['POST'])]
    public function __invoke(Request $request)
    {
        $agent = new Company();
        $data = handleData($request, ['name', 'description']);

        if (isset($data['errors'])) {
            return $this->json($data, 422);
        }

        $agent
            ->setName($data['name'])
            ->setDescription($data['description'])
            ->setLat($data['lat'] ?? "")
            ->setLon($data['lon'] ?? "")
            ->setAddressName($data['addressname'] ?? "");

        $this->em->persist($agent);
        $this->em->flush();

        return $this->json(responseSuccess('Agent Créer avec succès', data: $agent, status: Response::HTTP_CREATED), Response::HTTP_CREATED);
    }
}
