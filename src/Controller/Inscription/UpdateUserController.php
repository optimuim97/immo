<?php

namespace App\Controller\Inscription;

use App\Entity\User;
use App\Helpers\Utils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UpdateUserController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly UserPasswordHasherInterface $passwordHasherInterface,
        private readonly ValidatorInterface $validator
    ) {
    }

    #[Route('update-user', methods: ['POST'])]
    public function __invoke(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if (isset($data['dial_code']) && $data['numero']) {
            $phone = ($data['dial_code'] ?? "225") . $data['numero'];
            $checkPhone = Utils::validPhoneNumber($phone);
        }

        if (!$checkPhone) {
            return $this->json(responseSuccess("Numéro Invalide", 422), 422);
        }

        $user = $this->getUser();
        $user
            ->setFirstName($data['firstname'] ?? $user->getFirstName())
            ->setLastname($data['lastname'] ?? $user->getLastname())
            ->setDialCode($data['dial_code'] ?? $user->getDialCode())
            ->setPhoneNumber($data['numero'] ?? $user->getPhoneNumber())
            ->setPhone($phone ?? $user->getPhone())
            ->setEmail($data['email'] ?? $user->getEmail() ?? "");

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {

            $hasError = Utils::handleError($errors);

            if ($hasError != null) {
                return $this->json(
                    [
                        "status_code" => Response::HTTP_UNPROCESSABLE_ENTITY,
                        "message" => Response::$statusTexts['422'],
                        "errors" => $hasError
                    ],
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }
        }

        $this->em->persist($user);
        $this->em->flush();

        return $this->json(
            [
                "message" => "Mise à jour",
                "data" => $user,
                "status_code" => Response::HTTP_OK
            ],
            context: ['groups' => "user"]
        );
    }
}
