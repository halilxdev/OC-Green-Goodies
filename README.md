# Green Goodies — Site e-commerce

![Logo Green Goodies](https://github.com/halilxdev/OC-Green-Goodies/blob/main/misc/logo.webp)

> J'ai réalisé ce projet lors de ma formation OpenClassRooms. Ce projet implique la création en Symfony d'un front-end et d'un back-end API.
> J'ai choisi délibérement de dissocier le front-end et le back-end pour des raisons de bonne pratique.
> J'ai également pris la liberté d'utiliser Docker.

## Lancer le projet

Pour visualiser ou manipuler le projet, assurez-vous d'avoir Docker desktop.

* `docker compose up -d --build` pour lancer les containers pour la première fois
* `docker compose up -d` pour lancer les containers
* `docker compose down` pour clôtirer les containers

## Liens accessibles

* http://localhost:8080/ `Pour le front-end`
* http://localhost:8000/ `Pour le back-end (pas utile car pas de HTML renvoyé)`
* http://localhost:8081/ `Pour PHPMyAdmin`

## Liste de commandes

* `docker exec -it green_goodies_frontend php bin/console`
* `docker exec -it green_goodies_backend php bin/console`

### Base de données

#### Création de la base de données
* `docker exec -it green_goodies_backend php bin/console doctrine:database:create`

# To-do list !

[x] Dockeriser le projet