# SnowTricks [![Codacy Badge](https://api.codacy.com/project/badge/Grade/ef00a0921b8a46d496019332673e0336)](https://app.codacy.com/app/percevalseb1309/SnowTricks?utm_source=github.com&utm_medium=referral&utm_content=percevalseb1309/SnowTricks&utm_campaign=Badge_Grade_Settings)

__OpenClassrooms project :__ Develop from A to Z the SnowTricks Community Site

![Snowtrick](web/img/default.jpeg)

## Installation

1.  Clone or download this repository in your project folder.
2.  In the folder app/config, rename the file parameters.yml.dist by parameters.yml and fill it with your database's and mail's credentials.
3.  From the root directory, open a new terminal window and run the next command lines to install the database structure, tables and datas :
```
php bin/console doctrine:database:create
php bin/console doctrine:schema:update  --dump-sql
php bin/console hautelook:fixtures:load
```
4.  Install all the project dependencies by running the next command line on your terminal :
```
composer install
```
5.  Load the compiled css and js files in the prod environment by running the next command line on your terminal :
```
php bin/console assetic:dump --env=prod
```
  
## Assignment (in french)

__Contexte__

Jimmy Sweat est un entrepreneur ambitieux passionné de snowboard. Son objectif est la création d'un site collaboratif pour faire connaitre ce sport auprès du grand public et aider à l'apprentissage des figures (tricks).

Il souhaite capitaliser sur du contenu apporté par les internautes afin de développer un contenu riche et suscitant l’intérêt des utilisateurs du site. Par la suite, Jimmy souhaite développer un business de mise en relation avec les marques de snowboard grâce au trafic que le contenu aura généré.

Pour ce projet, nous allons nous concentrer sur la création technique du site pour Jimmy.

__Description du besoin__

Vous êtes chargé de développer le site répondant aux besoins deJimmy. Vous devez ainsi implémenter les fonctionnalités suivantes :
*   Un annuaire des figures de snowboard. Contentez-vous d'intégrer 10 figures, le reste sera saisi par les internautes
*   La gestion des figures (création, modification, consultation)
*   Un espace de discussion commun à toutes les figures

Pour implémenter ces fonctionnalités, vous devez créer les pages suivantes :
*   La page d’accueil où figurera la liste des figures 
*   La page de création d'une nouvelle figure
*   La page de modification d'une figure
*   La page de présentation d’une figure (contenant l’espace de discussion commun autour d’une figure).

__Nota Bene__

Il faut que les URLs de page permettent une compréhension rapide de ce que la page représente et que le référencement naturel soit facilité.

L’utilisation de bundles tiers est interdite sauf pour les données initiales, vous utiliserez les compétences acquises jusqu’ici ainsi que la documentation officielle afin de remplir les objectifs donnés.

Le design du site web est laissé complètement libre. Néanmoins il faudra que le site soit consultable aussi bien sur un ordinateur que sur mobile.

En premier lieu il vous faudra écrire l’ensemble des issues/tickets afin de découper votre travail méthodiquement et vous assurer que l’ensemble du besoin client soit bien compris avec votre mentor. Les tickets/issues seront écrits dans un repository Github que vous aurez créé au préalable.

L’ensemble des figures de snowboard doivent être présentes à l’initialisation de l’application web. Vous utiliserez un bundle externe pour charger ces données.
