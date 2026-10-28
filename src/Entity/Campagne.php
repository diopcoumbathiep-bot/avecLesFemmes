<?php

namespace App\Entity;

use App\Enum\Periodicite;
use App\Repository\CampagneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use App\Trait\DateTimeTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampagneRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Campagne
{
    use DateTimeTrait;

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

    #[ORM\Column(enumType: Periodicite::class)]
    private ?Periodicite $periodicite = null;

    #[ORM\Column(length: 20)]
    private ?string $jourRencontre = null;

    #[ORM\Column]
    private ?int $montantCaissePresent = null;

    #[ORM\Column]
    private ?int $montantCaisseAbsent = null;

    #[ORM\Column]
    private ?int $montantAmendeJournaliere = null;

    #[ORM\ManyToOne(inversedBy: 'campagnes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeCampagne $typeCampagne = null;

    #[ORM\ManyToOne(inversedBy: 'campagnes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Groupement $groupement = null;

    /**
     * @var Collection<int, ModeCotisation>
     */
    #[ORM\OneToMany(targetEntity: ModeCotisation::class, mappedBy: 'campagne')]
    private Collection $modeCotisations;

    /**
     * @var Collection<int, Seance>
     */
    #[ORM\OneToMany(targetEntity: Seance::class, mappedBy: 'campagne')]
    private Collection $seances;

    public function __construct()
    {
        $this->modeCotisations = new ArrayCollection();
        $this->seances = new ArrayCollection();
    }

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

    public function getPeriodicite(): ?Periodicite
    {
        return $this->periodicite;
    }

    public function setPeriodicite(Periodicite $periodicite): static
    {
        $this->periodicite = $periodicite;

        return $this;
    }

    public function getJourRencontre(): ?string
    {
        return $this->jourRencontre;
    }

    public function setJourRencontre(string $jourRencontre): static
    {
        $this->jourRencontre = $jourRencontre;

        return $this;
    }

    public function getMontantCaissePresent(): ?int
    {
        return $this->montantCaissePresent;
    }

    public function setMontantCaissePresent(int $montantCaissePresent): static
    {
        $this->montantCaissePresent = $montantCaissePresent;

        return $this;
    }

    public function getMontantCaisseAbsent(): ?int
    {
        return $this->montantCaisseAbsent;
    }

    public function setMontantCaisseAbsent(int $montantCaisseAbsent): static
    {
        $this->montantCaisseAbsent = $montantCaisseAbsent;

        return $this;
    }

    public function getMontantAmendeJournaliere(): ?int
    {
        return $this->montantAmendeJournaliere;
    }

    public function setMontantAmendeJournaliere(int $montantAmendeJournaliere): static
    {
        $this->montantAmendeJournaliere = $montantAmendeJournaliere;

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
            $modeCotisation->setCampagne($this);
        }

        return $this;
    }

    public function removeModeCotisation(ModeCotisation $modeCotisation): static
    {
        if ($this->modeCotisations->removeElement($modeCotisation)) {
            // set the owning side to null (unless already changed)
            if ($modeCotisation->getCampagne() === $this) {
                $modeCotisation->setCampagne(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Seance>
     */
    public function getSeances(): Collection
    {
        return $this->seances;
    }

    public function addSeance(Seance $seance): static
    {
        if (!$this->seances->contains($seance)) {
            $this->seances->add($seance);
            $seance->setCampagne($this);
        }

        return $this;
    }

    public function removeSeance(Seance $seance): static
    {
        if ($this->seances->removeElement($seance)) {
            // set the owning side to null (unless already changed)
            if ($seance->getCampagne() === $this) {
                $seance->setCampagne(null);
            }
        }

        return $this;
    }
}