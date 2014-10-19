<?php

class DeconnexionController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        if ( !Session::userIsLoggedIn() ) {
            $this->quitWithLog('/connexion', 'events.connexion.msg', 'no_active_connexion');
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
        $this->quitWithLog('/connexion', 'events.connexion.msg', $logout_msg);
    }
}
