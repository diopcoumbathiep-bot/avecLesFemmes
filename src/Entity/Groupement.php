<?php

namespace App\Entity;

use App\Enum\StatutGroupement;
use App\Repository\GroupementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Trait\DateTimeTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupementRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Groupement
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nomGroupement = null;

    #[ORM\Column(length: 20)]
    private ?string $tel = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(enumType: StatutGroupement::class)]
    private ?StatutGroupement $statut = StatutGroupement::ACTIF;

    /**
     * @var Collection<int, Membre>
     */
    #[ORM\OneToMany(targetEntity: Membre::class, mappedBy: 'groupement')]
    private Collection $membres;

    /**
     * @var Collection<int, Campagne>
     */
    #[ORM\OneToMany(targetEntity: Campagne::class, mappedBy: 'groupement')]
    private Collection $campagnes;

    /**
     * @var Collection<int, Exercice>
     */
    #[ORM\OneToMany(targetEntity: Exercice::class, mappedBy: 'groupement', orphanRemoval: true)]
    #[ORM\OrderBy(['debutAt' => 'DESC'])]
    private Collection $exercices;

    /**
     * @var Collection<int, ConditionPret>
     */
    #[ORM\OneToMany(targetEntity: ConditionPret::class, mappedBy: 'groupement')]
    private Collection $conditionPrets;

    public function __construct()
    {
        $this->membres = new ArrayCollection();
        $this->campagnes = new ArrayCollection();
        $this->conditionPrets = new ArrayCollection();
        $this->exercices = new ArrayCollection();
    }

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

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): static
    {
        $this->tel = $tel;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getStatut(): ?StatutGroupement
    {
        return $this->statut;
    }

    public function setStatut(StatutGroupement $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return Collection<int, Membre>
     */
    public function getMembres(): Collection
    {
        return $this->membres;
    }

    public function addMembre(Membre $membre): static
    {
        if (!$this->membres->contains($membre)) {
            $this->membres->add($membre);
            $membre->setGroupement($this);
        }

        return $this;
    }

    public function removeMembre(Membre $membre): static
    {
        if ($this->membres->removeElement($membre)) {
            // set the owning side to null (unless already changed)
            if ($membre->getGroupement() === $this) {
                $membre->setGroupement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Campagne>
     */
    public function getCampagnes(): Collection
    {
        return $this->campagnes;
    }

    public function addCampagne(Campagne $campagne): static
    {
        if (!$this->campagnes->contains($campagne)) {
            $this->campagnes->add($campagne);
            $campagne->setGroupement($this);
        }

        return $this;
    }

    public function removeCampagne(Campagne $campagne): static
    {
        if ($this->campagnes->removeElement($campagne)) {
            // set the owning side to null (unless already changed)
            if ($campagne->getGroupement() === $this) {
                $campagne->setGroupement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ConditionPret>
     */
    public function getConditionPrets(): Collection
    {
        return $this->conditionPrets;
    }

    public function addConditionPret(ConditionPret $conditionPret): static
    {
        if (!$this->conditionPrets->contains($conditionPret)) {
            $this->conditionPrets->add($conditionPret);
            $conditionPret->setGroupement($this);
        }

        return $this;
    }

    public function removeConditionPret(ConditionPret $conditionPret): static
    {
        if ($this->conditionPrets->removeElement($conditionPret)) {
            // set the owning side to null (unless already changed)
            if ($conditionPret->getGroupement() === $this) {
                $conditionPret->setGroupement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Exercice>
     */
    public function getExercices(): Collection
    {
        return $this->exercices;
    }

    public function addExercice(Exercice $exercice): static
    {
        if (!$this->exercices->contains($exercice)) {
            $this->exercices->add($exercice);
            $exercice->setGroupement($this);
        }

        return $this;
    }

    public function removeExercice(Exercice $exercice): static
    {
        if ($this->exercices->removeElement($exercice)) {
            if ($exercice->getGroupement() === $this) {
                $exercice->setGroupement(null);
            }
        }

        return $this;
    }
}