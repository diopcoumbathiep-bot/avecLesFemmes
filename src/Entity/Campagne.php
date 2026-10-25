<?php

namespace App\Entity;

use App\Repository\CampagneRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampagneRepository::class)]
class Campagne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nomCampagne = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateDebutCampagne = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $dateFinCampagne = null;

    #[ORM\Column]
    private ?int $montantCampagne = null;

    #[ORM\Column(length: 50)]
    private ?string $frequence = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $updateAt = null;

    #[ORM\ManyToOne(inversedBy: 'campagnes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeCampagne $typeCampagne = null;

    #[ORM\ManyToOne(inversedBy: 'campagnes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Groupement $groupement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCampagne(): ?string
    {
        return $this->nomCampagne;
    }

    public function setNomCampagne(string $nomCampagne): static
    {
        $this->nomCampagne = $nomCampagne;

        return $this;
    }

    public function getDateDebutCampagne(): ?\DateTime
    {
        return $this->dateDebutCampagne;
    }

    public function setDateDebutCampagne(\DateTime $dateDebutCampagne): static
    {
        $this->dateDebutCampagne = $dateDebutCampagne;

        return $this;
    }

    public function getDateFinCampagne(): ?\DateTime
    {
        return $this->dateFinCampagne;
    }

    public function setDateFinCampagne(?\DateTime $dateFinCampagne): static
    {
        $this->dateFinCampagne = $dateFinCampagne;

        return $this;
    }

    public function getMontantCampagne(): ?int
    {
        return $this->montantCampagne;
    }

    public function setMontantCampagne(int $montantCampagne): static
    {
        $this->montantCampagne = $montantCampagne;

        return $this;
    }

    public function getFrequence(): ?string
    {
        return $this->frequence;
    }

    public function setFrequence(string $frequence): static
    {
        $this->frequence = $frequence;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): static
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTime
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTime $updateAt): static
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getTypeCampagne(): ?TypeCampagne
    {
        return $this->typeCampagne;
    }

    public function setTypeCampagne(?TypeCampagne $typeCampagne): static
    {
        $this->typeCampagne = $typeCampagne;

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
