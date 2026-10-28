<?php

namespace App\Entity;

use App\Repository\MembreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Trait\DateTimeTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MembreRepository::class)]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap([
    'admin' => Admin::class,
    'secretaire' => Secretaire::class,
    'tresoriere' => Tresoriere::class,
    'membre_simple' => MembreSimple::class,
])]
#[ORM\HasLifecycleCallbacks]
abstract class Membre
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $nomComplet = null;

    #[ORM\Column(length: 20)]
    private ?string $telMembre = null;

    #[ORM\Column(length: 255)]
    private ?string $adresseMembre = null;

    #[ORM\Column(length: 100)]
    private ?string $login = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\ManyToOne(inversedBy: 'membres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Groupement $groupement = null;

    /**
     * @var Collection<int, ModeCotisation>
     */
    #[ORM\OneToMany(targetEntity: ModeCotisation::class, mappedBy: 'membre')]
    private Collection $modeCotisations;

    /**
     * @var Collection<int, Presence>
     */
    #[ORM\OneToMany(targetEntity: Presence::class, mappedBy: 'membre')]
    private Collection $presences;

    /**
     * @var Collection<int, Cotisation>
     */
    #[ORM\OneToMany(targetEntity: Cotisation::class, mappedBy: 'membre')]
    private Collection $cotisations;

    /**
     * @var Collection<int, Pret>
     */
    #[ORM\OneToMany(targetEntity: Pret::class, mappedBy: 'membre')]
    private Collection $prets;

    /**
     * @var Collection<int, Amende>
     */
    #[ORM\OneToMany(targetEntity: Amende::class, mappedBy: 'membre')]
    private Collection $amendes;

    public function __construct()
    {
        $this->amendes = new ArrayCollection();
        $this->modeCotisations = new ArrayCollection();
        $this->presences = new ArrayCollection();
        $this->cotisations = new ArrayCollection();
        $this->prets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomComplet(): ?string
    {
        return $this->nomComplet;
    }

    public function setNomComplet(string $nomComplet): static
    {
        $this->nomComplet = $nomComplet;

        return $this;
    }

    public function getTelMembre(): ?string
    {
        return $this->telMembre;
    }

    public function setTelMembre(string $telMembre): static
    {
        $this->telMembre = $telMembre;

        return $this;
    }

    public function getAdresseMembre(): ?string
    {
        return $this->adresseMembre;
    }

    public function setAdresseMembre(string $adresseMembre): static
    {
        $this->adresseMembre = $adresseMembre;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): static
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

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

    /**
     * @return Collection<int, ModeCotisation>
     */
    public function getModeCotisations(): Collection
    {
        return $this->modeCotisations;
    }

    public function addModeCotisation(ModeCotisation $modeCotisation): static
    {
        if (!$this->modeCotisations->contains($modeCotisation)) {
            $this->modeCotisations->add($modeCotisation);
            $modeCotisation->setMembre($this);
        }

        return $this;
    }

    public function removeModeCotisation(ModeCotisation $modeCotisation): static
    {
        if ($this->modeCotisations->removeElement($modeCotisation)) {
            // set the owning side to null (unless already changed)
            if ($modeCotisation->getMembre() === $this) {
                $modeCotisation->setMembre(null);
            }
        }

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
            $presence->setMembre($this);
        }

        return $this;
    }

    public function removePresence(Presence $presence): static
    {
        if ($this->presences->removeElement($presence)) {
            // set the owning side to null (unless already changed)
            if ($presence->getMembre() === $this) {
                $presence->setMembre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Cotisation>
     */
    public function getCotisations(): Collection
    {
        return $this->cotisations;
    }

    public function addCotisation(Cotisation $cotisation): static
    {
        if (!$this->cotisations->contains($cotisation)) {
            $this->cotisations->add($cotisation);
            $cotisation->setMembre($this);
        }

        return $this;
    }

    public function removeCotisation(Cotisation $cotisation): static
    {
        if ($this->cotisations->removeElement($cotisation)) {
            // set the owning side to null (unless already changed)
            if ($cotisation->getMembre() === $this) {
                $cotisation->setMembre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Pret>
     */
    public function getPrets(): Collection
    {
        return $this->prets;
    }

    public function addPret(Pret $pret): static
    {
        if (!$this->prets->contains($pret)) {
            $this->prets->add($pret);
            $pret->setMembre($this);
        }

        return $this;
    }

    public function removePret(Pret $pret): static
    {
        if ($this->prets->removeElement($pret)) {
            // set the owning side to null (unless already changed)
            if ($pret->getMembre() === $this) {
                $pret->setMembre(null);
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
            $amende->setMembre($this);
        }

        return $this;
    }

    public function removeAmende(Amende $amende): static
    {
        if ($this->amendes->removeElement($amende)) {
            if ($amende->getMembre() === $this) {
                $amende->setMembre(null);
            }
        }

        return $this;
    }
}