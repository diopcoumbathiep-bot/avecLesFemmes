<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Epargne extends TypeCampagne
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $objectif = null;

    public function getObjectif(): ?int
    {
        return $this->objectif;
    }

    public function setObjectif(?int $objectif): static
    {
        $this->objectif = $objectif;

        return $this;
    }
}