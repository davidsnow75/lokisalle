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

// On définit ici le contrôleur par défaut (celui de la page d'accueil)
define('DEFAULT_CONTROLLER', 'Home');
