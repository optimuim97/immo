<?php

namespace App\Entity;

use App\Repository\ConditionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConditionsRepository::class)]
class Conditions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $loyer = null;

    #[ORM\Column(length: 255)]
    private ?string $nb_mois = null;

    #[ORM\Column(length: 255)]
    private ?string $note = null;

    #[ORM\ManyToOne(inversedBy: 'conditions')]
    private ?Offer $offer = null;

    #[ORM\OneToMany(targetEntity: ConditionsSup::class, mappedBy: 'conditions')]
    private Collection $conditionsSups;

    public function __construct()
    {
        $this->conditionsSups = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLoyer(): ?string
    {
        return $this->loyer;
    }

    public function setLoyer(string $loyer): static
    {
        $this->loyer = $loyer;

        return $this;
    }

    public function getNbMois(): ?string
    { 
        return $this->nb_mois;
    }

    public function setNbMois(string $nb_mois): static
    {
        $this->nb_mois = $nb_mois;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): static
    {
        $this->note = $note;

        return $this;
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

    /**
     * @return Collection<int, ConditionsSup>
     */
    public function getConditionsSups(): Collection
    {
        return $this->conditionsSups;
    }

    public function addConditionsSup(ConditionsSup $conditionsSup): static
    {
        if (!$this->conditionsSups->contains($conditionsSup)) {
            $this->conditionsSups->add($conditionsSup);
            $conditionsSup->setConditions($this);
        }

        return $this;
    }

    public function removeConditionsSup(ConditionsSup $conditionsSup): static
    {
        if ($this->conditionsSups->removeElement($conditionsSup)) {
            // set the owning side to null (unless already changed)
            if ($conditionsSup->getConditions() === $this) {
                $conditionsSup->setConditions(null);
            }
        }

        return $this;
    }
}
