<?php

class EspacepersoController extends MembreController
{
    public function index()
    {
        // requête des infos du membre
        $fields = 'id, pseudo, nom, email, sexe, ville, cp, adresse, statut';

        $manager = $this->loadModel('MembresManagerModel');

        $data['membres'] = $manager->get_items( 'membres', [$this->id], $fields );
        $data['isAbonne'] = (bool) $manager->isAbonneNewsletter( Session::get('user.id') );

        if ( $data['isAbonne'] ) {
            $data['lastNewsletter'] = $this->loadModel('NewsletterManager')->getLastNewsletter();
        }

        $data['commandes'] = $this->loadModel('CommandeCollector')->getCommandesFromUser( Session::get('user.id') );

        // stockage d'un éventuel msg de la part d'un modèle
        $data['msg'] = $this->test_events_msg();

        // rendu de la page
        $this->renderView('espaceperso/index', $data);
    }

    // modification des infos du membre (formulaire)
    public function modifier()
    {
        $membres_manager = $this->loadModel('MembresManagerModel');

        // si on accède à cette méthode depuis un formulaire, alors on a du travail
        if ( !empty($_POST['id'] ) ) {

            // si l'id demandé pour modification ne correspond pas à l'utilisateur qui
            // demande la modif, alors on interdit toute poursuite des opérations
            if ( $_POST['id'] !== $this->id ) {
                $this->quit('/espaceperso', 'events.espaceperso.msg', 'forbidden_access');
            }

            $modif_return = $membres_manager->modify_item();

            $this->quit('/espaceperso/modifier', 'events.espaceperso.msg', $modif_return);

        } else { // sinon, on se contente d'afficher le formulaire de modification d'un membre

            $fields = 'id, pseudo, nom, email, sexe, ville, cp, adresse, statut';

            $data['membre'] = $membres_manager->get_items( 'membres', [$this->id], $fields );

            // stockage d'un éventuel msg de la part d'un modèle
            $data['msg'] = $this->test_events_msg();

            $this->renderView('espaceperso/modifier', $data);
        }
    }

    public function abonnement()
    {
        if ( isset($_POST['abonnement']) ) {
            if ( $this->loadModel('MembresManagerModel')->abonnerNewsletter(Session::get('user.id')) ) {
                $aboMsg = 'abo_success';
            } else {
                $aboMsg = 'abo_failure';
            }

        } elseif ( isset($_POST['desabonnement']) ) {
            if ( $this->loadModel('MembresManagerModel')->desabonnerNewsletter(Session::get('user.id')) ) {
                $aboMsg = 'desabo_success';
            } else {
                $aboMsg = 'desabo_failure';
            }

        } else {
            $this->quit('/espaceperso');
        }

        $this->quit('/espaceperso', 'events.espaceperso.msg', $aboMsg);
    }

    protected function test_events_msg()
    {
        if ( Session::get('events.espaceperso.msg') ) {
            switch ( Session::flashget('events.espaceperso.msg') ) {
                case 'pseudo_missing'     : $msg = 'Le pseudo doit être renseigné.'; break;
                case 'pseudo_length'      : $msg = 'Le pseudo doit comprendre entre 2 et 15 caractères.'; break;
                case 'pseudo_doesnt_fit'  : $msg = 'Le pseudo ne respecte pas le bon motif.'; break;
                case 'password_missing'   : $msg = 'Le mot de passe doit être renseigné.'; break;
                case 'password_length'    : $msg = 'Le mot de passe est trop court.'; break;
                case 'password_mismatch'  : $msg = 'Les mots de passe ne correspondent pas.'; break;
                case 'name_missing'       : $msg = 'Le nom doit être renseigné.'; break;
                case 'name_length'        : $msg = 'Le nom ne doit pas dépasser 20 caractères.'; break;
                case 'email_missing'      : $msg = 'L\'adresse e-mail est obligatoire.'; break;
                case 'email_length'       : $msg = 'L\'adresse e-mail ne doit pas dépasser 30 caractères.'; break;
                case 'email_doesnt_fit'   : $msg = 'L\'adresse e-mail ne respecte pas le motif légal.'; break;
                case 'sexe_missing'       : $msg = 'Le sexe est obligatoire.'; break;
                case 'sexe_doesnt_fit'    : $msg = 'Le sexe est inconnu.'; break;
                case 'city_missing'       : $msg = 'La ville doit être renseignée.'; break;
                case 'city_length'        : $msg = 'La ville ne doit pas dépasser 20 caractères.'; break;
                case 'zipcode_missing'    : $msg = 'Le code postal doit être renseigné.'; break;
                case 'zipcode_length'     : $msg = 'Le code postal ne doit pas dépasser 5 caractères.'; break;
                case 'adresse_missing'    : $msg = 'L\'adresse postale doit être renseignée.'; break;
                case 'adresse_length'     : $msg = 'L\'adresse postale ne doit pas dépasser 30 caractères.'; break;
                case 'pseudo_unavailable' : $msg = 'Le pseudo demandé appartient déjà à un autre utilisateur.'; break;
                case 'email_unavailable'  : $msg = 'L\'email demandé appartient déjà à un autre utilisateur.'; break;
                case 'valid_modify_item'  : $msg = 'Les modifications ont bien été enregistrées.'; break;
                case 'forbidden_access'   : $msg = 'L\'opération demandée est interdite.'; break;
                case 'abo_success'        : $msg = 'Vous êtes désormais abonné(e) à la newsletter !'; break;
                case 'abo_failure'        : $msg = 'Une erreur s\'est produite lors de votre tentative d\'abonnement à la newsletter.'; break;
                case 'desabo_success'     : $msg = 'Votre désabonnement a bien été pris en compte.'; break;
                case 'desabo_failure'     : $msg = 'Une erreur s\'est produite lors de votre tentative de désabonnement à la newsletter.'; break;
                default                   : $msg = 'Une erreur inconnue s\'est produite.';
            }
        } else {
            $msg = null;
        }

        return $msg;
    }
}
