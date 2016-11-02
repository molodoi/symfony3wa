Symfony Standard Edition
========================
Formation sur le framework Symfony 2 en collaboration avec SensioLabs basée sur un projet concret de A-Z

PROGRAMME
========================
-RAPPELS SUR LA POO
 Namespaces
 Classes : attributs et méthodes
 Héritage et Aggrégation

-LES BASES DE SYMFONY2
 Installation de Symfony2
 Structure d'un projet
 Configurer son projet
 Déroulement d'une requête HTTP

-LE DÉVELOPPEMENT BIO
 Les Bundles
 Les design patterns
 Conventions

-LE MVC : LE CONTROLEUR
 Principes
 Gestion des paramètres
 Objets Request et Response

-LE MVC - LA VUE
 Principes
 Twig
 Héritage et inclusions
 Utilisation des blocs

-LE MVC : LE MODÈLE
 Principe d'un ORM
 Le mapping de classes
 Interroger la base
 
-INTERAGIR AVEC L'UTILISATEUR
 Les formulaires
 Les routes

-TESTER SON CODE
 Tests unitaires
 Tests fonctionnels
-BASCULER EN PRODUCTION
 Déployer en production
 Tester votre code
 
 Install
========================
- Clone project
- Make composer install
- Make php app/console doctrine:database:create
- Make php app/console doctrine:schema:update --force
- Make php app/console doctrine:fixtures:load
