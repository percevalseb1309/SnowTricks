Symfony Standard Edition
========================

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/ef00a0921b8a46d496019332673e0336)](https://app.codacy.com/app/percevalseb1309/SnowTricks?utm_source=github.com&utm_medium=referral&utm_content=percevalseb1309/SnowTricks&utm_campaign=Badge_Grade_Settings)

**WARNING**: This distribution does not support Symfony 4. See the
[Installing & Setting up the Symfony Framework][15] page to find a replacement
that fits you best.

Welcome to the Symfony Standard Edition - a fully-functional Symfony
application that you can use as the skeleton for your new applications.

For details on how to download and get started with Symfony, see the
[Installation][1] chapter of the Symfony Documentation.

What's inside?
--------------

The Symfony Standard Edition is configured with the following defaults:

  * An AppBundle you can use to start coding;

  * Twig as the only configured template engine;

  * Doctrine ORM/DBAL;

  * Swiftmailer;

  * Annotations enabled for everything.

It comes pre-configured with the following bundles:

  * **FrameworkBundle** - The core Symfony framework bundle

  * [**SensioFrameworkExtraBundle**][6] - Adds several enhancements, including
    template and routing annotation capability

  * [**DoctrineBundle**][7] - Adds support for the Doctrine ORM

  * [**TwigBundle**][8] - Adds support for the Twig templating engine

  * [**SecurityBundle**][9] - Adds security by integrating Symfony's security
    component

  * [**SwiftmailerBundle**][10] - Adds support for Swiftmailer, a library for
    sending emails

  * [**MonologBundle**][11] - Adds support for Monolog, a logging library

  * **WebProfilerBundle** (in dev/test env) - Adds profiling functionality and
    the web debug toolbar

  * **SensioDistributionBundle** (in dev/test env) - Adds functionality for
    configuring and working with Symfony distributions

  * [**SensioGeneratorBundle**][13] (in dev env) - Adds code generation
    capabilities

  * [**WebServerBundle**][14] (in dev env) - Adds commands for running applications
    using the PHP built-in web server

  * **DebugBundle** (in dev/test env) - Adds Debug and VarDumper component
    integration

All libraries and bundles included in the Symfony Standard Edition are
released under the MIT or BSD license.

Enjoy!

[1]:  https://symfony.com/doc/3.4/setup.html
[6]:  https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/index.html
[7]:  https://symfony.com/doc/3.4/doctrine.html
[8]:  https://symfony.com/doc/3.4/templating.html
[9]:  https://symfony.com/doc/3.4/security.html
[10]: https://symfony.com/doc/3.4/email.html
[11]: https://symfony.com/doc/3.4/logging.html
[13]: https://symfony.com/doc/current/bundles/SensioGeneratorBundle/index.html
[14]: https://symfony.com/doc/current/setup/built_in_web_server.html
[15]: https://symfony.com/doc/current/setup.html

-----------------

# SnowTricks

__OpenClassrooms project :__ Develop from A to Z the SnowTricks Community Site  
  
![Snowboard](https://thumbor-static.factorymedia.com/OJxibllyrCCWLL62lW_o5YSaFYk=/620x413/smart/http%3A%2F%2Fcdn.coresites.factorymedia.com%2Fwhitelines_new%2Fwp-content%2Fuploads%2F2012%2F12%2Ffrontflipknuckle-620x413.jpg)

## Installation

1. Clone or download this repository in your project folder.

2. In the folder app/config, rename the file parameters.yml.dist by parameters.yml and fill it with your database's and mail's credentials. 

3. From the root directory, open a new terminal window and run the next command lines to install the database structure, tables and datas :
  php bin/console doctrine:database:create
  php bin/console doctrine:schema:update  --dump-sql
  php bin/console hautelook:fixtures:load

4. Install all the project dependencies by running the next command line on your terminal :
  composer install

5. Load the compiled css and js files in the prod environment by running the next command line on your terminal :
  php bin/console assetic:dump --env=prod
  
## Assignment (in french)

__Contexte__

Jimmy Sweat est un entrepreneur ambitieux passionné de snowboard. Son objectif est la création d'un site collaboratif pour faire connaitre ce sport auprès du grand public et aider à l'apprentissage des figures (tricks).

Il souhaite capitaliser sur du contenu apporté par les internautes afin de développer un contenu riche et suscitant l’intérêt des utilisateurs du site. Par la suite, Jimmy souhaite développer un business de mise en relation avec les marques de snowboard grâce au trafic que le contenu aura généré.

Pour ce projet, nous allons nous concentrer sur la création technique du site pour Jimmy.

__Description du besoin__

Vous êtes chargé de développer le site répondant aux besoins deJimmy. Vous devez ainsi implémenter les fonctionnalités suivantes : 
*	Un annuaire des figures de snowboard. Contentez-vous d'intégrer 10 figures, le reste sera saisi par les internautes,
*	La gestion des figures (création, modification, consultation),
*	Un espace de discussion commun à toutes les figures.

Pour implémenter ces fonctionnalités, vous devez créer les pages suivantes :
*	La page d’accueil où figurera la liste des figures 
*	La page de création d'une nouvelle figure
*	La page de modification d'une figure
*	La page de présentation d’une figure (contenant l’espace de discussion commun autour d’une figure).

__Nota Bene__

Il faut que les URLs de page permettent une compréhension rapide de ce que la page représente et que le référencement naturel soit facilité.

L’utilisation de bundles tiers est interdite sauf pour les données initiales, vous utiliserez les compétences acquises jusqu’ici ainsi que la documentation officielle afin de remplir les objectifs donnés.

Le design du site web est laissé complètement libre. Néanmoins il faudra que le site soit consultable aussi bien sur un ordinateur que sur mobile.

En premier lieu il vous faudra écrire l’ensemble des issues/tickets afin de découper votre travail méthodiquement et vous assurer que l’ensemble du besoin client soit bien compris avec votre mentor. Les tickets/issues seront écrits dans un repository Github que vous aurez créé au préalable.

L’ensemble des figures de snowboard doivent être présentes à l’initialisation de l’application web. Vous utiliserez un bundle externe pour charger ces données. 
