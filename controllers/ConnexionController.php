<?php

class ConnexionController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        if ( Session::userIsLoggedIn() ) {
           $this->quit('/espaceperso');
        }
    }

    public function index()
    {
        $data['msg'] = $this->test_events_msg();

        $this->renderView('connexion/index', $data);
    }

    /* déclenche l'action de connexion */
    public function connecter()
    {
        $login_model = $this->loadModel('LoginModel');

        $login_return = $login_model->login();

        if ( $login_return !== true ) {
            Session::set('events.connexion.msg', $login_return);
        }

        $this->quit('/connexion');
    }

    protected function test_events_msg()
    {
        if ( Session::get('events.connexion.msg') ) {
            switch ( Session::flashget('events.connexion.msg') ) {
                case 'empty_fields'        : $msg = 'Tous les champs doivent être renseignés.'; break;
                case 'unknown_user'        : $msg = 'Utilisateur inconnu'; break;
                case 'wrong_password'      : $msg = 'Mot de passe incorrect'; break;
                case 'valid_deconnexion'   : $msg = 'Vous êtes maintenant déconnecté.'; break;
                case 'no_active_connexion' : $msg = 'Pas de connexion en cours. Souhaitez-vous vous connecter ?'; break;
                case 'valid_inscription'   : $msg = 'Inscription réussie. Vous pouvez maintenant vous connecter.'; break;
                default                    : $msg = 'Une erreur inconnue s\'est produite.';
            }
        } else {
            $msg = null;
        }

        return $msg;
    }
}
