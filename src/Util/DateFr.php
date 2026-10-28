<?php

namespace App\Util;

/**
 * Transforme une date en texte francais pour les DTO.
 * Les vues ne recoivent jamais d'objet DateTime.
 */
final class DateFr
{
    private const MOIS = [
        1 => 'janvier', 'février', 'mars', 'avril', 'mai', 'juin',
        'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre',
    ];

    private const JOURS = [
        1 => 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche',
    ];

    /** 27 octobre 2026 */
    public static function longue(?\DateTimeInterface $date): string
    {
        if ($date === null) {
            return '—';
        }

        return $date->format('j') . ' ' . self::MOIS[(int) $date->format('n')] . ' ' . $date->format('Y');
    }

    /** dimanche 27 octobre 2026 */
    public static function avecJour(?\DateTimeInterface $date): string
    {
        if ($date === null) {
            return '—';
        }

        return self::JOURS[(int) $date->format('N')] . ' ' . self::longue($date);
    }

    /** 27/10/2026 */
    public static function courte(?\DateTimeInterface $date): string
    {
        return $date === null ? '—' : $date->format('d/m/Y');
    }
}