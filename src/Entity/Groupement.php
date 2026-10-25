<?php

namespace App\Entity;

use App\Repository\GroupementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @var Collection<int, ConditionPret>
     */
    #[ORM\OneToMany(targetEntity: ConditionPret::class, mappedBy: 'groupement')]
    private Collection $conditionPrets;

    public function __construct()
    {
        $this->membres = new ArrayCollection();
        $this->campagnes = new ArrayCollection();
        $this->conditionPrets = new ArrayCollection();
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
}
