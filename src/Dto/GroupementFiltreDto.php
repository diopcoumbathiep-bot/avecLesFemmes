<?php

namespace App\Dto;

/**
 * DTO d'entree du formulaire de filtre : ce que l'utilisateur tape (telephone, ville)
 * et la page demandee. Il est rempli par le formulaire puis envoye au service.
 */
final class GroupementFiltreDto
{
    public ?string $telephone = null;

    public ?string $ville = null;

    public int $page = 1;
}