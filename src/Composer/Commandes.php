<?php

namespace App\Composer;

class Commandes
{
    public static function makeEntity(): void
    {
        passthru('php bin/console make:entity');
    }
}