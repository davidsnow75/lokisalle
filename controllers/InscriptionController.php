<?php

class InscriptionController extends Controller
{
    public function index()
    {
        if ( Session::userIsLoggedIn() ) {
            $this->quit('/connexion');
        }

        $data['msg'] = $this->test_events_msg();
        $this->renderView('inscription/index', $data);
    }

    public function inscrire()
    {
        $register_return = $this->loadModel('MembresManagerModel')->add_item('membres');

        if ( $register_return === 'valid_add_item' ) {
            $this->quit( '/connexion', 'events.connexion.msg', 'valid_inscription' );
        } else {
            $this->quit( '/inscription', 'events.inscription.msg', $register_return );
        }
    }

    protected function test_events_msg()
    {
        if ( Session::get('events.inscription.msg') ) {
            switch ( Session::flashget('events.inscription.msg') ) {
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
                case 'sexe_missing'       : $msg = 'Préciser le sexe est obligatoire.'; break;
                case 'sexe_doesnt_fit'    : $msg = 'Le sexe est inconnu.'; break;
                case 'city_missing'       : $msg = 'La ville doit être renseignée.'; break;
                case 'city_length'        : $msg = 'La ville ne doit pas dépasser 20 caractères.'; break;
                case 'zipcode_missing'    : $msg = 'Le code postal doit être renseigné.'; break;
                case 'zipcode_length'     : $msg = 'Le code postal ne doit pas dépasser 5 caractères.'; break;
                case 'adresse_missing'    : $msg = 'L\'adresse postale doit être renseignée.'; break;
                case 'adresse_length'     : $msg = 'L\'adresse postale ne doit pas dépasser 30 caractères.'; break;
                case 'pseudo_unavailable' : $msg = 'Le pseudo demandé appartient déjà à un autre utilisateur.'; break;
                case 'email_unavailable'  : $msg = 'L\'email demandé appartient déjà à un autre utilisateur.'; break;
                default                   : $msg = 'Une erreur inconnue s\'est produite.';
            }
        } else {
            $msg = null;
        }

        return $msg;
    }
}
