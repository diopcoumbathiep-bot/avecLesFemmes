<?php

namespace App\Entity;

use App\Repository\SeanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection<int, Presence>
     */
    #[ORM\OneToMany(targetEntity: Presence::class, mappedBy: 'seance')]
    private Collection $presences;

    public function __construct()
    {
        $this->presences = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Presence>
     */
    public function getPresences(): Collection
    {
        return $this->presences;
    }

    public function addPresence(Presence $presence): static
    {
        if (!$this->presences->contains($presence)) {
            $this->presences->add($presence);
            $presence->setSeance($this);
        }

        return $this;
    }

    public function removePresence(Presence $presence): static
    {
        if ($this->presences->removeElement($presence)) {
            // set the owning side to null (unless already changed)
            if ($presence->getSeance() === $this) {
                $presence->setSeance(null);
            }
        }

        return $this;
    }
}
