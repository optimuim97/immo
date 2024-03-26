<?php

namespace App\Entity;

use App\Repository\OfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OfferRepository::class)]
class Offer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $lat = null;

    #[ORM\Column(length: 255)]
    private ?string $lon = null;

    #[ORM\Column(length: 255)]
    private ?string $address_name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $conditions = null;

    private ?bool $display_status = null;

    #[ORM\OneToMany(targetEntity: OfferStatus::class, mappedBy: 'offer')]
    private Collection $offerStatuses;

    public function __construct()
    {
        $this->offerStatuses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function setLat(string $lat): static
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLon(): ?string
    {
        return $this->lon;
    }

    public function setLon(string $lon): static
    {
        $this->lon = $lon;

        return $this;
    }

    public function getAddressName(): ?string
    {
        return $this->address_name;
    }

    public function setAddressName(string $address_name): static
    {
        $this->address_name = $address_name;

        return $this;
    }

    public function getConditions(): ?string
    {
        return $this->conditions;
    }

    public function setConditions(string $conditions): static
    {
        $this->conditions = $conditions;

        return $this;
    }

    public function getDisplayStatus(): ?string
    {
        return $this->display_status;
    }

    public function setDisplayStatus(string $display_status): static
    {
        $this->display_status = $display_status;

        return $this;
    }

    /**
     * @return Collection<int, OfferStatus>
     */
    public function getOfferStatuses(): Collection
    {
        return $this->offerStatuses;
    }

    public function addOfferStatus(OfferStatus $offerStatus): static
    {
        if (!$this->offerStatuses->contains($offerStatus)) {
            $this->offerStatuses->add($offerStatus);
            $offerStatus->setOffer($this);
        }

        return $this;
    }

    public function removeOfferStatus(OfferStatus $offerStatus): static
    {
        if ($this->offerStatuses->removeElement($offerStatus)) {
            // set the owning side to null (unless already changed)
            if ($offerStatus->getOffer() === $this) {
                $offerStatus->setOffer(null);
            }
        }

        return $this;
    }
}
