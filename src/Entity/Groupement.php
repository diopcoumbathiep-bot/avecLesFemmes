<?php

namespace App\Entity;

use App\Repository\GroupementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupementRepository::class)]
class Groupement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nomGroupement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomGroupement(): ?string
    {
        return $this->nomGroupement;
    }

    public function setNomGroupement(string $nomGroupement): static
    {
        $this->nomGroupement = $nomGroupement;

        return $this;
    }
}
