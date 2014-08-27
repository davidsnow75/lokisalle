<?php

require 'inc/init.php';
require 'inc/controllers.php';

$uri = $_SERVER['REQUEST_URI'];

if (RACINE_SITE.'/index.php' == $uri) {

    accueillir();

} else {

    renvoyer404();

}