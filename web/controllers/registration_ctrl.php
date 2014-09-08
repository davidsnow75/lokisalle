<?php

class Registration extends Controller
{
    public function index($error_msg = null)
    {
        switch ($error_msg) {
            case 'empty_pseudo':       $data = 'Le pseudo doit être renseigné.'; break;
            case 'missing_password':   $data = 'Le mot de passe doit être renseigné.'; break;
            case 'wrong_password':     $data = 'Mot de passe incorrect'; break;
            case 'different_password': $data = 'Les mots de passe ne correspondent pas.'; break;
            case 'password_too_short': $data = 'Le mot de passe est trop court.'; break;
            case 'pseudo_length':      $data = 'Le pseudo doit comprendre entre 2 et 64 caractères.'; break;
            case 'pseudo_doesnt_fit':  $data = 'Le pseudo ne respecte pas le bon motif.'; break;
            case 'mandatory_email':    $data = 'L\'adresse e-mail est obligatoire.'; break;
            case 'email_length':       $data = 'L\'adresse e-mail ne doit pas dépasser 64 caractères.'; break;
            case 'email_doesnt_fit':   $data = 'L\'adresse e-mail ne respecter pas le motif légal.'; break;
            default: $data = '';
        }

        $this->renderView('registration/index', $data);
    }

    public function register()
    {
        $registration_model = $this->loadModel('Registration');

        $register_return = $registration_model->register();

        header('location: /registration/index/' . $register_return);
    }
}
