Lokisalle
=========

Lokisalle est un projet de fin de stage pour la validation d'une formation de développeur-intégrateur web effectuée à l'IFOCOP (2014).

Il s'agit d'un site e-commerce à destination d'une entreprise fictive de location de salles pour professionnels.

Parmi les contraintes du cahier des charges client, on exigeait notamment :

  - Projet entièrement réalisé *à partir de zéro*, sans l'aide d'un framework front-end ou back-end tiers
  - Site vitrine d'une société
  - *Site e-commerce* de cette société (permettre la location de salle et la participation d'une communauté de membres-clients)
  - Back-office à destination du loueur *lui permettant d'administrer son site e-commerce de manière autonome*

État du projet
----

Toutes les fonctionnalités majeures sont opérationnelles.
Dans l'idéal, on améliorerait le design, et on continuerait à traquer les éventuelles bugs restant !


Technique
-----------

Lokisalle a été codé en PHP5 orienté objet, avec le support de MySQL comme base de données.
J'ai souhaité afin de travailler le plus possible selon les méthodes professionnelles en vogue actuellement que Lokisalle soit développé selon un patron Modèle-Vue-Contrôleur (même si dans les faits, cela ressemble plutôt à du Modèle-Vue-Présentation).

Compte-tenu de l'interdiction d'utiliser un quelconque framework, j'ai développé pour le backend mon propre framework MVC en m'inspirant de l'architecture du projet minimaliste PHP-MVC.

De même, pour le front-end, j'ai développé mon propre framework (*Colomanie*, disponible à cette adresse https://github.com/erwanthomas/colomanie) en m'inspirant de Bootstrap 3 de Twitter. Lokisalle est donc un site en responsive design adapté à tout support.

En vrac, on retrouve donc les langages suivants :
- PHP5
- MySQL
- HTML5
- CSS3 (via LESS)
- JavaScript

Installation
--------------

Si vous souhaitez utiliser Lokisalle pour, par exemple, le tester, c'est possible !
Vous trouverez dans le dossier /_metadata tout ce qu'il faut pour l'installer sur votre serveur web (que ce soit Apache ou Nginx, sur Windows ou Linux, ça marche !).

Petites mises en garde cependant... :
- Votre serveur **doit** pointer vers /public/ comme répertoire racine (du serveur ou de l'alias) du  projet.
- N'oubliez pas de vérifier que la configuration du site est correcte dans /core/config.php


License
----

MIT
