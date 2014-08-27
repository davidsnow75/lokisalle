<?php

function accueillir() {
    require RACINE_SERVEUR.RACINE_SITE.'/tpl/accueil.php';
}

function renvoyer404() {
    header('Status: 404 Not Found');
    echo 'Page inexistante';
}