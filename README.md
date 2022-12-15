# Projet plante
## Application réalisée dans le cadre d'un projet de fin de trimestre.

Contributeurs : Raphael DUMAS, Jeanne GABLIN, Killian LECHEVALIER.

Version de PHP : 8.1.0
Version de Symfony : 6.1

### Contexte :

_Il s’agit d’un projet fictif, toute relation avec un projet existant ne serait que fortuite.

La ferme biologique du Bec Hellouin souhaite faire appel à vous afin de réaliser une petite application web de sensibilisation et de découverte de la flore locale. Ce projet répondant au nom de « Cherche & Trouve », souhaite mettre en place une petite application de jeu, à destination des enfants, leurs demandant de chercher autour d'eux, des plantes et de les photographier.

Dans l'idéal, le gérant de la ferme souhaiterait en faire une application permettant de géolocaliser les plantes afin de pouvoir réutiliser ces informations au sein d'autres applications._

Ce projet est un site avec le Framework Symfony.
Le but est de mettre en place un site adapté aux enfants qui permet de prendre des photos de plantes de faire valider par ses parents.

## Front-End :

On retrouvera dans le Front-End, partie client, une possibilité de jouer ainsi que d'avoir accès à son profil et de modifier ses informations. Il sera aussi possible de voir ses statistiques de ses plantes trouver.

## Back-End :

Dans la partie Back-End, partie administration, il sera possible d'ajouter des nouvelles plantes avec toutes les informations la concernant. Il sera possible d'avoir une vue sur les statisques de chaque utilisateurs.

---

Documentation (obligatoire pour le bon fonctionnement de l'application) :

* Vous devez telecharger WAMP (Windows), LAMP (Linux)ou XAMP (Autres OS).

* Lancez WAMP / LAMP / XAMP

* Executer ces commandes dans l'emplacement du projet 
`composer install`
`npm install`

* Vous devez renommer le fichier `env copy` en `.env`.

* Enlever le # au debut de la ligne suivant : 
#DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=8&charset=utf8mb4". 

* Ensuite, vous devez la remplir comme ceci : 
"mysql://identifiant de la bdd:mot de passe de la bdd@127.0.0.1:3306/nom de la BDD?serverVersion=8&charset=utf8mb4".

* Vous devez créer une nouvelle base de données, pour cela vous pouvez utiliser Symfony en tappant `php bin/console doctrine:database:create` et ensuite en choisisant le nom que vous souhaitez.

* Ensuite, vous devez lancer votre serveur Symfony de la manière suivante : "symfony server:start".

---

### Administration :

Pour avoir un compte d'administration il faut vous créer un compte sur l'interface du site.

Par la suite, connectez vous sur la base de donnée que vous avez crée.

Allez sur la table `user` et choisiez l'utilisateur que vous voulez changer.

Au niveau du `roles`, rentrer comme information `["ROLE_ADMIN"]`.

---

### Maquette du site :

https://www.figma.com/file/xB08noPFEsYzr94udzwlno/Projet-Plante?node-id=0%3A1&t=XuvCWcVSl4ggZGXx-1

---

### MCD de la base de donnée :

<img src="Annexe/MCD.png">

---

### Use Case du projet :

<img src="Annexe/Use_Case.png">

---

### UML du projet :

<img src="Annexe/UML.png">