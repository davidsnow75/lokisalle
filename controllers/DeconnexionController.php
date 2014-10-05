<?php

class DeconnexionController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        if ( !Session::userIsLoggedIn() ) {
            Session::set('events.connexion.msg', 'no_active_connexion');
            header('location: /connexion');
            exit;
        }
    }

    public function index()
    {
        $this->deconnecter();
    }

    /* déclenche l'action de déconnexion */
    protected function deconnecter()
    {
        $login_model = $this->loadModel('LoginModel');
        $logout_msg = $login_model->logout();

        Session::set('events.connexion.msg', $logout_msg);
        header('location: /connexion');
        exit;
    }
}
