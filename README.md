# AvecLesFemmes

Application web Symfony de gestion de calebasses participatives (épargne et tontine) pour des groupements de femmes. Projet réalisé dans le cadre du cours de Symfony.

## Fonctionnalités prévues

- Gestion des membres et de leurs rôles (admin, secrétaire, trésorière, membre simple)
- Gestion des campagnes d'épargne et de tontine
- Gestion des séances, des présences et des cotisations
- Gestion des prêts, des remboursements et des amendes

## Prérequis

- PHP 8.2 ou plus
- Composer
- Symfony CLI
- PostgreSQL
- Git

## Installation

1. Cloner le dépôt puis installer les dépendances : `composer install`
2. Créer un fichier `.env.local` à la racine avec la connexion à la base :
   `DATABASE_URL="postgresql://utilisateur:motdepasse@127.0.0.1:5432/avec_les_femmes?serverVersion=18&charset=utf8"`
3. Lancer le serveur : `symfony serve`

## Documentation

Les diagrammes de cas d'utilisation et de classes se trouvent dans le dossier `docs/`.