<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Epargne extends TypeCampagne
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $objectif = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $isCalebasse = false;

    public function getObjectif(): ?int
    {
        return $this->objectif;
    }

    public function setObjectif(?int $objectif): static
    {
        $this->objectif = $objectif;

        return $this;
    }

    public function isIsCalebasse(): ?bool
    {
        return $this->isCalebasse;
    }

    public function setIsCalebasse(?bool $isCalebasse): static
    {
        $this->isCalebasse = $isCalebasse;

        return $this;
    }
}