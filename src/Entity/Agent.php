<?php

namespace App\Entity;

use App\Repository\AgentRepository;
use App\Traits\Timer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: AgentRepository::class)]
class Agent
{
    use Timer;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['agent'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'agents')]
    #[Groups(['agent'])]
    private ?Company $company = null;

    #[ORM\OneToMany(targetEntity: Agent::class, mappedBy: 'User')]
    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[Groups(['agent'])]
    private ?User $immoUser = null;

    #[ORM\OneToMany(targetEntity: Offer::class, mappedBy: 'agent')]
    private Collection $offers;

    public function __construct()
    {
        $this->offers = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Offer>
     */
    public function getOffers(): Collection
    {
        return $this->offers;
    }

    public function addOffer(Offer $offer): static
    {
        if (!$this->offers->contains($offer)) {
            $this->offers->add($offer);
            $offer->setAgent($this);
        }

        return $this;
    }

    public function removeOffer(Offer $offer): static
    {
        if ($this->offers->removeElement($offer)) {
            // set the owning side to null (unless already changed)
            if ($offer->getAgent() === $this) {
                $offer->setAgent(null);
            }
        }

        return $this;
    }

}
