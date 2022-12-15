#Projet plante
##Application realisée dans le cadre d'un projet de fin de trimestre.

Contributeurs : Jeanne GABLIN, Raphael Dumas, Killian Lechevalier.

Version de PHP : 8.1.0
Version de Symfony : 6.1

Documentation(obligatoire pour le bon fonctionnement de l'application) :

*Vous devez telecharger WAMP(windows), LAMP(Linux), XAMP(Autres OS).

*Lancez wamp

*Vous devez creer une nouvelle base de donnees, pour cela vous pouvez utiliser Symfony en tappant "php bin/console 
doctrine:database:create" et ensuite en choisisant le nom que vous souhaitez.

*Vous devez renommer le fichier "env copy" en ".env" puis enlever le # au debut de la ligne suivant : 
# DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=8&charset=utf8mb4". Ensuite, vous
devez la remplir comme ceci : 
"mysql://identifiant de la bdd:mot de passe de la bdd@127.0.0.1:3306/nom de la BDD?serverVersion=8&charset=utf8mb4".

*Ensuite, vous devez lancer votre serveur Symfony de la maniere suivante : "symfony server:start".

