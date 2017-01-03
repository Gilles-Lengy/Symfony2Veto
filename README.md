Symfony2Veto
============

A Symfony project created on January 2, 2017, 3:19 pm.

The purpose of this project is to learn Symfony 2.

This is not a real life app.

# Installation
## 1. Récupérer le code
Vous avez deux solutions pour le faire :

1. Via Git, en clonant ce dépôt ; Vous aurez donc une version en cours de dévelloppement non stable...
2. Via le téléchargement du code source en une archive ZIP, à cette adresse : https://github.com/Gilles-Lengy/Symfony2Veto/releases/tag/170103.1514. Vous aurez une version stable à utiliser en mode dev de Symfony2.

## 2. Définir vos paramètres d'application
Pour ne pas qu'on se partage tous nos mots de passe, le fichier `app/config/parameters.yml` est ignoré dans ce dépôt. A la place, vous avez le fichier `parameters.yml.dist` que vous devez renommer (enlevez le `.dist`) et modifier.

## 3. Télécharger les vendors
Avec Composer bien évidemment :

    php composer.phar install

Ligne de commande à adapter à votre installation

## 4. Créez la base de données
Si la base de données que vous avez renseignée dans l'étape 2 n'existe pas déjà, créez-la :

    php app/console doctrine:database:create

Puis créez les tables correspondantes au schéma Doctrine :

    php app/console doctrine:schema:update --dump-sql
    php app/console doctrine:schema:update --force

Enfin, éventuellement, ajoutez les fixtures :

    php app/console doctrine:fixtures:load


## Et profitez !