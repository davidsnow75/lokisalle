<?php

/**
 * config.php
 * ----------
 * Définition des paramètres indispensables au bon fonctionnement de l'appli
 */


// à commenter (ou effacer) à la mise en production
error_reporting(E_ALL);
ini_set("display_errors", 1);

// l'url racine de l'appli (ne pas oublier de terminer par un slash)
define('URL', 'http://lokisalle/');

// infos de connexion à la base de données (via un objet mysqli)
define('DB_HOST', 'localhost');
define('DB_NAME', 'lokisalle');
define('DB_USER', 'lokiser');
define('DB_PASS', 'lokipass');