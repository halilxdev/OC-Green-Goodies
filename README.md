![Logo Green Goodies](https://github.com/halilxdev/OC-Green-Goodies/blob/main/misc/logo.webp)

# Green Goodies — Site e-commerce

> J'ai réalisé ce projet lors de ma formation OpenClassRooms. Ce projet implique la création en Symfony d'un front-end et d'un back-end API.  
> J'ai choisi délibérement de dissocier le front-end et le back-end pour des raisons de bonne pratique.  
> J'ai également pris la liberté d'utiliser Docker.

## Lancer le projet

Pour visualiser ou manipuler le projet, assurez-vous d'avoir Docker desktop.

* `docker compose up -d --build` pour lancer les containers pour la première fois
* `docker compose up -d` pour lancer les containers
* `docker compose down` pour éteindre les containers

## Liens accessibles

* http://localhost:8080/    Pour le front-end
* http://localhost:8000/    Pour le back-end (pas utile de s'y rendre car pas de HTML renvoyé)
* http://localhost:8081/    Pour PHPMyAdmin

## Liste de commandes

* `docker exec -it frontend php bin/console`
* `docker exec -it backend php bin/console`

### Base de données

#### Création de la base de données
* `docker exec -it backend php bin/console doctrine:database:create`
#### Suppression de la base de données
En cas de souci avec la base de données, supprimez ce qu'il se trouve dans le dossier `migrations` et exécutez cette commande
* `docker exec -it backend php bin/console doctrine:database:drop --force`
#### Mise à jour de la base de données
* `docker exec -it backend php bin/console make:migration`
* `docker exec -it backend php bin/console doctrine:migrations:migrate`
#### Création des fixtures pour avoir des données prédéfinies dans la base de données
* `docker exec -it backend php bin/console doctrine:fixtures:load`

## To-do list !

### BACK-END

- [x] Créer et configurez votre base de données.
- [x] Créer les entités à partir du modèle des données et les repositories associés.  
![Diagramme UML](https://github.com/halilxdev/OC-Green-Goodies/blob/main/misc/UML.png)  
- [x] Créer quelques produits à l’aide de fixtures.
- [x] Retravailler la base de données. (Tableau relationnel `order_item_product` inutile)
- [ ] Créer des routes avec des verbes HTTP `GET, POST, PUT, DELETE` pour l'entité `User`
    - [x] `POST`/api/login_check -> Permet de récupérer le token JWT d'un compte existant
    - [x] `POST`/api/user -> Permet de créer un profil
    - [ ] `UPDATE`/api/user -> Permet de mettre à jour un profil
    - [ ] `DELETE`/api/user -> Permet de supprimer un profil
- [ ] EventSubscriber
- [ ] Rendre sécurisé la création de données à partir des entités (Symfony Asserts)

### FRONT-END

- [x] Créer en réalisant la structure générale (header / footer).
- [x] Créer le routeur pour la page d'accueil
- [x] Appeler la base de données pour la page d'accueil
- [ ] Créer les pages de connexion et d'inscription.
- [ ] Se renseigner sur le [CSS/JS Minifier](https://github.com/sensiolabs/minify-bundle)

### BONUS

- [ ] Front-End Responsive

## Cheatsheet

### Git

* `git commit -m 'Contenu du commit'` Commit avec message
* `git commit --allow-empty-message -m ''` Commit sans message
* `git add -u .` Commit avec suppression des fichiers supprimés localement // Il faut être à la racine du projet
* `git branch -d <nomDeLaBranche>` Permet de supprimer une branche en local
* `git push -d origin <nomDeLaBranche>` Permet de supprimer une branche sur le dépot distant