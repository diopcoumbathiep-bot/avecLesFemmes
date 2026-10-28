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
    #[ORM\JoinColumn(nullable: false)]
    private ?Pret $pret = null;

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
}