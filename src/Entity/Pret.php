<?php

namespace App\Entity;

use App\Repository\PretRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Trait\DateTimeTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\StatutPret;

#[ORM\Entity(repositoryClass: PretRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Pret
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $montantPret = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateDemande = null;

    #[ORM\Column]
    private ?int $duree = null;

    #[ORM\Column]
    private ?float $tauxInteretPret = null;

    #[ORM\ManyToOne(inversedBy: 'prets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Membre $membre = null;

    #[ORM\ManyToOne(inversedBy: 'prets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ConditionPret $conditionPret = null;
    #[ORM\Column(enumType: StatutPret::class)]
    private ?StatutPret $statutPret = null;

    /**
     * @var Collection<int, Remboursement>
     */
    #[ORM\OneToMany(targetEntity: Remboursement::class, mappedBy: 'pret')]
    private Collection $remboursements;

    /**
     * @var Collection<int, Amende>
     */
    #[ORM\OneToMany(targetEntity: Amende::class, mappedBy: 'pret')]
    private Collection $amendes;

    public function __construct()
    {
        $this->remboursements = new ArrayCollection();
        $this->amendes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantPret(): ?int
    {
        return $this->montantPret;
    }

    public function setMontantPret(int $montantPret): static
    {
        $this->montantPret = $montantPret;

        return $this;
    }

    public function getDateDemande(): ?\DateTimeImmutable
    {
        return $this->dateDemande;
    }

    public function setDateDemande(\DateTimeImmutable $dateDemande): static
    {
        $this->dateDemande = $dateDemande;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getTauxInteretPret(): ?float
    {
        return $this->tauxInteretPret;
    }

    public function setTauxInteretPret(float $tauxInteretPret): static
    {
        $this->tauxInteretPret = $tauxInteretPret;

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

    public function getConditionPret(): ?ConditionPret
    {
        return $this->conditionPret;
    }

    public function setConditionPret(?ConditionPret $conditionPret): static
    {
        $this->conditionPret = $conditionPret;

        return $this;
    }
        public function getStatutPret(): ?StatutPret
    {
        return $this->statutPret;
    }

    public function setStatutPret(StatutPret $statutPret): static
    {
        $this->statutPret = $statutPret;

        return $this;
    }

    /**
     * @return Collection<int, Remboursement>
     */
    public function getRemboursements(): Collection
    {
        return $this->remboursements;
    }

    public function addRemboursement(Remboursement $remboursement): static
    {
        if (!$this->remboursements->contains($remboursement)) {
            $this->remboursements->add($remboursement);
            $remboursement->setPret($this);
        }

        return $this;
    }

    public function removeRemboursement(Remboursement $remboursement): static
    {
        if ($this->remboursements->removeElement($remboursement)) {
            // set the owning side to null (unless already changed)
            if ($remboursement->getPret() === $this) {
                $remboursement->setPret(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Amende>
     */
    public function getAmendes(): Collection
    {
        return $this->amendes;
    }

    public function addAmende(Amende $amende): static
    {
        if (!$this->amendes->contains($amende)) {
            $this->amendes->add($amende);
            $amende->setPret($this);
        }

        return $this;
    }

    public function removeAmende(Amende $amende): static
    {
        if ($this->amendes->removeElement($amende)) {
            // set the owning side to null (unless already changed)
            if ($amende->getPret() === $this) {
                $amende->setPret(null);
            }
        }

        return $this;
    }
}