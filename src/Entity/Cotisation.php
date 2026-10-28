<?php

namespace App\Entity;

use App\Repository\CotisationRepository;
use App\Trait\DateTimeTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CotisationRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Cotisation
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $montantCotisation = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateCotisation = null;

    #[ORM\ManyToOne(inversedBy: 'cotisations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Seance $seance = null;

    #[ORM\ManyToOne(inversedBy: 'cotisations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Membre $membre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantCotisation(): ?int
    {
        return $this->montantCotisation;
    }

    public function setMontantCotisation(int $montantCotisation): static
    {
        $this->montantCotisation = $montantCotisation;

        return $this;
    }

    public function getDateCotisation(): ?\DateTimeImmutable
    {
        return $this->dateCotisation;
    }

    public function setDateCotisation(\DateTimeImmutable $dateCotisation): static
    {
        $this->dateCotisation = $dateCotisation;

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

    public function getMembre(): ?Membre
    {
        return $this->membre;
    }

    public function setMembre(?Membre $membre): static
    {
        $this->membre = $membre;

        return $this;
    }
}