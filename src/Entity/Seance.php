<?php

namespace App\Entity;

use App\Repository\SeanceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\StatutSeance;

#[ORM\Entity(repositoryClass: SeanceRepository::class)]
class Seance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $dateSeance = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $compteRendu = null;

    #[ORM\ManyToOne(inversedBy: 'seances')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Campagne $campagne = null;

    #[ORM\ManyToOne]
    private ?Membre $beneficiaire = null;
    #[ORM\Column(enumType: StatutSeance::class)]
    private ?StatutSeance $statutSeance = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateSeance(): ?\DateTime
    {
        return $this->dateSeance;
    }

    public function setDateSeance(\DateTime $dateSeance): static
    {
        $this->dateSeance = $dateSeance;

        return $this;
    }

    public function getCompteRendu(): ?string
    {
        return $this->compteRendu;
    }

    public function setCompteRendu(?string $compteRendu): static
    {
        $this->compteRendu = $compteRendu;

        return $this;
    }

    public function getCampagne(): ?Campagne
    {
        return $this->campagne;
    }

    public function setCampagne(?Campagne $campagne): static
    {
        $this->campagne = $campagne;

        return $this;
    }

    public function getBeneficiaire(): ?Membre
    {
        return $this->beneficiaire;
    }

    public function setBeneficiaire(?Membre $beneficiaire): static
    {
        $this->beneficiaire = $beneficiaire;

        return $this;
    }
        public function getStatutSeance(): ?StatutSeance
    {
        return $this->statutSeance;
    }

    public function setStatutSeance(StatutSeance $statutSeance): static
    {
        $this->statutSeance = $statutSeance;

        return $this;
    }
}
