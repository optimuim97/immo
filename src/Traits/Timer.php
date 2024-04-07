<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;

trait Timer
{
    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        if ($this->getCreatedAt() == null){
            $this->setCreatedAt(new \DateTimeImmutable());
        }
    }
}

