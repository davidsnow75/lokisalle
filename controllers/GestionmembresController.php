<?php

/* Gestion des membres par l'administrateur
 */

class GestionmembresController extends AdminController
{
    public function index()
    {
        $requested_ids = func_get_args();
        $fields = 'id, pseudo, nom, email, sexe, ville, cp, adresse, statut';
        $data['membres'] = $this->loadModel('MembresManagerModel')->get_items( 'membres', $requested_ids, $fields );

        $data['msg'] = $this->test_events_msg();

        $this->renderView('gestionmembres/index', $data);
    }

    // suppression d'un membre
    public function supprimer($id_membre)
    {
        if ( empty($id_membre) ) {
            $this->quit('/gestionmembres');
        }

        $membres_manager = $this->loadModel('MembresManagerModel');

        // si le test échoue, c'est que la validation n'a pas été envoyée
        if ( !empty($_POST['id']) ) {

            $clean_id = intval($_POST['id']);

            $membre_cible = $membres_manager->get_items( 'membres', [$clean_id], 'id, statut' );

            /* FIX TEMPORAIRE */
            if ( empty($membre_cible) ) {
                $this->quit('/gestionmembres', 'events.gestionmembres.msg', 'Le membre demandé pour suppression n\'existe pas.');
            }

            // un utilisateur ne peut pas se supprimer lui-même et
            // seul l'utilisateur spécial peut supprimer un administrateur
            if (
                $membre_cible[0]['id'] == Session::get('user.id')
                || ( $membre_cible[0]['statut'] == '1' && !Session::user_is_godlike() )
            ) {
                $this->quit('/gestionmembres', 'events.gestionmembres.msg', 'forbidden_access');
            }

            $delete_return = $membres_manager->delete_item( 'membres', intval($_POST['id']) );

            $this->quit('/gestionmembres', 'events.gestionmembres.msg', $delete_return);

        } else {
            // la validation n'a donc pas été envoyée, on affiche un message d'alerte
            $data = (int) $id_membre;

            $this->renderView('gestionmembres/supprimer', $data);
        }
    }

    // passage au statut administrateur
    public function setadmin()
    {
        $membres_manager = $this->loadModel('MembresManagerModel');

        // par défaut, seul un utilisateur spécial peut déclencher cette méthode
        if ( !Session::user_is_godlike() ) {
            $this->quit('/gestionmembres', 'events.gestionmembres.msg', 'forbidden_access');
        }

        // si on accède à cette méthode depuis un formulaire, alors on a du travail
        if ( !empty($_POST['id'] ) ) {

            $modif_return = $membres_manager->setadmin();
            $this->quit( '/gestionmembres/index/' . intval($_POST['id']), 'events.gestionmembres.msg', $modif_return );

        } else { // sinon, on se contente de renvoyer la page standard

            $this->quit('/gestionmembres');
        }
    }

    protected function test_events_msg()
    {
        if ( Session::get('events.gestionmembres.msg') ) {
            switch ( Session::flashget('events.gestionmembres.msg') ) {
                case 'valid_setadmin'    : $msg = 'Le membre a désormais le statut d\'administrateur.'; break;
                case 'valid_delete_item' : $msg = 'Le membre a été supprimé avec succès.'; break;
                case 'unknown_item_id'   : $msg = 'Aucun membre n\'a été supprimé.'; break;
                case 'forbidden_access'  : $msg = 'Vous n\'êtes pas autorisé à effectuer cette action.'; break;
                default                  : $msg = 'Une erreur inconnue s\'est produite.';
            }
        } else {
            $msg = null;
        }

        return $msg;
    }
}
