<?php

/* Modèle de contrôleur spécifique aux pages privées d'un membre
 */

abstract class MembreController extends Controller
{
    /* un contrôleur MembreController ne doit pouvoir accéder qu'aux infos du membre
     * qui le convoque. On stocke donc son ID pour plus de facilité.
     */
    protected $id;


    public function __construct()
    {
        // contrôle des permissions d'accès
        if ( !Session::userIsLoggedIn() ) {
            $this->quit('/connexion');
        }

        $this->id = Session::get('user.id');

        parent::__construct();
    }
}
