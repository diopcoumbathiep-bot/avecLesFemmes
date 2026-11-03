<?php

namespace App\Dto;

use App\Entity\Groupement;
use App\Enum\StatutGroupement;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DTO d'entree du formulaire de groupement (creation et modification).
 * Le formulaire ecrit directement dans ses proprietes, le controleur le donne au service.
 * Il n'est pas readonly : le composant Form doit pouvoir le modifier.
 */
final class GroupementFormDto
{
    #[Assert\NotBlank(message: 'Le nom du groupement est obligatoire.')]
    #[Assert\Length(max: 100, maxMessage: 'Le nom ne doit pas depasser {{ limit }} caracteres.')]
    public ?string $nom = null;

    #[Assert\NotBlank(message: 'Le telephone est obligatoire.')]
    #[Assert\Regex(
        pattern: '/^(70|75|76|77|78)\d{7}$/',
        message: 'Le telephone doit comporter 9 chiffres et commencer par 70, 75, 76, 77 ou 78.',
    )]
    public ?string $tel = null;

    #[Assert\Length(max: 255, maxMessage: 'L\'adresse ne doit pas depasser {{ limit }} caracteres.')]
    public ?string $adresse = null;

    #[Assert\NotNull(message: 'Le statut est obligatoire.')]
    public ?StatutGroupement $statut = StatutGroupement::ACTIF;

    /**
     * Pre-remplit le formulaire de modification a partir de l'entite.
     */
    public static function fromEntity(Groupement $groupement): self
    {
        $dto = new self();
        $dto->nom = $groupement->getNomGroupement();
        $dto->tel = $groupement->getTel();
        $dto->adresse = $groupement->getAdresse();
        $dto->statut = $groupement->getStatut();

        return $dto;
    }
}