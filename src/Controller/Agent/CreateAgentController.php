<?php

namespace App\Controller\Agent;

use App\Entity\Agent;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CreateAgentController extends AbstractController
{

    /**
     * Class constructor.
     */
    public function __construct(private readonly EntityManagerInterface $em, private readonly  CompanyRepository $companyRepo)
    {
    }

    #[Route('create-agent', methods: ['POST'])]
    public function __invoke(Request $request)
    {
        $agent = new Agent();
        $data = handleData($request, ['company_id']);
        if (isset($data['errors'])) {
            return $this->json($data, Response::HTTP_BAD_REQUEST);
        }

        $company = $this->companyRepo->find($data['company_id']);
        if (empty($company)) {
            return $this->json(responseSuccess('Company introuvable', 404), 404);
        }

        $agent->setCompany($company)
            ->setImmoUser($this->getUser());

        $this->em->persist($agent);
        $this->em->flush();

        return $this->json(
            responseSuccess(
                'Agent Créer avec succès',
                data: $agent,
                status: Response::HTTP_CREATED
            ),
            Response::HTTP_CREATED,
            context: ['groups' => "agent"]
        );
    }
}
