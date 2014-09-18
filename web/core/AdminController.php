<?php

/* Modèle de contrôleur spécifique aux pages d'administration
 */

abstract class AdminController extends Controller
{
    public function __construct()
    {
        // initialisation ou récupération de la session
        Session::init();

        // contrôle des permissions d'accès
        if ( !Session::userIsLoggedIn() ) {
            header('location: /login');
            exit(0);
        } elseif ( Session::userIsLoggedIn() && !Session::userIsAdmin() ) {
            header('location: /');
            exit(0);
        }

        // le lien à la bdd est créé à chaque instanciation d'un contrôleur
        $this->openDatabaseConnection();
    }
}
