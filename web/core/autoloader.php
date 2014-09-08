<?php

function autoload($class)
{
    $class_lc = strtolower($class);

    if ( file_exists('./core/' . $class . '.php') ) {
        require './core/' . $class . '.php';

    } elseif ( file_exists('./controllers/' . $class_lc . '_ctrl.php') ) {
        require './controllers/' . $class_lc . '_ctrl.php';

    } elseif ( file_exists('./models/' . $class_lc . '_model.php') ) {
        require './models/' . $class_lc . '_model.php';

    } else {
        exit ('La classe ' . $class . ' est introuvable.');
    }
}

spl_autoload_register('autoload');
