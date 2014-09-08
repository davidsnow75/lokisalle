<?php

// appel du fichier de configuration de l'application
require 'core/config.php';

// appel et mise en place de l'autoloader de classes
require 'core/autoloader.php';

Session::init();

$FrontController = new Application;
