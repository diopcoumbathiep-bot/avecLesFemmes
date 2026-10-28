<?php

namespace App\Entity;

use App\Enum\StatutPresence;
use App\Repository\PresenceRepository;
use App\Trait\DateTimeTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PresenceRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Presence
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: StatutPresence::class)]
    private ?StatutPresence $statut = null;

    #[ORM\ManyToOne(inversedBy: 'presences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Seance $seance = null;

    #[ORM\ManyToOne(inversedBy: 'presences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Membre $membre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatut(): ?StatutPresence
    {
        return $this->statut;
    }

    public function setStatut(StatutPresence $statut): static
    {
        $this->statut = $statut;

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