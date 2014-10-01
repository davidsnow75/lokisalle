<?php

/* Gestion des salles par l'administrateur
 */

class GestionsallesController extends AdminController
{
    // affichage des salles
    public function index()
    {
        $requested_ids = func_get_args();

        $gestionsalles_model = $this->loadModel('GestionsallesModel');

        $data['salles'] = $gestionsalles_model->get_salles($requested_ids);

        if ( Session::get('events.gestionsalles.msg') ) {
            switch ( Session::flashget('events.gestionsalles.msg') ) {
                case 'ajout_valid'          : $data['msg'] = 'La salle a été créée avec succès.'; break;
                case 'pays_missing'         : $data['msg'] = 'Le pays doit être renseigné.'; break;
                case 'pays_length'          : $data['msg'] = 'Le pays doit faire entre 2 et 20 caractères.'; break;
                case 'ville_missing'        : $data['msg'] = 'La ville doit être renseignée.'; break;
                case 'ville_length'         : $data['msg'] = 'La ville doit faire entre 2 et 20 caractères.'; break;
                case 'adresse_missing'      : $data['msg'] = 'L\'adresse doit être renseignée.'; break;
                case 'adresse_length'       : $data['msg'] = 'L\'adresse doit faire entre 2 et 20 caractères.'; break;
                case 'zipcode_missing'      : $data['msg'] = 'Le code postal doit être renseigné.'; break;
                case 'zipcode_length'       : $data['msg'] = 'Le code postal doit faire entre 2 et 5 caractères.'; break;
                case 'titre_missing'        : $data['msg'] = 'Le titre doit être renseigné.'; break;
                case 'titre_length'         : $data['msg'] = 'Le titre doit faire entre 2 et 200 caractères.'; break;
                case 'description_missing'  : $data['msg'] = 'La description doit être renseignée.'; break;
                case 'description_length'   : $data['msg'] = 'La description doit faire au minimum 3 caractères.'; break;
                case 'capacite_missing'     : $data['msg'] = 'La capacité doit être renseignée.'; break;
                case 'capacite_doesnt_fit'  : $data['msg'] = 'La capacité doit être un nombre entier.'; break;
                case 'capacite_length'      : $data['msg'] = 'La capacité ne peut excéder un nombre à trois chiffres.'; break;
                case 'categorie_missing'    : $data['msg'] = 'La catégorie doit être renseignée.'; break;
                case 'categorie_doesnt_fit' : $data['msg'] = 'La catégorie entrée n\'est pas disponible.'; break;
                default                     : $data['msg'] = 'Une erreur inconnue s\'est produite.';
            }
        } else {
            $data['msg'] = null;
        }

        $this->renderView('gestionsalles/index', $data);
    }

    // ajout d'une salle (formulaire)
    public function ajouter()
    {
        $gestionsalles_model = $this->loadModel('GestionsallesModel');

        $ajout_return = $gestionsalles_model->ajouter();

        if ( $ajout_return === 'db_error' ) {
            header('location: /error/db_error');

        } else {
            Session::set('events.gestionsalles.msg', $ajout_return);
            header('location: /gestionsalles');
        }
    }

    // modification d'une salle (formulaire)
    public function modifier($id_salle)
    {
        if ( empty($id_salle) ) {
            header('location: /gestionsalles');
        }
    }

    // suppression d'une salle
    public function supprimer($id_salle)
    {
        if ( empty($id_salle) ) {
            header('location: /gestionsalles');
        }
    }
}
