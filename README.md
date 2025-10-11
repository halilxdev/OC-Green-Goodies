# Green Goodies — Site e-commerce

> J'ai réalisé ce projet lors de ma formation OpenClassRooms. Ce projet implique la création en Symfony d'un front-end et d'un back-end API.
> J'ai choisi délibérement de dissocier le front-end et le back-end pour des raisons de bonne pratique.
> J'ai également pris la liberté d'utiliser Docker.

## Lancer le projet

Pour visualiser ou manipuler le projet, assurez-vous d'avoir Docker desktop.

`docker compose up -d`

`docker compose up -d --build`

`docker compose down`

## Liens accessibles

* http://localhost:8080/ `Pour le front-end`
* http://localhost:8000/ `Pour le back-end (pas utile car pas de HTML renvoyé)`
* http://localhost:8081/ `Pour PHPMyAdmin`

* `docker exec -it green_goodies_backend php bin/console doctrine:database:create`

# To-do list !

[x] Dockeriser le projet