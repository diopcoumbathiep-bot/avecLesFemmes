<?php

namespace App\Dto;

/**
 * DTO de sortie de la liste : les groupements de la page courante
 * et ce qu'il faut a la vue pour afficher la pagination.
 */
final readonly class GroupementPageDto
{
    /**
     * @param GroupementDto[] $groupements
     */
    public function __construct(
        public array $groupements,
        public int $page,
        public int $totalPages,
        public int $total,
        public string $telephone,
        public string $ville,
    ) {
    }

    public function aPagePrecedente(): bool
    {
        return $this->page > 1;
    }

    public function aPageSuivante(): bool
    {
        return $this->page < $this->totalPages;
    }

    public function filtreActif(): bool
    {
        return $this->telephone !== '' || $this->ville !== '';
    }
}