<?php

namespace App\Controller\Inscription;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserRegisterController extends AbstractController
{

    public function __construct(private readonly EntityManagerInterface $em){}

    #[Route('user-register', methods: ['post'])]
    public function __invoke(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $errors = checkNotEmpty($data,[
            "firstname",
            "lastname",
            // "dial_code",
            "numero",
            // "email"
        ]);

        if($errors){
            return $this->json($errors, 422);
        }
    
        $user = new User();
        $user->setFirstName($data['firstname'])
            ->setLastname($data['lastname'])
            ->setDialCode($data['dial_code'] ?? "225")
            ->setPhoneNumber($data['numero'])
            ->setPhone(($data['dial_code'] ?? "225").$data['numero'])
            ->setEmail($data['email']??"");

        $this->em->persist($user);
        $this->em->flush(); 
        
        return $this->json([
            "message"=> "Enregistré",
            "status_code"=> Response::HTTP_OK,
        ]);
    }
}
