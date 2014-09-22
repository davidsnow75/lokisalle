<?php

/* Gère le processus de connexion/déconnexion
 * En dehors des
 *
 */

class LoginController extends Controller
{
    /* renvoie le formulaire de connexion */

    public function index($error_msg = null)
    {
        if ( Session::userIsLoggedIn() ) {
            $this->renderView('login/espaceperso');
            return;
        }

        // si un message a été enregistré à l'attention de ce contrôleur
        if ( Session::get('events.login.msg') ) {

            switch ( Session::flashget('events.login.msg') ) {
                case 'empty_fields'       : $data = 'Tous les champs doivent être renseignés.'; break;
                case 'unknown_user'       : $data = 'Utilisateur inconnu'; break;
                case 'wrong_password'     : $data = 'Mot de passe incorrect'; break;
                case 'valid_registration' : $data = 'Inscription réussie. Vous pouvez maintenant vous connecter.'; break;
                default                   : $data = 'Une erreur inconnue s\'est produite.';
            }

        } else {
            $data = null;
        }

        $this->renderView('login/index', $data);
    }

    /* déclenche l'action de connexion */
    public function doLogin()
    {
        $login_model = $this->loadModel('LoginModel');

        $login_return = $login_model->login();

        if ( $login_return !== true ) {
            Session::set('events.login.msg', $login_return);
        }

        header('location: /login/index');
    }

    /* déclenche l'action de déconnexion */
    public function doLogout()
    {
        $login_model = $this->loadModel('LoginModel');

        $data = $login_model->logout();

        $this->renderView('login/index', $data);
    }
}
