<?php

namespace App\Entity;

use App\Repository\OfferRepository;
use App\Traits\Timer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: OfferRepository::class)]
class Offer
{
    use Timer;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["offer"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["offer"])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(["offer"])]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Groups(["offer"])]
    private ?string $lat = null;

    #[ORM\Column(length: 255)]
    #[Groups(["offer"])]
    private ?string $lon = null;

    #[ORM\Column(length: 255)]
    private ?string $address_name = null;
    #[Groups(["offer"])]

    private ?bool $display_status = null;
    // #[Groups(["offer"])]
    #[ORM\OneToMany(targetEntity: OfferStatus::class, mappedBy: "offer")]
    private Collection $offerStatuses;

    #[ORM\Column(length: 255)]
    #[Groups(["offer"])]
    private ?string $reference = null;

    #[ORM\ManyToOne(inversedBy: 'offers')]
    #[Groups(["offer"])]
    private ?Agent $agent = null;

    #[ORM\OneToMany(targetEntity: Conditions::class, mappedBy: 'offer')]
    private Collection $conditions;

    #[ORM\ManyToMany(targetEntity: OfferUser::class, mappedBy: 'offer')]
    private Collection $offerUsers;

    public function __construct()
    {
        $this->offerStatuses = new ArrayCollection();
        $this->conditions = new ArrayCollection();
        $this->offerUsers = new ArrayCollection();
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

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getAgent(): ?Agent
    {
        return $this->agent;
    }

    public function setAgent(?Agent $agent): static
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * @return Collection<int, Conditions>
     */
    public function getConditions(): Collection
    {
        return $this->conditions;
    }

    public function addCondition(Conditions $condition): static
    {
        if (!$this->conditions->contains($condition)) {
            $this->conditions->add($condition);
            $condition->setOffer($this);
        }

        return $this;
    }

    public function removeCondition(Conditions $condition): static
    {
        if ($this->conditions->removeElement($condition)) {
            // set the owning side to null (unless already changed)
            if ($condition->getOffer() === $this) {
                $condition->setOffer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, OfferUser>
     */
    public function getOfferUsers(): Collection
    {
        return $this->offerUsers;
    }

    public function addOfferUser(OfferUser $offerUser): static
    {
        if (!$this->offerUsers->contains($offerUser)) {
            $this->offerUsers->add($offerUser);
            $offerUser->addOffer($this);
        }

        return $this;
    }

    public function removeOfferUser(OfferUser $offerUser): static
    {
        if ($this->offerUsers->removeElement($offerUser)) {
            $offerUser->removeOffer($this);
        }

        return $this;
    }
}
