<?php

/* Gestion des salles par l'administrateur
 */

class GestionsallesController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        if ( !Session::userIsLoggedIn() ) {
            header('location: /login');
            exit(1);
        } elseif ( Session::userIsLoggedIn() && !Session::userIsAdmin() ) {
            header('location: /');
            exit(1);
        }
    }

    // affichage des salles
    public function index($id_salles = [])
    {
        $gestionsalles_model = $this->loadModel('GestionsallesModel');

        $data = $gestionsalles_model->afficher($id_salles);

        $this->renderView('gestionsalles/index', $data);
    }

    public function ajouter()
    {
        // ajout d'une salle (formulaire)
    }

    public function modifier()
    {
        // modification d'une salle (formulaire)
    }

    public function supprimer()
    {
        // suppression d'une salle
    }
}
