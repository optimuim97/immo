<?php

namespace App\Entity;

use App\Repository\OfferStatusRepository;
use App\Traits\Timer;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OfferStatusRepository::class)]
class OfferStatus
{
    use Timer;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'offerStatuses')]
    private ?Offer $offer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOffer(): ?Offer
    {
        return $this->offer;
    }

    public function setOffer(?Offer $offer): static
    {
        $this->offer = $offer;

        return $this;
    }
}
