# Readme_test.MD

## Introduction
Ce projet est un exercice PHP pour apprendre à sécuriser une API.

## Prérequis
- PHP 7.4 ou supérieur
- Serveur web (WAMP, XAMPP, etc.)
- Docker

## Installation
1. Clonez le dépôt :
    ```bash
    git clone https://github.com/votre-utilisateur/exercice-php-api-securite.git
    ```
2. Accédez au répertoire du projet :
    ```bash
    cd exercice-php-api-securite
    ```
3. Configurez votre serveur web pour pointer vers ce répertoire.

## Mise en place du Projet
- Lancer Docker :
    ```bash
    docker compose build 
    docker compose up
    ```
- Générer les clés JWT :
    ```bash
    docker compose exec php bin/console lexik:jwt:generate-keypair
    ```
- Charger les fixtures pour les tests : 
    ```bash
    docker compose exec php bin/console doctrine:fixtures:load --no-interaction
    ```
- Accédez à l'API via `http://localhost/exercice-php-api-securite`.

## Gestion des droits d'accès
Les droits d'accès doivent être gérés en fonction des rôles attribués à chaque utilisateur dans une société. Voici comment on pourrait structurer les autorisations :

Les rôles :
Admin : Peut gérer les utilisateurs et projets de la société.
Manager : Peut gérer les projets de la société.
Consultant : Peut seulement consulter les projets.

### Classe Voter
Voter est une classe Symfony qui décide si un utilisateur a la permission d'effectuer des actions .

Créer la classe Voter avec le CLI : 
    ```bash
    php bin/console make:voter SocietyVoter
    ```

## Licence
Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.