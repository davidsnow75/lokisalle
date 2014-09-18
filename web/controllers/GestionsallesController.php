<?php

/* Gestion des salles par l'administrateur
 */

class GestionsallesController extends AdminController
{
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
