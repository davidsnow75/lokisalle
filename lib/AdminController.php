<?php

/* Modèle de contrôleur spécifique aux pages d'administration
 */

abstract class AdminController extends Controller
{
    public function __construct()
    {
        // contrôle des permissions d'accès
        if ( !Session::userIsLoggedIn() ) {
            $this->quit('/connexion');
        } elseif ( Session::userIsLoggedIn() && !Session::userIsAdmin() ) {
            $this->quit('/');
        }

        parent::__construct();
    }
}
