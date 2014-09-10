<?php

/* Gère le processus de connexion/déconnexion
 * En dehors des
 *
 */

class Login extends Controller
{
    /* renvoie le formulaire de connexion */
    public function index($error_msg = null)
    {
        switch ($error_msg) {
            case 'empty_fields':
                $data = 'Tous les champs doivent être renseignés.';
                break;
            case 'unknown_user':
                $data = 'Utilisateur inconnu';
                break;
            case 'wrong_password':
                $data = 'Mot de passe incorrect';
                break;
            default:
                $data = null;
        }

        if ( Session::userIsLoggedIn() ) {
            $this->renderView('login/espaceperso');
        } else {
            $this->renderView('login/index', $data);
        }
    }

    /* déclenche l'action de connexion */
    public function doLogin()
    {
        $login_model = $this->loadModel('Login');

        $login_return = $login_model->login();

        if ( $login_return === true ) {
            header('location: /login/espaceperso');
        } else {
            header('location: /login/index/' . $login_return);
        }
    }

    /* déclenche l'action de déconnexion */
    public function doLogout()
    {
        $login_model = $this->loadModel('Login');

        $data = $login_model->logout();

        $this->renderView('login/index', $data);
    }
}
