Symfony 3WA
========================
Formation sur le framework Symfony 2 en collaboration avec SensioLabs basée sur un projet concret de A-Z http://symfony.3wa.fr/

PROGRAMME
========================

Rappels POO
========================
- Namespaces
- Classes : attributs et méthodes
- Héritage et Aggrégation

Les bases du framework
========================
- Installation de Symfony2
- Structure d'un projet
- Configurer son projet
- Déroulement d'une requête HTTP

Développement Bio
========================
- Les Bundles
- Les design patterns
- Conventions

MVC : Controleur
========================
- Principes
- Gestion des paramètres
- Objets Request et Response

MVC - Vue
========================
- Principes
- Twig
- Héritage et inclusions
- Utilisation des blocs

MVC : Modèle
========================
- Principe d'un ORM
- Le mapping de classes
- Interroger la base
 
Intéragir avec l'utilisateur
========================
- Les formulaires
- Les routes

Tester son code
========================
- Tests unitaires
- Tests fonctionnels
 
Déploiement sans outils
========================
- Déployer en production à l'ancienne
- Tester votre code
- Focus capifony, capistrano, travis 
 
Install
========================
- Clone project
- Make composer install
- Make php app/console doctrine:database:create
- Make php app/console doctrine:schema:update --force
- Make php app/console doctrine:fixtures:load
