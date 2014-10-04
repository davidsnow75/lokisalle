<?php

/**
 * config.php
 * ----------
 * Définition des paramètres indispensables au bon fonctionnement de l'appli
 */

// infos de connexion à la base de données (via un objet mysqli)
define('DB_HOST', 'localhost');
define('DB_NAME', 'lokisalle');
define('DB_USER', 'lokiser');
define('DB_PASS', 'lokipass');

// le contrôleur par défaut (celui de la page d'accueil)
define('DEFAULT_CONTROLLER', 'Accueil');

// souhaite-on voir les infos de debug ?
define('DEBUG', true);
// si oui, souhaite-on les afficher par défaut ?
define('DEBUG_AGGRESSIF', false);

// souhaite-t-on préfixer les urls d'administration avec 'admin' ?
define('ADMIN_CONTROLLERS_ARE_PREFIXED', false);
// le préfixe pour les fichiers de contrôleur admin
define('ADMIN_CONTROLLER_PREFIX', 'gestion');
