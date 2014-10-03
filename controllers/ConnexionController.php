<?php

class ConnexionController extends Controller
{
    public function index()
    {
        if ( Session::userIsLoggedIn() ) {
            $this->renderView('connexion/espaceperso');
            return;
        }

        // si un message a été enregistré à l'attention de ce contrôleur
        if ( Session::get('events.connexion.msg') ) {

            switch ( Session::flashget('events.connexion.msg') ) {
                case 'empty_fields'       : $data = 'Tous les champs doivent être renseignés.'; break;
                case 'unknown_user'       : $data = 'Utilisateur inconnu'; break;
                case 'wrong_password'     : $data = 'Mot de passe incorrect'; break;
                case 'valid_inscription'  : $data = 'Inscription réussie. Vous pouvez maintenant vous connecter.'; break;
                default                   : $data = 'Une erreur inconnue s\'est produite.';
            }

        } else {
            $data = null;
        }

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

        $data = $login_model->logout();

        $this->renderView('connexion/index', $data);
    }
}
