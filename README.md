# AvecLesFemmes

Application web Symfony de gestion de calebasses participatives (épargne et tontine) pour des groupements de femmes. Projet réalisé dans le cadre du cours de Symfony.

## Fonctionnalités prévues

- Gestion des membres et de leurs profils (admin, secrétaire, trésorière, membre simple)
- Gestion des campagnes d'épargne et de tontine, avec le mode de cotisation de chaque membre
- Gestion des séances, des présences et des cotisations
- Gestion des prêts, des remboursements et des amendes

## Prérequis

- PHP 8.2 ou plus
- Composer
- Symfony CLI
- PostgreSQL (testé avec la version 18)
- Git

## Installation

1. Cloner le dépôt puis installer les dépendances : `composer install`
2. Créer un fichier `.env.local` à la racine avec la connexion à la base (ce fichier n'est jamais versionné) :
   `DATABASE_URL="postgresql://utilisateur:motdepasse@127.0.0.1:5432/avec_les_femmes?serverVersion=18&charset=utf8"`
3. Créer la base : `composer diopcoumbathiep:db:create`
4. Générer et exécuter la migration : `composer diopcoumbathiep:migration`
5. Charger les données de démonstration : `composer diopcoumbathiep:fixtures`
6. Lancer le serveur : `symfony serve`

## Commandes personnalisées

Les commandes sont déclarées dans la section `scripts` de `composer.json`, préfixées par `diopcoumbathiep`. Elles remplacent les commandes natives de Symfony.

| Commande | Rôle | Moment d'exécution |
|---|---|---|
| `composer diopcoumbathiep:cache:clear` | Vide le cache | À la demande, et automatiquement après `composer install` et `composer update` |
| `composer diopcoumbathiep:db:create` | Supprime la base si elle existe puis la recrée | À la demande uniquement |
| `composer diopcoumbathiep:make:entity` | Crée ou modifie une entité | À la demande uniquement |
| `composer diopcoumbathiep:migration` | Génère la migration puis l'exécute | À la demande uniquement |
| `composer diopcoumbathiep:fixtures` | Vide les tables puis charge les données de démonstration | À la demande uniquement |

La commande `make:entity` passe par la classe `App\Composer\Commandes`, car sous Windows Composer ne transmet pas le clavier à une commande interactive lancée directement.

## Modèle de données

- `Groupement` (statut : enum `StatutGroupement`), avec ses `Exercice` (statut : enum `StatutExercice`)
- `Membre` (classe abstraite) : `Admin`, `Secretaire`, `Tresoriere`, `MembreSimple` (héritage à table unique)
- `TypeCampagne` (classe abstraite) : `Epargne`, `Tontine` (héritage à table unique)
- `Campagne`, rattachée à un exercice : périodicité (enum `Periodicite`), jour de rencontre, montants de caisse (présente, absente représentée) et amende journalière
- `ModeCotisation` : lien entre un membre et une campagne
- `Seance` (statut : enum `StatutSeance`), `Presence` (statut : enum `StatutPresence`), `Cotisation` (épargne + caisse)
- `ConditionPret`, `Pret` (statut : enum `StatutPret`), `Remboursement`, `Amende` (absence ou retard de prêt)
- Le trait `DateTimeTrait` ajoute `createAt` et `updateAt` à toutes les entités, remplis automatiquement par les callbacks Doctrine `PrePersist` et `PreUpdate`

## Architecture

Chaque page suit le chemin Contrôleur → Service → Repository → DTO :

- `src/Controller` : reçoit la requête, appelle le service, transmet les DTO à la vue (aucun traitement métier)
- `src/Service` : assemble les données et calcule les totaux
- `src/Repository` : requêtes Doctrine (exercice en cours, totaux par séance…)
- `src/Dto` : objets envoyés aux vues. Les dates y sont déjà converties en texte (`src/Util/DateFr`) et seul l'exercice en cours est exposé

## Pages

| URL | Contenu |
|---|---|
| `/groupements` | Liste des groupements avec leur exercice en cours |
| `/groupements/{id}` | Détail d'un groupement : exercice en cours, campagnes, historique des exercices |
| `/campagnes/{id}` | Détail d'une campagne : règles de caisse, bilan, séances avec totaux, membres et mode de cotisation |
| `/seances/{id}` | Détail d'une séance : présence et cotisation de chaque membre, amendes, totaux (épargne, caisse, amendes, caisse sociale) |

## Règles de la caisse sociale

- Présente : montant d'épargne + `montantCaissePresent` (ex. 100 FCFA)
- Absente représentée : montant d'épargne + `montantCaisseAbsent` (ex. 300 FCFA)
- Absente sans paiement : amende de `nombreJours` × `montantAmendeJournaliere` (ex. 3 × 350 FCFA)
- Caisse sociale d'une séance = cotisations de caisse + amendes

## Données de démonstration

Les fixtures créent 2 groupements de 10 membres chacun, avec un exercice clôturé et un exercice en cours, 4 campagnes (une épargne calebasse et une tontine par groupement), 16 séances avec leurs présences, cotisations et amendes d'absence, ainsi que des conditions de prêt, des prêts et des remboursements.

## Documentation

Les diagrammes de cas d'utilisation (membre, admin, trésorière, secrétaire) et le diagramme de classes se trouvent dans le dossier `docs/`.

## Organisation Git

- `main` : branche stable, sans développement direct
- `develop` : branche d'intégration
- `feature/NN-nom` : une branche par incrément, fusionnée dans `develop` avec `--no-ff`, puis supprimée
- Messages de commit préfixés : `feat`, `fix`, `refactor`, `docs`, `chore`

| Tag | Contenu |
|---|---|
| `v0.1.0` | Outillage et commandes personnalisées |
| `v0.2.0` | Modélisation (diagrammes) |
| `v0.3.0` | Schéma de base de données généré |
| `v0.4.0` | Fixtures |
| `v0.5.0` | Livrable 2 : exercices, règles de caisse, listes (branches `livrable2/entites`, `livrable2/fixtures`, `livrable2/listes`) |