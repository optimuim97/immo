<?php

namespace App\Entity;

use App\Repository\UserProfilRepository;
use App\Traits\Timer;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserProfilRepository::class)]
class UserProfil
{
    use Timer;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $photo = null;

    #[ORM\ManyToOne(inversedBy: 'yes')]
    private ?User $UserImmo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getUserImmo(): ?User
    {
        return $this->UserImmo;
    }

    public function setUserImmo(?User $UserImmo): static
    {
        $this->UserImmo = $UserImmo;

        return $this;
    }
}
