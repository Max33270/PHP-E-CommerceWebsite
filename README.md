## Installations

- Windows : installer XAMPP (https://www.apachefriends.org/fr/download.html)
- MacOs : installer MAMP (https://www.mamp.info/en/downloads/)
- Linux : installer LAMP (https://doc.ubuntu-fr.org/lamp)

## Lancement du serveur

- Windows : lancer XAMPP Control Panel et démarrer les services Apache et MySQL
- MacOs : lancer MAMP et démarrer les services Apache et MySQL
- Linux : lancer LAMP et démarrer les services Apache et MySQL

## Création de la base de données

- Créer une base de données 
- Importer le fichier `database.sql` dans la base de données

## Configuration du projet

- Ouvrir le fichier `config.php` et modifier les paramètres de connexion à la base de données

## Lancement du projet

- Renommer le fichier `php_exam`
- Ouvrir un navigateur et taper l'adresse `http://localhost/php_exam/index.php`

## Utilisation du projet

- Partie Home :
Cette partie recense tous les articles de tous les utilisateurs autre que soi-même. Pour aller dans le détail de chaque article on clic sur la carte. Pour avoir accès aux informations concernant le vendeur, on clic sur son pseudo.

- Partie Détail :
Cette partie permet de voir les informations qui concerne l'article sur lequel on a cliqué. On peut l'ajouter au panier.

- Partie Profil :
Cette partie nous donne accès à notre profil ou à celui des autres utilisateurs grâce à la barre de recherche. On peut modifier son solde et ses informations.

- Partie Cart :
Cette partie est le panier. Si notre solde est suffisant, on peut valider son panier, remplir quelques informations et valider l'achat.

- Partie Sell :
Cette partie permet de vendre un article.

- Partie Admin :
Cette partie est utilisable que par les admins. Elle permet de modifier et supprimer des utilisateurs et des articles.

