<?php

namespace App\Entity;

use App\Repository\AgentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AgentRepository::class)]
class Agent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'agents')]
    private ?Company $company = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $immoUser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getImmoUser(): ?User
    {
        return $this->immoUser;
    }

    public function setImmoUser(?User $immoUser): static
    {
        $this->immoUser = $immoUser;

        return $this;
    }
}
