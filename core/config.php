<?php

/**
 * config.php
 * ----------
 * Définition des paramètres indispensables au bon fonctionnement de l'appli
 */

// infos de connexion à la base de données (via un objet mysqli)
define('DB_HOST', 'localhost');
define('DB_NAME', 'lokisalle');
define('DB_USER', 'root');
define('DB_PASS', '');

// si le projet est en dans un sous-dossier du hostname, le définir ici (sans slash final)
define('SUBFOLDER', '/lokisalle');

// si le projet ne tourne pas sous rewriting d'URLs
define('NO_REWRITE', false);

// le contrôleur par défaut (celui de la page d'accueil)
define('DEFAULT_CONTROLLER', 'Accueil');

// souhaite-on voir les infos de debug ?
define('DEBUG', false);
// si oui, souhaite-on les afficher par défaut ?
define('DEBUG_AGGRESSIF', false);

setlocale (LC_TIME, 'fr_FR.utf8','fra');
