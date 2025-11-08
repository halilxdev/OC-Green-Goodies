![Logo Green Goodies](https://github.com/halilxdev/OC-Green-Goodies/blob/main/misc/logo.webp)

# Green Goodies — Site e-commerce

> J'ai réalisé ce projet lors de ma formation OpenClassRooms. Ce projet implique la création d'un projet en Symfony.
> Après avoir passé deux semaines en séparant le back et le front via deux projets Symfony, je pense que le mieux est, comme le suggère le projet, de faire une App monolithique. 
> J'ai également pris la liberté d'utiliser Docker.

## Lancer le projet

Pour visualiser ou manipuler le projet, assurez-vous d'avoir Docker desktop.

* `docker compose up -d --build` pour lancer les containers pour la première fois
* `docker compose up -d` pour lancer les containers
* `docker compose down` pour éteindre les containers

## Liens accessibles

* http://localhost:8000/    Pour l'application
* http://localhost:8081/    Pour PHPMyAdmin

## Liste de commandes

* `docker exec -it green_goodies_app php bin/console <commande symfony>`

### Base de données

#### Suppression de la base de données
En cas de souci avec la base de données, supprimez ce qu'il se trouve dans le dossier `migrations` et exécutez cette commande
* `docker exec -it green_goodies_app php bin/console doctrine:database:drop --force`


#### Création de la base de données
* `docker exec -it green_goodies_app php bin/console doctrine:database:create`
#### Mise à jour de la base de données
* `docker exec -it green_goodies_app php bin/console make:migration`
* `docker exec -it green_goodies_app php bin/console doctrine:migrations:migrate`
#### Création des fixtures pour avoir des données prédéfinies dans la base de données
* `docker exec -it green_goodies_app php bin/console doctrine:fixtures:load`

## To-do list !

### ÉTAPE 2

- [x] Créer et configurez votre base de données.
- [x] Créer les entités à partir du modèle des données et les repositories associés.  
![Diagramme UML](https://github.com/halilxdev/OC-Green-Goodies/blob/main/misc/UML.png)  
- [x] Créer 9 produits à l’aide de fixtures.
- [x] Créer en réalisant la structure générale (header / footer) dynamique selon l'état de l'utilisateur (connecté ou non).

### ÉTAPE 3

- [ ] Système de connexion
    - [x] Création des templates et des forms
    - [x] Système simple fonctionnel
    - [ ] Système sécurisé (Asserts sur les Entity, Vérification dans le Controller)
- [x] Gérer la récup. DQL et l'affichage des produits et de la liste de produits.
- [x] Mise en place du système de commandes.
    - [x] Route pour ajouter un produit au panier
    - [x] Extension Twig pour afficher le nombre de produits dans le panier
    - [x] Route pour afficher le panier
    - [x] Route pour vider le panier
    - [ ] Transformation d'un panier en commande/facture
    - [ ] IMPORTANT -> Order -> Faire une vérif si facture existante pour créer un nouvel order per user
- [ ] Création de la page Mon Compte

### ÉTAPE 4

- [ ] Développer un Controller API
- [ ] EventSubscriber
- [ ] Se renseigner sur le [CSS/JS Minifier](https://github.com/sensiolabs/minify-bundle)

### BONUS

- [ ] Confirmation flash (Javascript) [Ajout au panier, Activation de l'accès API, etc...]
- [ ] Front-End Responsive

## Cheatsheet

### Git

* `git commit -m 'Contenu du commit'` Commit avec message
* `git commit --allow-empty-message -m ''` Commit sans message
* `git rm --cached -r <file>` Supprimer un fichier ou un dossier dans le dépôt distant (il faut le commit)
* `git add -u .` Commit avec suppression des fichiers supprimés localement // Il faut être à la racine du projet
* `git branch -d <nomDeLaBranche>` Permet de supprimer une branche en local
* `git push -d origin <nomDeLaBranche>` Permet de supprimer une branche sur le dépot distant