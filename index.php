<?php

require 'inc/init.php';
require 'inc/model.php';
require 'inc/controllers.php';

$uri = $_SERVER['REQUEST_URI'];

if ('/' == $uri || '/index.php' == $uri) {

    accueillir();

} else {

    renvoyer404();

}