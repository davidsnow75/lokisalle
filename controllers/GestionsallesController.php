<?php

/* Gestion des salles par l'administrateur
 */

class GestionsallesController extends AdminController
{
    // affichage des salles
    // NOTE: GestionsallesController::index() prend un nombre indéfini d'arguments
    public function index()
    {
        $requested_ids = func_get_args();

        $salles_manager = $this->loadModel('SallesManagerModel');

        $data['salles'] = $salles_manager->get_items('salles', $requested_ids);

        $data['msg'] = $this->test_events_msg();

        $this->renderView('gestionsalles/index', $data);
    }

    // ajout d'une salle (formulaire)
    public function ajouter()
    {
        $salles_manager = $this->loadModel('SallesManagerModel');

        $ajout_return = $salles_manager->add_item( 'salles' );

        Session::set('events.gestionsalles.msg', $ajout_return);
        header('location: /gestionsalles');
    }

    // modification d'une salle (formulaire)
    public function modifier($id_salle)
    {
        if ( empty($id_salle) ) {
            header('location: /gestionsalles');
            return;
        }

        $salles_manager = $this->loadModel('SallesManagerModel');

        // si on accède à cette méthode depuis un formulaire, alors on a du travail
        if ( !empty($_POST['id'] ) ) {

            $modif_return = $salles_manager->modify_item();

            Session::set('events.gestionsalles.msg', $modif_return);
            header('location: /gestionsalles/modifier/' . intval($_POST['id']) );

        } else { // sinon, on se contente d'afficher le formulaire de modification d'une salle

            $data['salle'] = $salles_manager->get_items( 'salles', array($id_salle) );

            if ( empty($data['salle']) ) {
                header('location: /gestionsalles/index/' . intval($id_salle));
                return;
            }

            $data['msg'] = $this->test_events_msg();

            // une salle a bien été trouvée, on affiche le formulaire pour la modifier
            $this->renderView('gestionsalles/modifier', $data);
        }
    }

    // suppression d'une salle
    public function supprimer($id_salle)
    {
        if ( empty($id_salle) ) {
            header('location: /gestionsalles');
            return;
        }

        $salles_manager = $this->loadModel('SallesManagerModel');

        // si le test échoue, c'est que la validation n'a pas été envoyée
        if ( !empty($_POST['id']) ) {

            $delete_return = $salles_manager->delete_item( 'salles', intval($_POST['id']) );

            Session::set('events.gestionsalles.msg', $delete_return);
            header('location: /gestionsalles');

        } else {
            // la validation n'a donc pas été envoyée, on affiche un message d'alerte
            $data = (int) $id_salle;

            $this->renderView('gestionsalles/supprimer', $data);
        }
    }

    protected function test_events_msg()
    {
        if ( Session::get('events.gestionsalles.msg') ) {
            switch ( Session::flashget('events.gestionsalles.msg') ) {
                case 'valid_add_item'       : $msg = 'La salle a été créée avec succès.'; break;
                case 'valid_modify_item'    : $msg = 'La salle a été modifiée avec succès.'; break;
                case 'valid_delete_item'    : $msg = 'La salle a été supprimée avec succès.'; break;
                case 'pays_missing'         : $msg = 'Le pays doit être renseigné.'; break;
                case 'pays_length'          : $msg = 'Le pays doit faire entre 2 et 20 caractères.'; break;
                case 'ville_missing'        : $msg = 'La ville doit être renseignée.'; break;
                case 'ville_length'         : $msg = 'La ville doit faire entre 2 et 20 caractères.'; break;
                case 'adresse_missing'      : $msg = 'L\'adresse doit être renseignée.'; break;
                case 'adresse_length'       : $msg = 'L\'adresse doit faire entre 2 et 20 caractères.'; break;
                case 'zipcode_missing'      : $msg = 'Le code postal doit être renseigné.'; break;
                case 'zipcode_length'       : $msg = 'Le code postal doit faire entre 2 et 5 caractères.'; break;
                case 'titre_missing'        : $msg = 'Le titre doit être renseigné.'; break;
                case 'titre_length'         : $msg = 'Le titre doit faire entre 2 et 200 caractères.'; break;
                case 'description_missing'  : $msg = 'La description doit être renseignée.'; break;
                case 'description_length'   : $msg = 'La description doit faire au minimum 3 caractères.'; break;
                case 'capacite_missing'     : $msg = 'La capacité doit être renseignée.'; break;
                case 'capacite_doesnt_fit'  : $msg = 'La capacité doit être un nombre entier.'; break;
                case 'capacite_length'      : $msg = 'La capacité ne peut excéder un nombre à trois chiffres.'; break;
                case 'categorie_missing'    : $msg = 'La catégorie doit être renseignée.'; break;
                case 'categorie_doesnt_fit' : $msg = 'La catégorie entrée n\'est pas disponible.'; break;
                case 'unknown_item_id'      : $msg = 'Aucune salle n\'a été supprimée.'; break;
                default                     : $msg = 'Une erreur inconnue s\'est produite.';
            }
        } else {
            $msg = null;
        }

        return $msg;
    }
}
