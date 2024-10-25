# NRV.net

## Membres du groupe :
- AUGER Benjamin
- BENCHERGUI Timothée
- BIECHY Maxime
- KHENFER Vadim


## Liens utiles :
Lien github :
- [Github](https://github.com/MaximeBiechy/NRV.net)
Pour le tableau de bord :
- [Trello](https://trello.com/invite/b/671606b9a621c991bbfbdbcf/ATTI347b9a8a5d751f01d1a7904350e3f333E7D484AA/nrv)

Pour les maquettes :
- [Figma](https://www.figma.com/design/J5tfFdFLmFty3NlROJSx8Q/NRV?node-id=0-1&t=P17VER0GD6nMLpdj-1)

Docketu :
- [Docketu](http://docketu.iutnc.univ-lorraine.fr:21001)

Le diagramme des entités : 
<img src="/api/diagrams/diagram_class_entity.png" alt="diagramme de classe des entités de l'api">

## Description du projet
Il ne faut pas oublier de créer les fichier ini pour les bases de données et les fichiers .env pour les variables d'environnement.
auth.ini, party.ini, place.ini, shows.ini, tickets.ini
nrv.env nrvdb.env

On a deux utlisateur pour la connexion :

- greg@gmail.com mdp: greg
- tim@gmail.com mdp: tim

## Tableau des fonctionnalités

| Fonctionnalité                                                                                                       | Backend                               | Frontend                     |
|----------------------------------------------------------------------------------------------------------------------|---------------------------------------|------------------------------|
| Affichage de la liste des spectacles                                                                                 | Timothée Benchergui                   | Benjamin Auger               |
| Affichage du détail d’une soirée                                                                                     | Timothée Benchergui                   | Benjamin Auger               |
| En cliquant sur un spectacle dans la liste                                                                           | Timothée Benchergui                   | Benjamin Auger               |
| Filtrage de la liste des spectacles par date                                                                         | Timothée Benchergui                   | Vadim Khenfer Benjamin Auger |
| Filtrage de la liste des spectacles par style                                                                        | Timothée Benchergui                   | Vadim Khenfer Benjamin Auger |
| Filtrage de la liste des spectacles par lieu                                                                         | Timothée Benchergui                   | Vadim Khenfer Benjamin Auger |
| Inscription sur la plateforme et création d’un compte                                                                | Maxime Biechy                         | Benjamin Auger               |
| Accès aux billets achetés (« mes billets »)                                                                          | Maxime Biechy                         | Benjamin Auger               |
| Lors de la visualisation d’une soirée, possibilité d’ajouter des billets d’entrée pour cette soirée dans un panier   | Maxime Biechy                         |  Vadim Khenfer               |
| Visualisation de l’état courant du panier, calcul et affichage du montant total                                      | Timothée Benchergui                   | Vadim Khenfer                |
| Validation du panier et transformation en commande, validation de la commande                                        | Timothée Benchergui                   | Vadim Khenfer                |
| Paiement de la commande                                                                                              | Maxime Biechy                         | Vadim Khenfer                |
| Création des billets                                                                                                 | Maxime Biechy                         | Benjamin Auger               |
| Affichage de la jauge des spactacles                                                                                 | Timothée Benchergui                   | Benjamin Auger               |
| Pagination de la liste de spectacles                                                                                 | Timothée Benchergui                   | Benjamin Auger               |
| Modification du panier                                                                                               | Maxime Biechy                         | Pas fait                     |
| Backoffice : ajouter des spectacles et des soirées.                                                                  | Maxime Biechy                         | Pas fait                     |
| Backoffice : gérer les lieux et le nombre de places sur chaque lieu.                                                 | Maxime Biechy                         | Pas fait                     |
| Backoffice : vente de billets à l’entrée des soirées.                                                                | Pas fait                              | Pas fait                     |
| Panier persistant                                                                                                    | Timothée Benchergui / Maxime Biechy   | X                            |
| Vérification des places disponibles dans un panier avant paiement                                                    | Maxime Biechy                         | X                            |

## Les routes de l'API

| Méthode | Route                         | Variables  / Body                                                                                                                                                                                                                                                                                                                                                                                                         | Description                                                |
|---------|-------------------------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|------------------------------------------------------------|
| GET     | /shows                        | date: prend la valeur d'une date filtrer par date <br> style: prend la valeur d'un nom de style pour filtrer par style <br> place: prend la valeur d'un nom de lieu pour filtrer par lieu <br> page: prend la valeur d'un numéro de page et permet de faire de la pagination sur le résultat                                                                                                                              | Récupère la liste des spectacles                           |
| GET     | /shows/{ID-SHOW}              | none                                                                                                                                                                                                                                                                                                                                                                                                                      | Récupère le détail d'un spectacle grâce à son id           |
| GET     | /shows/{ID-SHOW}/party        | none                                                                                                                                                                                                                                                                                                                                                                                                                      | Récupère la liste des soirées  via un spectacle et son id  |
| POST    | /shows                        | title: titre du spectacle <br> description: description du spectacle <br> video : la vidéo du spectacle <br> images : une liste avec les liens des images du spectacle <br> artists: la liste des artists <br> date : la date du spectacle + heure, minute                                                                                                                                                                | Crée un spectacle que quand on est admin                   |
| GET     | /party                        | none                                                                                                                                                                                                                                                                                                                                                                                                                      | Récupère la liste des soirées                              |
| GET     | /party/{ID-PARTY}             | none                                                                                                                                                                                                                                                                                                                                                                                                                      | Récupère le détail d'une soirée grâce à son id             |
| POST    | /party                        | name: nom de la soirée <br> theme: thème de la soirée <br> date: date de la soirée <br> begin: heure de début de la soirée <br> place_id: id du lieu <br> shows: liste des spectacles <br> price: prix de la soirée                                                                                                                                                                                                       | Crée une soirée que quand on est admin                     |
| GET     | /parties/{ID-PARTY}/tickets   | none                                                                                                                                                                                                                                                                                                                                                                                                                      | Récupère la liste des billets d'une soirée                 |
| GET     | /parties/gauge                | none                                                                                                                                                                                                                                                                                                                                                                                                                      | Récupère la jauge des spectacles                           |
| GET     | /parties/{ID-PARTY}/gauge     | none                                                                                                                                                                                                                                                                                                                                                                                                                      | Récupère la jauge d'une soirée grâce à son id              |
| GET     | /artists                      | page: prend la valeur d'un numéro de page et permet de faire de la pagination sur le résultat                                                                                                                                                                                                                                                                                                                             | Récupère la liste des artistes                             |
| GET     | /artists/{ID-ARTIST}          | none                                                                                                                                                                                                                                                                                                                                                                                                                      | Récupère le détail d'un artiste grâce à son id             |
| GET     | /places                       | none                                                                                                                                                                                                                                                                                                                                                                                                                      | Récupère la liste des lieux                                |
| GET     | /places/{ID-PLACE}            | none                                                                                                                                                                                                                                                                                                                                                                                                                      | Récupère le détail d'un lieu grâce à son id                |
| PATCH   | /places/{ID-PLACE}            | name: pour changer le nom du lieu <br> address: pour changer l'adresse du lieu <br> nb_sit: nombre de places assises <br> nbStand: pour modifier le nombre de place debout pour le lieu <br>  nbSit: pour modifier le nombre de place assise pour le lieu <br> images : une liste d'url d'images                                                                                                                          | Modifie un lieu que quand on est admin                     |
| GET     | /styles                       | none                                                                                                                                                                                                                                                                                                                                                                                                                      | Récupère la liste des styles                               |
| GET     | /tickets                      | none                                                                                                                                                                                                                                                                                                                                                                                                                      | Récupère la liste des billets en vente                     |
| GET     | /tickets/{ID-TICKET}          | none                                                                                                                                                                                                                                                                                                                                                                                                                      | Récupère le détail d'un billet grâce à son id              |
| GET     | /users/{ID-USER}/cart         | none                                                                                                                                                                                                                                                                                                                                                                                                                      | Récupère le panier d'un utilisateur                        |
| PATCH   | /carts/{ID-CART}              | Variables : state: prend la valeur 0 pour modifier la quantité de ticket dans le panier (il faut dans le body l'id du ticket "ticket_id" et la quantité "quantity") <br> prend la valeur 1 pour valider la panier <br> prend la valeur 2 pour valider la commande <br> prend la valeur 3 pour payer le panier (ajouter dans le body le numéro de la cb "num_cb", la date d'expiration "date_exp" et le numéro cvc "code") | Modifie l'état du panier d'un utilisateur                  |
| GET     | /users/{ID-USER}/sold_tickets | none                                                                                                                                                                                                                                                                                                                                                                                                                      | Récupère la liste des billets achetés par un utilisateur   |
| PATCH   | /carts/{ID-CART}/ticket       | ticket_id: id du ticket à ajouter dans le panier                                                                                                                                                                                                                                                                                                                                                                          | Ajout d'un ticket au panier                                |
| POST    | /signup                       | email: email de l'utilisateur <br> password: mot de passe de l'utilisateur  (l'email et le mot de passe sont récupérer dans le header Authorization et sont encodé en base 64)                                                                                                                                                                                                                                            | Crée un utilisateur                                        |
| POST    | /signin                       | email: email de l'utilisateur <br> password: mot de passe de l'utilisateur  (l'email et le mot de passe sont récupérer dans le header Authorization et sont encodé en base 64)                                                                                                                                                                                                                                            | Connecte un utilisateur                                    |
| POST    | /refresh                      | refresh_token: token de rafraichissement de l'utilisateur (le token est récupérer dans le header Authorization et est encodé en base 64)                                                                                                                                                                                                                                                                                  | Rafraichit le token de l'utilisateur                       |



## Les scripts SQL

<strong> Le projet utilise 5 bases de données différentes : </strong>

<ul>
    <li>nrv_auth : pour les utilisateurs</li>
    <li>nrv_shows : pour les spectacles / artistes</li>
    <li>nrv_party : pour les soirées</li>
    <li>nrv_tickets : pour les billets et le panier</li>
    <li>nrv_place : pour les lieux</li>
</ul>

<strong> Normalement, quand on build le docker-compose, les bases de données sont créées automatiquement (sans les données). Si jamais vous avez besoin de les recréer, voici les scripts SQL : </strong>
<p>Les scripts sql se trouvent dans le dossier /initdb</p>
### Architecture de la base de données nrv_auth

```sql
DROP TABLE IF EXISTS "users";
CREATE TABLE "public"."users" (
  "id" uuid NOT NULL,
  "email" character varying(128) NOT NULL,
  "password" character varying(256) NOT NULL,
  "role" integer DEFAULT '0' NOT NULL
) WITH (oids = false);
```

### Architecture de la base de données nrv_party

```sql
DROP TABLE IF EXISTS "party";
CREATE TABLE "public"."party" (
    "id" uuid NOT NULL,
    "name" character varying(50) NOT NULL,
    "theme" character varying(50) NOT NULL,
    "date" timestamp NOT NULL,
    "begin" timestamp NOT NULL,
    "place_id" uuid NOT NULL,
    "show1_id" uuid NOT NULL,
    "show2_id" uuid,
    "show3_id" uuid,
    "price" integer
) WITH (oids = false);
```

### Architecture de la base de données nrv_place

```sql
DROP TABLE IF EXISTS "images";
CREATE TABLE "public"."images" (
   "id" uuid NOT NULL,
   "path" character varying(256) NOT NULL,
   "place_id" uuid NOT NULL
) WITH (oids = false);


DROP TABLE IF EXISTS "places";
CREATE TABLE "public"."places" (
   "id" uuid NOT NULL,
   "name" character varying(50) NOT NULL,
   "address" character varying(128) NOT NULL,
   "nb_sit" integer NOT NULL,
   "nb_stand" integer NOT NULL
) WITH (oids = false);
```

### Architecture de la base de données nrv_shows

```sql
DROP TABLE IF EXISTS "artists";
CREATE TABLE "public"."artists" (
    "id" uuid NOT NULL,
    "name" character varying(50) NOT NULL,
    "style" character varying(50) NOT NULL,
    "image" character varying(128) DEFAULT 'default.jpg' NOT NULL
) WITH (oids = false);


DROP TABLE IF EXISTS "artists2style";
CREATE TABLE "public"."artists2style" (
    "artist_id" uuid NOT NULL,
    "style_id" uuid NOT NULL
) WITH (oids = false);


DROP TABLE IF EXISTS "images";
CREATE TABLE "public"."images" (
    "id" uuid NOT NULL,
    "path" character varying(256) NOT NULL,
    "show_id" uuid NOT NULL
) WITH (oids = false);


DROP TABLE IF EXISTS "perform";
CREATE TABLE "public"."perform" (
    "show_id" uuid NOT NULL,
    "artist_id" uuid NOT NULL
) WITH (oids = false);


DROP TABLE IF EXISTS "shows";
CREATE TABLE "public"."shows" (
    "id" uuid NOT NULL,
    "title" character varying(50) NOT NULL,
    "description" character varying(128) NOT NULL,
    "video" character varying(256),
    "begin" timestamp NOT NULL
) WITH (oids = false);


DROP TABLE IF EXISTS "style";
CREATE TABLE "public"."style" (
  "id" uuid NOT NULL,
  "name" character varying(50) NOT NULL
) WITH (oids = false);
```

### Architecture de la base de données nrv_tickets

```sql
DROP TABLE IF EXISTS "tickets";
CREATE TABLE "public"."tickets" (
    "id" uuid NOT NULL,
    "name" character varying(50) NOT NULL,
    "price" integer NOT NULL,
    "quantity" integer NOT NULL,
    "party_id" uuid NOT NULL
) WITH (oids = false);

DROP TABLE IF EXISTS "soldtickets";
CREATE TABLE "public"."soldtickets" (
      "id" uuid NOT NULL,
      "name" character varying(50) NOT NULL,
      "price" integer NOT NULL,
      "user_id" uuid NOT NULL,
      "ticket_id" uuid NOT NULL,
      "party_id" uuid NOT NULL
) WITH (oids = false);

DROP TABLE IF EXISTS "carts";
CREATE TABLE "public"."carts" (
  "id" uuid NOT NULL,
  "user_id" uuid NOT NULL,
  "total_price" integer NOT NULL,
  "state" integer DEFAULT '0' NOT NULL
) WITH (oids = false);

DROP TABLE IF EXISTS "cart_content";
CREATE TABLE "public"."cart_content" (
    "cart_id" uuid NOT NULL,
    "ticket_id" uuid NOT NULL,
    "quantity" integer DEFAULT '1' NOT NULL
) WITH (oids = false);
```

### Les données de la base de données nrv_auth

```sql
INSERT INTO public.users (id, email, password, role)
VALUES ('669d5162-84b0-4edc-b043-3ccfa71eb0a9', 'greg@gmail.com',
        '$2y$10$Z/Ly0lfKRG8/6.I7Ask8cumJwbmaHPpnTTevulJwerlaK4109okAS', 0),
       ('59f6ee1e-cc37-4d54-8852-ab09f6fd46a7', 'tim@gmail.com',
        '$2y$10$R.ysQMOHt8oYFE0YY1ws0eZ91vKgcpzAY82R8rWEMsvFLRHjFpmd2', 0),
       ('2a0d23e7-dab5-4074-be44-4a2822d92915', 'admin@gmail.com',
        '$2y$10$yEKWI4iJHlN5.PdKp8LvFefnKpclftKoWleY4xFkLHO7NzUUA5RlK', 10),
       ('23daaea8-68d2-4d80-90cf-0d01339c92d7', 'superadmin@gmail.com',
        '$2y$10$WLGsGcxTevxNT3SWaWYK7.1P34A6FsjWyJkf/qKJz1ry5S/7FYqRS', 100);
```

### Les données de la base de données nrv_place

```sql
INSERT INTO public.places (id, name, address, nb_sit, nb_stand)
VALUES ('340cf1fe-6344-4e93-ab6a-347c7e461d36', 'Stade de France', 'Saint-Denis, France', 80000, 20000),
       ('b6b101d5-563e-4530-a3bb-43be12ea1053', 'Zénith Paris', 'Paris, France', 6000, 3000),
       ('df23e061-1a1b-4344-ac9c-5357465f5c5b', 'AccorHotels Arena', 'Paris, France', 20000, 5000),
       ('a7d21201-5e1c-41ff-b3da-4c79b72e2521', 'Parc des Princes', 'Paris, France', 48000, 10000);

-- Insertion des images de lieux
INSERT INTO public.images (id, path, place_id)
VALUES ('35346ab9-f0c2-4651-a5d5-1be4fcdc346f', '/images/stadedefrance.jpg',
        (SELECT id FROM public.places WHERE name = 'Stade de France')),
       ('8e60916a-6580-4a37-974c-1f10e25ecf12', '/images/zenithparis.jpg',
        (SELECT id FROM public.places WHERE name = 'Zénith Paris')),
       ('a7c12f04-1c7e-4c7e-9d84-b249084b92c3', '/images/accorhotelsarena.jpg',
        (SELECT id FROM public.places WHERE name = 'AccorHotels Arena')),
       ('5d3c2335-8c1b-47e0-bc7e-4bb5e19b5ab7', '/images/parcdesprinces.jpg',
        (SELECT id FROM public.places WHERE name = 'Parc des Princes'));
```


### Les données de la base de données nrv_shows

```sql
-- Insertion des styles musicaux
INSERT INTO public.style (id, name)
VALUES ('93e91764-4650-4dc9-8507-c3f12995329e', 'Electro'),
       ('200996e1-6409-4fbf-b146-d3e03b1d10f5', 'Pop'),
       ('d6fcb401-726e-4fdb-b3fa-081b22d04158', 'Rock'),
       ('39a2dcb7-fe12-40ff-950e-495efb4af12d', 'House'),
       ('9b9f7e69-2226-4248-85d3-8ad0ed4f06dc', 'Synthpop'),
       ('7d0670bd-8b9a-442d-900a-0f2309808e65', 'Downtempo'),
       ('369f8daa-5922-4b67-be56-6cb0c65b943b', 'Classical'),
       ('15b61ab3-1d88-443a-93b5-d82a31aa7699', 'Chanson'),
       ('3379deb3-fcd4-4fe0-9003-aa6880ee6943', 'Hip Hop'),
       ('7ed03ec9-4a9b-43c0-acd0-f8e485d106a1', 'Rap'),
       ('cabc1af4-4110-4587-b216-6caa8834b00d', 'R&B'),
       ('8a7b1292-f7f6-48f0-bbaa-d275f566f498', 'Metal');

-- Insertion des artistes avec les valeurs spécifiées
INSERT INTO public.artists (id, name, style, image)
VALUES ('3fc424d2-b3c7-4bf9-9bd5-0a0d86c40543', 'Daft Punk', 'Electro', 'daftpunk.jpg'),
       ('6abedb09-8f65-424f-be99-8c0e0829db03', 'Christine and the Queens', 'Pop', 'christine.jpg'),
       ('c3dfb3ab-d942-4494-a8c3-eedbf6c9d6a7', 'Phoenix', 'Rock', 'phoenix.jpg'),
       ('5f89da2b-321d-4c58-bfe5-24a7796235d8', 'David Guetta', 'House', 'davidguetta.jpg'),
       ('a8f6597f-473a-4ff6-8508-ed91451faa50', 'M83', 'Synthpop', 'm83.jpg'),
       ('f19b8af0-3f83-4e6c-8400-4d56181a4e96', 'Air', 'Downtempo', 'default.jpg'),
       ('86d47229-0879-41d7-84f4-b247131e48ac', 'Yann Tiersen', 'Classical', 'yanntiersen.jpg'),
       ('6e9e694a-929e-4946-b793-89f61acc153a', 'Zaz', 'Chanson', 'zaz.jpg'),
       ('1dec3475-f06a-4ae1-bce4-336e8f1413e1', 'Stromae', 'Hip Hop', 'stromae.jpg'),
       ('d33bd958-188f-4050-94c9-dd232a4ff2c2', 'Angèle', 'Pop', 'angele.jpg'),
       ('c407a275-6535-4e78-acb5-8ff8ba9885f6', 'Justice', 'Electro', 'justice.jpg'),
       ('732bffd7-697b-4cc3-8574-cca23109b0f8', 'Sofiane Pamart', 'Piano', 'sofianepamart.jpg'),
       ('3180a9a5-dcf4-44aa-b21d-eea6ef8b47b5', 'Imany', 'Soul', 'imany.jpg'),
       ('830ba487-8ab2-4af3-a0fa-97d94b47d7fc', 'Shaka Ponk', 'Rock', 'shakaponk.jpg'),
       ('d1471672-0648-4f65-abb5-ecd59e61efd1', 'Clara Luciani', 'Chanson', 'claraluciani.jpg'),
       ('837efa7b-d907-4149-9821-2c624a9ad140', 'Julien Doré', 'Pop', 'juliendore.jpg'),
       ('8a4a6a1c-6419-447e-9ae4-f6e2c484f423', 'Jeanne Added', 'Indie Rock', 'jeanneadded.jpg'),
       ('1aeb84f9-bd55-4957-b06b-1523dd27d851', 'Louane', 'Pop', 'louane.jpg'),
       ('5cb9efac-6fb4-43ab-a0f8-cb9c0bc9522b', 'Vianney', 'Chanson', 'vianney.jpg'),
       ('5dbfb52d-cc65-48d2-bad3-c11b8fc9e920', 'Benjamin Biolay', 'Chanson', 'benjaminbiolay.jpg'),
       ('3dff74cb-7ae7-44d6-a4e5-44b818c15886', 'Patrick Bruel', 'Chanson', 'patrickbruel.jpg'),
       ('3dff74cb-7ae7-44d6-a4e5-44b818c15886', 'Indochine', 'Rock', 'indochine.jpg'),
       ('8e3921a0-4dda-4021-9251-28739a13063b', 'Alain Souchon', 'Chanson', 'alainsouchon.jpg'),
       ('b4269b6d-3b6a-47ae-9d93-28fa2c0d6fce', 'Édith Piaf', 'Chanson', 'edithpiaf.jpg'),
       ('38d78cad-a7b3-4875-9d9f-054988db45a5', 'Serge Gainsbourg', 'Chanson', 'sergegainsbourg.jpg'),
       ('db2f0967-8b47-4892-8d18-f1d4fc156712', 'Manu Chao', 'World Music', 'manuchao.jpg'),
       ('05c10123-0165-4c52-b943-57eb1935e08d', 'Gojira', 'Metal', 'gojira.jpg'),
       ('9419f77e-db21-4ed1-9e5f-fb04373e2400', 'Camille', 'Experimental', 'default.jpg'),
       ('81a432bc-b9b0-4965-8884-1b8b3ed1f48b', 'Aya Nakamura', 'R&B', 'ayanakamura.jpg'),
       ('f9b357ab-43cc-4838-a91a-2c3359d42031', 'Booba', 'Rap', 'booba.jpg'),
       ('88157f29-a90e-4eab-be23-6195e0c8246b', 'PNL', 'Rap', 'pnl.jpg'),
       ('ec8c796b-4800-4239-b02a-d67958fbcfc3', 'Soprano', 'Rap', 'soprano.jpg'),
       ('2a17f930-c5c1-47b2-baf0-78d9f10eec33', 'Maître Gims', 'Pop', 'maitregims.jpg'),
       ('d76e00c4-61c9-4c41-a854-5e899f645378', 'MC Solaar', 'Rap', 'mcsolaar.jpg'),
       ('93b95145-bc4a-4a98-80c5-16b25111256a', 'Kendji Girac', 'Pop', 'kendjigirac.jpg'),
       ('31a83440-e9ef-4093-b908-f1716413c05e', 'Black M', 'Rap', 'blackm.jpg'),
       ('b64615f4-2ff8-4990-8031-07dd40479c20', 'Bigflo & Oli', 'Rap', 'bigflo&oli.jpg'),
       ('0b008605-0039-4da0-a84e-88d6663d1743', 'Lou Doillon', 'Indie', 'loudoillon.jpg'),
       ('cc1aa06d-4759-48b5-874d-d49817d4a274', 'Brigitte', 'Pop', 'default.jpg'),
       ('9968dcf8-068e-4f2b-9f6c-5453b9a31ee3', 'Jain', 'Pop', 'jain.jpg'),
       ('2d8ee4ff-cd0e-4a7e-a51f-d61dac39bec4', 'Izïa', 'Rock', 'izia.jpg'),
       ('c7df396b-fe96-4988-b875-86063c8727d7', 'Rone', 'Electro', 'rone.jpg'),
       ('58e41536-f262-4294-aec9-949ba6864b60', 'Therapie TAXI', 'Pop', 'therapietaxi.jpg'),
       ('b8797a32-d19d-4fe3-a5c5-5c471e19d993', 'Kassav', 'Zouk', 'kassav.jpg'),
       ('66ccca0a-e14a-4950-b6af-85ef7bcb81a0', 'Johnny Hallyday', 'Rock', 'johnnyhalliday.jpg'),
       ('a550cfa3-9467-4c9f-87fc-940e5414b851', 'Charles Aznavour', 'Chanson', 'charlesaznavour.jpg'),
       ('1d22c608-7f1d-4624-8790-89366dc00b14', 'Jacques Brel', 'Chanson', 'jacquesbrel.jpg'),
       ('c5cfcd88-977f-4c57-95bb-86db5e577906', 'Francis Cabrel', 'Chanson', 'franciscabrel.jpg'),
       ('aa18eb59-95a0-4eb7-9eba-7f651aafa4ce', 'Jul', 'Rap', 'jul.jpg'),
       ('881ed44e-6df0-4b8a-96ef-42b263900643', 'Damso', 'Rap', 'damso.jpg'),
       ('18fc6ea1-1e3d-4556-96ca-db8f7b68d3b4', 'Lomepal', 'Rap', 'lomepal.jpg'),
       ('8933cee2-8c4d-4dff-b111-b2c16a1ab3cd', 'Eddy de Pretto', 'Pop', 'eddydepretto.jpg'),
       ('3df8cb67-1037-4e95-a426-04391f061fe6', 'M', 'Pop', 'm.jpg'),
       ('e402ef41-4c22-4da1-8738-d51e740df156', 'Claudio Capéo', 'Pop', 'claudiocapeo.jpg'),
       ('3f982975-909b-43cd-b71c-bc6c31c4938f', 'Amir', 'Pop', 'amir.jpg'),
       ('d380097d-438a-43b6-ae22-d757847e880e', 'Suzane', 'Pop', 'default.jpg'),
       ('c30f0641-f138-4869-b066-95b123bb9257', 'Yseult', 'Pop', 'yseult.jpg'),
       ('462ef814-d0e8-488f-9731-9ddf6630e2cf', 'Zaho', 'R&B', 'zaho.jpg'),
       ('0d5aa540-6774-400d-a2e4-543cc9514bea', 'Hoshi', 'Pop', 'hoshi.jpg'),
       ('8e66a186-4140-4288-8838-5fae5ad11d3f', 'Les Rita Mitsouko', 'Rock', 'lesritamitsouko.jpg'),
       ('c3952c5d-87b5-4616-a4ad-51c3301ec035', 'Nekfeu', 'Rap', 'nekfeu.jpg'),
       ('2190bfe6-9f75-422a-aa2a-76882001e2f6', 'Orelsan', 'Rap', 'orelsan.jpg'),
       ('88a5404d-b027-481b-985f-1b86937050f0', 'IAM', 'Rap', 'iam.jpg'),
       ('7f0240fe-5a7b-4679-a0f3-6f95d64e186e', 'NTM', 'Rap', 'ntm.jpg'),
       ('31b1a800-49dc-43d3-bfd3-e7cf63b26447', 'Tryo', 'Reggae', 'tryo.jpg'),
       ('34ade196-6a0f-46d2-a360-c7d084fca4b5', 'Lea Castel', 'Pop', 'leacastel.jpg'),
       ('4794592e-3f8c-4737-91eb-058a8cd5233e', 'Shym', 'Pop', 'shym.jpg'),
       ('842af1aa-2de8-4568-941d-e37c4f47040d', 'Lara Fabian', 'Pop', 'larafabian.jpg'),
       ('250f097e-11c7-44d9-b7ee-ca16f35f0c71', 'Calogero', 'Pop', 'calogero.jpg'),
       ('808f6413-6a3e-4989-b40c-befd4027f2dc', 'Garou', 'Pop', 'garou.jpg'),
       ('6b9ff23d-8c18-417a-9b85-431bb6b71413', 'Pascal Obispo', 'Pop', 'pascalobispo.jpg'),
       ('586e381a-2e5e-4037-a17b-edf0266c7310', 'Florent Pagny', 'Pop', 'florentpagny.jpg'),
       ('8dfe5baa-b686-4aa0-aa48-b5d07bbcf037', 'Michel Sardou', 'Chanson', 'michelsardou.jpg'),
       ('867d4934-204c-41ca-beb2-02a679a69e5e', 'Mylène Farmer', 'Pop', 'mylenefarmer.jpg');


-- Insertion des correspondances artistes et styles dans la table artists2style
INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Daft Punk'), (SELECT id FROM public.style WHERE name = 'Electro');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Christine and the Queens'),
       (SELECT id FROM public.style WHERE name = 'Pop');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Phoenix'), (SELECT id FROM public.style WHERE name = 'Rock');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'David Guetta'), (SELECT id FROM public.style WHERE name = 'House');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'M83'), (SELECT id FROM public.style WHERE name = 'Synthpop');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Air'), (SELECT id FROM public.style WHERE name = 'Downtempo');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Yann Tiersen'),
       (SELECT id FROM public.style WHERE name = 'Classical');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Zaz'), (SELECT id FROM public.style WHERE name = 'Chanson');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Stromae'), (SELECT id FROM public.style WHERE name = 'Hip Hop');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Angèle'), (SELECT id FROM public.style WHERE name = 'Pop');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Justice'), (SELECT id FROM public.style WHERE name = 'Electro');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Sofiane Pamart'),
       (SELECT id FROM public.style WHERE name = 'Classical');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Imany'), (SELECT id FROM public.style WHERE name = 'Classical');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Shaka Ponk'), (SELECT id FROM public.style WHERE name = 'Rock');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Clara Luciani'),
       (SELECT id FROM public.style WHERE name = 'Chanson');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Julien Doré'), (SELECT id FROM public.style WHERE name = 'Pop');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Jeanne Added'),
       (SELECT id FROM public.style WHERE name = 'Rock');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Louane'), (SELECT id FROM public.style WHERE name = 'Pop');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Vianney'), (SELECT id FROM public.style WHERE name = 'Chanson');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Benjamin Biolay'),
       (SELECT id FROM public.style WHERE name = 'Chanson');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Patrick Bruel'),
       (SELECT id FROM public.style WHERE name = 'Chanson');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Indochine'), (SELECT id FROM public.style WHERE name = 'Rock');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Alain Souchon'),
       (SELECT id FROM public.style WHERE name = 'Chanson');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Édith Piaf'), (SELECT id FROM public.style WHERE name = 'Chanson');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Serge Gainsbourg'),
       (SELECT id FROM public.style WHERE name = 'Chanson');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Manu Chao'),
       (SELECT id FROM public.style WHERE name = 'Classical');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Gojira'), (SELECT id FROM public.style WHERE name = 'Metal');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Camille'),
       (SELECT id FROM public.style WHERE name = 'Classical');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Aya Nakamura'), (SELECT id FROM public.style WHERE name = 'R&B');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Booba'), (SELECT id FROM public.style WHERE name = 'Rap');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'PNL'), (SELECT id FROM public.style WHERE name = 'Rap');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Soprano'), (SELECT id FROM public.style WHERE name = 'Rap');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Maître Gims'), (SELECT id FROM public.style WHERE name = 'Pop');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'MC Solaar'), (SELECT id FROM public.style WHERE name = 'Rap');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Kendji Girac'), (SELECT id FROM public.style WHERE name = 'Pop');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Black M'), (SELECT id FROM public.style WHERE name = 'Rap');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Bigflo & Oli'), (SELECT id FROM public.style WHERE name = 'Rap');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Lou Doillon'),
       (SELECT id FROM public.style WHERE name = 'Classical');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Brigitte'), (SELECT id FROM public.style WHERE name = 'Pop');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Jain'), (SELECT id FROM public.style WHERE name = 'Pop');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Izïa'), (SELECT id FROM public.style WHERE name = 'Rock');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Rone'), (SELECT id FROM public.style WHERE name = 'Electro');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Therapie TAXI'), (SELECT id FROM public.style WHERE name = 'Pop');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Kassav'), (SELECT id FROM public.style WHERE name = 'Classical');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Johnny Hallyday'),
       (SELECT id FROM public.style WHERE name = 'Rock');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Charles Aznavour'),
       (SELECT id FROM public.style WHERE name = 'Chanson');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Mylène Farmer'), (SELECT id FROM public.style WHERE name = 'Pop');


-- Insertion des spectacles
INSERT INTO public.shows (id, title, description, video, begin)
VALUES ('14808e51-d1b6-4539-8596-66a9e39e01c9', 'Daft Punk Show', 'Un concert unique avec Daft Punk',
        '/videos/daftpunk.mp4',
        '2024-12-31 22:00:00'),
       ('05cf1397-1bf3-4227-aa5a-063c6b3e14e8', 'Phoenix Live', 'Phoenix en live à Paris', '/videos/phoenix.mp4',
        '2024-11-15 20:00:00'),
       ('2ccfe7d7-adaf-492a-abb4-78065bd69ae6', 'Christine and the Queens', 'Christine and the Queens en concert',
        '/videos/christine.mp4',
        '2024-10-15 20:00:00'),
       ('4105771b-8e04-4547-a1b4-4dd97564ddfd', 'Zaz Live', 'Zaz en live à Paris en 2024', '/videos/zaz.mp4',
        '2024-09-15 20:00:00'),
       ('cc3604e4-8fa5-484b-8ef6-967a39690aff', 'David Guetta Live', 'David Guetta en live à Paris',
        '/videos/davidguetta.mp4', '2024-08-15 20:00:00'),
       ('1d1f7925-56d4-413e-8074-203fae4a359b', 'M83 Live', 'M83 en live à Paris', '/videos/m83.mp4',
        '2024-07-15 20:00:00'),
       ('18ced3c9-be12-4912-a297-d69ccaee52fa', 'Air Live', 'Air en live à Paris', '/videos/air.mp4',
        '2024-06-15 20:00:00'),
       ('a3deef4c-de4e-4173-a7f2-29e1cbac7e75', 'Yann Tiersen Live', 'Yann Tiersen en live à Paris',
        '/videos/yanntiersen.mp4', '2024-05-15 20:00:00'),
       ('9d35a80f-e8ee-445a-a7c9-470b8a49d8cd', 'Stromae Live', 'Stromae en live à Paris', '/videos/stromae.mp4',
        '2024-04-15 20:00:00'),
       ('9cc4661a-940a-471f-ac20-82facbc327cd', 'Angèle Live', 'Angèle en live à Paris', '/videos/angele.mp4',
        '2024-03-15 20:00:00'),
       ('1a24a92b-e920-48c3-b848-3260685d57cf', 'Justice Live', 'Justice en live à Paris', '/videos/justice.mp4',
        '2024-02-15 20:00:00'),
       ('349bc08a-84b2-45e5-8d14-14ff2d6816c6', 'Sofiane Pamart Live', 'Sofiane Pamart en live à Paris',
        '/videos/sofianepamart.mp4', '2024-01-15 20:00:00'),
       ('c81debe6-eb5a-4076-b2d4-fbe87c29ab12', 'Imany Live', 'Imany en live à Paris', '/videos/imany.mp4',
        '2024-01-15 20:00:00'),
       ('56de5d60-db05-431b-a395-08ffde90e84e', 'Shaka Ponk Live', 'Shaka Ponk en live à Paris',
        '/videos/shakaponk.mp4', '2024-01-15 20:00:00'),
       ('727a387b-5769-406d-837d-bc3d18e20578', 'Clara Luciani Live', 'Clara Luciani en live à Paris',
        '/videos/claraluciani.mp4', '2024-01-15 20:00:00'),
       ('6e450f93-9f0f-47f3-813e-1a55ce50ca5a', 'Julien Doré Live', 'Julien Doré en live à Paris',
        '/videos/juliendore.mp4', '2024-01-15 20:00:00'),
       ('2f436ed0-e77d-42dd-9e9e-0184a95d0fc3', 'Jeanne Added Live', 'Jeanne Added en live à Paris',
        '/videos/jeanneadded.mp4', '2024-01-15 20:00:00'),
       ('82526ada-3aa3-4cc6-aa87-10f34e38d51b', 'Louane Live', 'Louane en live à Paris', '/videos/louane.mp4',
        '2024-01-15 20:00:00'),
       ('0c59224a-bc22-49d1-a773-7fb523c52d5f', 'Vianney Live', 'Vianney en live à Paris', '/videos/vianney.mp4',
        '2024-01-15 20:00:00');


-- Insertion des images de spectacles
INSERT INTO public.images (id, path, show_id)
VALUES ('dc0596b0-9ac2-448e-b258-eff68fb81691', '/images/daftpunk.jpg',
        (SELECT id FROM public.shows WHERE title = 'Daft Punk Show')),
       ('157d8626-58d4-423f-91fc-7b0155baa241', '/images/phoenix.jpg',
        (SELECT id FROM public.shows WHERE title = 'Phoenix Live')),
       ('df220d31-9506-40f5-ad71-dd0a0ac48c52', '/images/christine.jpg',
        (SELECT id FROM public.shows WHERE title = 'Christine and the Queens')),
       ('4105771b-8e04-4547-a1b4-4dd97564ddfd', '/images/zaz.jpg',
        (SELECT id FROM public.shows WHERE title = 'Zaz Live')),
       ('b5cd8694-6ff3-42f8-8ef5-510e5fe16c8f', '/images/davidguetta.jpg',
        (SELECT id FROM public.shows WHERE title = 'David Guetta Live')),
       ('0922350d-8468-4a20-b7f3-463e6b84cd5a', '/images/m83.jpg',
        (SELECT id FROM public.shows WHERE title = 'M83 Live')),
       ('66ffa9c2-be20-4636-bea6-b7efa1daf734', '/images/air.jpg',
        (SELECT id FROM public.shows WHERE title = 'Air Live')),
       ('eb0e0a68-f274-4c8b-9a1c-7f67398a7454', '/images/yanntiersen.jpg',
        (SELECT id FROM public.shows WHERE title = 'Yann Tiersen Live')),
       ('e965415e-2068-4699-b6a4-4e90d34df65d', '/images/stromae.jpg',
        (SELECT id FROM public.shows WHERE title = 'Stromae Live')),
       ('be54c065-b527-4640-859f-cef905b36691', '/images/angele.jpg',
        (SELECT id FROM public.shows WHERE title = 'Angèle Live')),
       ('c62f8b94-d826-4cd9-aaad-0d1abf68d1d0', '/images/justice.jpg',
        (SELECT id FROM public.shows WHERE title = 'Justice Live')),
       ('9853ddf3-1867-4a7c-b77f-fff4fa5ea4fb', '/images/sofianepamart.jpg',
        (SELECT id FROM public.shows WHERE title = 'Sofiane Pamart Live')),
       ('5d7372b0-6da7-468e-b731-82795aac591e', '/images/imany.jpg',
        (SELECT id FROM public.shows WHERE title = 'Imany Live')),
       ('1c01edd4-80c5-45ae-b9fd-833777b0a2ab', '/images/shakaponk.jpg',
        (SELECT id FROM public.shows WHERE title = 'Shaka Ponk Live')),
       ('85bc59fb-f256-4333-bb60-bd329f4a0c51', '/images/claraluciani.jpg',
        (SELECT id FROM public.shows WHERE title = 'Clara Luciani Live')),
       ('4031a58e-d13a-4131-a9e7-3fe5dacd8237', '/images/juliendore.jpg',
        (SELECT id FROM public.shows WHERE title = 'Julien Doré Live')),
       ('535fffa4-3ac9-47ed-8a26-cefd5c0cbaf6', '/images/jeanneadded.jpg',
        (SELECT id FROM public.shows WHERE title = 'Jeanne Added Live')),
       ('c2d6ea5f-6957-4ff2-bdc6-4e6bc2499704', '/images/louane.jpg',
        (SELECT id FROM public.shows WHERE title = 'Louane Live')),
       ('b0896aae-307d-4571-9314-2a470927a692', '/images/vianney.jpg',
        (SELECT id FROM public.shows WHERE title = 'Vianney Live'));


-- Insertion des performances d'artistes
INSERT INTO public.perform (show_id, artist_id)
VALUES ((SELECT id FROM public.shows WHERE title = 'Daft Punk Show'),
        (SELECT id FROM public.artists WHERE name = 'Daft Punk')),
       ((SELECT id FROM public.shows WHERE title = 'Phoenix Live'),
        (SELECT id FROM public.artists WHERE name = 'Phoenix')),
       ((SELECT id FROM public.shows WHERE title = 'Christine and the Queens'),
        (SELECT id FROM public.artists WHERE name = 'Christine and the Queens')),
       ((SELECT id FROM public.shows WHERE title = 'Zaz Live'),
        (SELECT id FROM public.artists WHERE name = 'Zaz')),
       ((SELECT id FROM public.shows WHERE title = 'David Guetta Live'),
        (SELECT id FROM public.artists WHERE name = 'David Guetta')),
       ((SELECT id FROM public.shows WHERE title = 'M83 Live'),
        (SELECT id FROM public.artists WHERE name = 'M83')),
       ((SELECT id FROM public.shows WHERE title = 'Air Live'),
        (SELECT id FROM public.artists WHERE name = 'Air')),
       ((SELECT id FROM public.shows WHERE title = 'Yann Tiersen Live'),
        (SELECT id FROM public.artists WHERE name = 'Yann Tiersen')),
       ((SELECT id FROM public.shows WHERE title = 'Stromae Live'),
        (SELECT id FROM public.artists WHERE name = 'Stromae')),
       ((SELECT id FROM public.shows WHERE title = 'Angèle Live'),
        (SELECT id FROM public.artists WHERE name = 'Angèle')),
       ((SELECT id FROM public.shows WHERE title = 'Justice Live'),
        (SELECT id FROM public.artists WHERE name = 'Justice')),
       ((SELECT id FROM public.shows WHERE title = 'Sofiane Pamart Live'),
        (SELECT id FROM public.artists WHERE name = 'Sofiane Pamart')),
       ((SELECT id FROM public.shows WHERE title = 'Imany Live'),
        (SELECT id FROM public.artists WHERE name = 'Imany')),
       ((SELECT id FROM public.shows WHERE title = 'Shaka Ponk Live'),
        (SELECT id FROM public.artists WHERE name = 'Shaka Ponk')),
       ((SELECT id FROM public.shows WHERE title = 'Clara Luciani Live'),
        (SELECT id FROM public.artists WHERE name = 'Clara Luciani')),
       ((SELECT id FROM public.shows WHERE title = 'Julien Doré Live'),
        (SELECT id FROM public.artists WHERE name = 'Julien Doré')),
       ((SELECT id FROM public.shows WHERE title = 'Jeanne Added Live'),
        (SELECT id FROM public.artists WHERE name = 'Jeanne Added')),
       ((SELECT id FROM public.shows WHERE title = 'Louane Live'),
        (SELECT id FROM public.artists WHERE name = 'Louane')),
       ((SELECT id FROM public.shows WHERE title = 'Vianney Live'),
        (SELECT id FROM public.artists WHERE name = 'Vianney'));
```

### Les données de la base de données nrv_party

```sql
-- Insertion des fêtes (party)
INSERT INTO public.party (id, name, theme, date, begin, place_id, show1_id, show2_id, show3_id, price)
VALUES ('a0b7566b-6fdd-4e34-bbab-41d882de9c07', 'Birthday Bash', 'Anniversaire', '2024-12-25 20:00:00',
        '2024-12-25 21:00:00',
        '340cf1fe-6344-4e93-ab6a-347c7e461d36', '14808e51-d1b6-4539-8596-66a9e39e01c9',
        '05cf1397-1bf3-4227-aa5a-063c6b3e14e8', 'cc3604e4-8fa5-484b-8ef6-967a39690aff', 30),
       ('8243ea21-155b-4ac9-b75e-f66fc142c2ef', 'Music Fiesta', 'Musique', '2024-11-01 18:00:00', '2024-11-01 19:00:00',
        'b6b101d5-563e-4530-a3bb-43be12ea1053',
        '2ccfe7d7-adaf-492a-abb4-78065bd69ae6', '1d1f7925-56d4-413e-8074-203fae4a359b', NULL, 50),
       ('8a03e604-ed5f-457f-82c3-11d35e54d496', 'Hola Amigo', 'Fiesta', '2024-10-01 18:00:00', '2024-10-01 19:00:00',
        'df23e061-1a1b-4344-ac9c-5357465f5c5b',
        '4105771b-8e04-4547-a1b4-4dd97564ddfd', '18ced3c9-be12-4912-a297-d69ccaee52fa', NULL, 25),
       ('3ec35a04-a24b-42f5-924d-df9a283cbb20', 'Rock Party', 'Rock', '2024-09-01 18:00:00', '2024-09-01 19:00:00',
        'a7d21201-5e1c-41ff-b3da-4c79b72e2521',
        'a3deef4c-de4e-4173-a7f2-29e1cbac7e75', NULL, NULL, 40),
       ('e4dc52bb-98d2-4e11-993a-aefbd5a2e3a3', 'Electro Party', 'Electro', '2024-08-01 18:00:00',
        '2024-08-01 19:00:00',
        'b6b101d5-563e-4530-a3bb-43be12ea1053',
        '9d35a80f-e8ee-445a-a7c9-470b8a49d8cd', '0c59224a-bc22-49d1-a773-7fb523c52d5f', NULL, 100),
       ('16c4e551-09d8-42c3-8f91-bf63ed980b1e', 'Mix Party', 'Mixed', '2024-07-01 18:00:00', '2024-07-01 19:00:00',
        '340cf1fe-6344-4e93-ab6a-347c7e461d36',
        '9cc4661a-940a-471f-ac20-82facbc327cd', '82526ada-3aa3-4cc6-aa87-10f34e38d51b', NULL, 75),
       ('b328bc9c-79a8-4b24-bbeb-2806b06ce3f6', 'Night Party', 'Night', '2024-07-01 18:00:00', '2024-07-01 19:00:00',
        'a7d21201-5e1c-41ff-b3da-4c79b72e2521',
        '1a24a92b-e920-48c3-b848-3260685d57cf', '2f436ed0-e77d-42dd-9e9e-0184a95d0fc3', NULL, 55),
       ('a6221ba5-639e-4952-a95c-3ff6b018a8ad', 'Music Party', 'Music', '2024-07-01 18:00:00', '2024-07-01 19:00:00',
        'df23e061-1a1b-4344-ac9c-5357465f5c5b',
        '349bc08a-84b2-45e5-8d14-14ff2d6816c6', '56de5d60-db05-431b-a395-08ffde90e84e', NULL, 10),
       ('864df722-b890-4ace-adf8-ddeb888d25fd', 'Giga Party', 'Big', '2024-07-01 18:00:00', '2024-07-01 19:00:00',
        'b6b101d5-563e-4530-a3bb-43be12ea1053', 'c81debe6-eb5a-4076-b2d4-fbe87c29ab12',
        '727a387b-5769-406d-837d-bc3d18e20578', '6e450f93-9f0f-47f3-813e-1a55ce50ca5a', 200);
```

### Les données de la base de données nrv_ticket

```sql
INSERT INTO public.tickets (id, name, price, quantity, party_id)
VALUES ('cec7ef16-66db-4916-96cd-4e4a2057ae8c', 'Birthday Bash ticket', 30, 100000,
        'a0b7566b-6fdd-4e34-bbab-41d882de9c07'),
       ('25679b20-65f8-4455-97f8-a717fefd581d', 'Birthday Bash ticket', 24, 100000,
        'a0b7566b-6fdd-4e34-bbab-41d882de9c07'),
       ('eaa814ee-398e-435e-950c-32bc56cf0c90', 'Music Fiesta ticket', 50, 8999,
        '8243ea21-155b-4ac9-b75e-f66fc142c2ef'),
       ('36a2cc72-0a36-4ad6-992c-4d310faa08a9', 'Music Fiesta ticket', 40, 8999,
        '8243ea21-155b-4ac9-b75e-f66fc142c2ef'),
       ('5964bb56-16a5-4d4d-ac40-f5ee584bb771', 'Hola Amigo ticket', 25, 24999, '8a03e604-ed5f-457f-82c3-11d35e54d496'),
       ('08f6c431-6c0c-4255-a0c6-6440b52f231a', 'Hola Amigo ticket', 20, 24999, '8a03e604-ed5f-457f-82c3-11d35e54d496'),
       ('f90df33c-133b-4e75-8e7a-f85e6c9d20a6', 'Rock Party ticket', 40, 10000, '3ec35a04-a24b-42f5-924d-df9a283cbb20'),
       ('3dd2788e-f1c4-4801-aa3b-f5bbf788723e', 'Rock Party ticket', 32, 10000, '3ec35a04-a24b-42f5-924d-df9a283cbb20'),
       ('b92cebe7-3557-4562-8604-f180700525c3', 'Electro Party ticket', 100, 10000,
        'e4dc52bb-98d2-4e11-993a-aefbd5a2e3a3'),
       ('fae7f85c-3e52-458c-9606-d55fe621868e', 'Electro Party ticket', 80, 10000,
        'e4dc52bb-98d2-4e11-993a-aefbd5a2e3a3'),
       ('c890a902-b1a3-4f5c-a629-c78eb86e3520', 'Mix Party ticket', 75, 100000, '16c4e551-09d8-42c3-8f91-bf63ed980b1e'),
       ('dd953cbf-faad-4bc0-a6ce-884cff968ee4', 'Mix Party ticket', 60, 100000, '16c4e551-09d8-42c3-8f91-bf63ed980b1e'),
       ('7312ee6c-cf4c-4b7d-b179-a213fcec3a52', 'Night Party ticket', 55, 58000,
        'b328bc9c-79a8-4b24-bbeb-2806b06ce3f6'),
       ('3e0456f5-0fda-45c6-874e-05e1cde9974d', 'Night Party ticket', 44, 58000,
        'b328bc9c-79a8-4b24-bbeb-2806b06ce3f6'),
       ('fa42974d-ebc2-416f-8508-82e783881d86', 'Music Party ticket', 10, 25000,
        'a6221ba5-639e-4952-a95c-3ff6b018a8ad'),
       ('6fd17e88-b8d1-40af-a8cf-df07a27ab8e8', 'Music Party ticket', 8, 25000, 'a6221ba5-639e-4952-a95c-3ff6b018a8ad'),
       ('44ff5b30-043c-4c1a-9842-303751ee7f8d', 'Giga Party ticket', 200, 9000,
        '864df722-b890-4ace-adf8-ddeb888d25fd'),
       ('bb58543e-246b-46ff-8a4e-35d7b2e530fe', 'Giga Party ticket', 160, 9000,
        '864df722-b890-4ace-adf8-ddeb888d25fd');

INSERT INTO public.carts (id, user_id, total_price, state)
VALUES ('d85544dd-c85b-4f9b-a600-52f91388d6d0', '669d5162-84b0-4edc-b043-3ccfa71eb0a9', 80, 0),
       ('ca395e38-c52d-46c7-b0f1-4a6c0d10678a', '669d5162-84b0-4edc-b043-3ccfa71eb0a9', 75, 3),
       ('befe0a2c-828d-48f4-8273-81afcbd39be5', '59f6ee1e-cc37-4d54-8852-ab09f6fd46a7', 0, 0);

INSERT INTO public.cart_content (cart_id, ticket_id, quantity)
VALUES ('d85544dd-c85b-4f9b-a600-52f91388d6d0',
        'cec7ef16-66db-4916-96cd-4e4a2057ae8c', 1),
       ('d85544dd-c85b-4f9b-a600-52f91388d6d0',
        'eaa814ee-398e-435e-950c-32bc56cf0c90', 1),
       ('ca395e38-c52d-46c7-b0f1-4a6c0d10678a', '788c28db-0b2a-48d5-a010-cf138292d212', 1),
       ('ca395e38-c52d-46c7-b0f1-4a6c0d10678a', 'eaa814ee-398e-435e-950c-32bc56cf0c90', 1);

INSERT INTO public.soldtickets (id, name, price, user_id, ticket_id, party_id)
VALUES ('ef54b2c6-15bb-498f-9118-064db56f611b', 'Hola Amigo ticket', 25, '669d5162-84b0-4edc-b043-3ccfa71eb0a9',
        '788c28db-0b2a-48d5-a010-cf138292d212', '8a03e604-ed5f-457f-82c3-11d35e54d496'),
       ('d45fcf22-e954-4639-9c73-8fb0040e1335', 'Music Fiesta ticket', 50, '669d5162-84b0-4edc-b043-3ccfa71eb0a9',
        'eaa814ee-398e-435e-950c-32bc56cf0c90', '8243ea21-155b-4ac9-b75e-f66fc142c2ef');
```

