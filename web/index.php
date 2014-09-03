<?php

// appel du fichier de configuration de l'application
require 'core/config.php';

// appel du contrôleur frontal
require 'core/controller.php';
require 'core/application.php';

$controller = new Application;
