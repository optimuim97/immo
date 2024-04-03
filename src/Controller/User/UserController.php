<?php
namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController{

    #[Route('get-user', methods:['POST'])]
    public function getCurrentUser(){
        return $this->json($this->getUser(), 200, context:["groups"=> "user"]);
    }
}