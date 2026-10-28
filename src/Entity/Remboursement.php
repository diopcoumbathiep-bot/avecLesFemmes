<?php

namespace App\Entity;

use App\Repository\RemboursementRepository;
use App\Trait\DateTimeTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RemboursementRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Remboursement
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $montantRemboursement = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateRemboursement = null;

    #[ORM\ManyToOne(inversedBy: 'remboursements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pret $pret = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantRemboursement(): ?int
    {
        return $this->montantRemboursement;
    }

    public function setMontantRemboursement(int $montantRemboursement): static
    {
        $this->montantRemboursement = $montantRemboursement;

        return $this;
    }

    public function getDateRemboursement(): ?\DateTimeImmutable
    {
        return $this->dateRemboursement;
    }

    public function setDateRemboursement(\DateTimeImmutable $dateRemboursement): static
    {
        $this->dateRemboursement = $dateRemboursement;

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