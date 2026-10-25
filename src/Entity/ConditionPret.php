<?php

namespace App\Entity;

use App\Repository\ConditionPretRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConditionPretRepository::class)]
class ConditionPret
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $tauxInteret = null;

    #[ORM\Column]
    private ?int $dureeMax = null;

    #[ORM\Column]
    private ?int $montantMax = null;

    #[ORM\ManyToOne(inversedBy: 'conditionPrets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Groupement $groupement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTauxInteret(): ?float
    {
        return $this->tauxInteret;
    }

    public function setTauxInteret(float $tauxInteret): static
    {
        $this->tauxInteret = $tauxInteret;

        return $this;
    }

    public function getDureeMax(): ?int
    {
        return $this->dureeMax;
    }

    public function setDureeMax(int $dureeMax): static
    {
        $this->dureeMax = $dureeMax;

        return $this;
    }

    public function getMontantMax(): ?int
    {
        return $this->montantMax;
    }

    public function setMontantMax(int $montantMax): static
    {
        $this->montantMax = $montantMax;

        return $this;
    }

    public function getGroupement(): ?Groupement
    {
        return $this->groupement;
    }

    public function setGroupement(?Groupement $groupement): static
    {
        $this->groupement = $groupement;

        return $this;
    }
}
