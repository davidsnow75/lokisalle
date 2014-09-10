<?php

function autoload($class)
{
    if ( file_exists('./core/' . $class . '.php') ) {
        require './core/' . $class . '.php';

    } elseif ( file_exists('./controllers/' . $class . '.php') ) {
        require './controllers/' . $class . '.php';

    } elseif ( file_exists('./models/' . $class . '.php') ) {
        require './models/' . $class . '.php';

    } else {
        exit ('La classe ' . $class . ' est introuvable.');
    }
}

spl_autoload_register('autoload');
