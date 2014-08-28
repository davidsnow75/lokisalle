<?php

function accueillir() {
    require RACINE_SERVEUR.'/tpl/accueil.php';
}

function renvoyer404() {
    header('Status: 404 Not Found');
    require RACINE_SERVEUR.'/tpl/404.php';
}