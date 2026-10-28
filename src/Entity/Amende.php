<?php

namespace App\Entity;

use App\Repository\AmendeRepository;
use App\Trait\DateTimeTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AmendeRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Amende
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $montantAmende = null;

    #[ORM\Column(length: 255)]
    private ?string $motifAmende = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateApplication = null;

    #[ORM\ManyToOne(inversedBy: 'amendes')]
    private ?Pret $pret = null;

    #[ORM\Column(nullable: true)]
    private ?int $nombreJours = null;

    #[ORM\ManyToOne(inversedBy: 'amendes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Membre $membre = null;

    #[ORM\ManyToOne(inversedBy: 'amendes')]
    private ?Seance $seance = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantAmende(): ?int
    {
        return $this->montantAmende;
    }

    public function setMontantAmende(int $montantAmende): static
    {
        $this->montantAmende = $montantAmende;

        return $this;
    }

    public function getMotifAmende(): ?string
    {
        return $this->motifAmende;
    }

    public function setMotifAmende(string $motifAmende): static
    {
        $this->motifAmende = $motifAmende;

        return $this;
    }

    public function getDateApplication(): ?\DateTimeImmutable
    {
        return $this->dateApplication;
    }

    public function setDateApplication(\DateTimeImmutable $dateApplication): static
    {
        $this->dateApplication = $dateApplication;

        return $this;
    }

    public function getPret(): ?Pret
    {
        return $this->pret;
    }

    public function setPret(?Pret $pret): static
    {
        $this->pret = $pret;

        return $this;
    }

    public function getNombreJours(): ?int
    {
        return $this->nombreJours;
    }

    public function setNombreJours(?int $nombreJours): static
    {
        $this->nombreJours = $nombreJours;

        return $this;
    }

    public function getMembre(): ?Membre
    {
        return $this->membre;
    }

    public function setMembre(?Membre $membre): static
    {
        $this->membre = $membre;

        return $this;
    }

    public function getSeance(): ?Seance
    {
        return $this->seance;
    }

    public function setSeance(?Seance $seance): static
    {
        $this->seance = $seance;

        return $this;
    }
}