<?php

class ConnexionController extends Controller
{
    public function index()
    {
        if ( Session::userIsLoggedIn() ) {
            $this->renderView('connexion/espaceperso');
            return;
        }

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

        header('location: /connexion');
    }

    /* déclenche l'action de déconnexion */
    public function deconnecter()
    {
        $login_model = $this->loadModel('LoginModel');

        $data['msg'] = $login_model->logout();

        $this->renderView('connexion/index', $data);
    }

    protected function test_events_msg()
    {
        if ( Session::get('events.connexion.msg') ) {
            switch ( Session::flashget('events.connexion.msg') ) {
                case 'empty_fields'       : $msg = 'Tous les champs doivent être renseignés.'; break;
                case 'unknown_user'       : $msg = 'Utilisateur inconnu'; break;
                case 'wrong_password'     : $msg = 'Mot de passe incorrect'; break;
                case 'valid_inscription'  : $msg = 'Inscription réussie. Vous pouvez maintenant vous connecter.'; break;
                default                   : $msg = 'Une erreur inconnue s\'est produite.';
            }
        } else {
            $msg = null;
        }

        return $msg;
    }
}
