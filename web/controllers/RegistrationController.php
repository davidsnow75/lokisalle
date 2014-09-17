<?php

class RegistrationController extends Controller
{
    public function index($error_msg = null)
    {
        if (Session::userIsLoggedIn()) {
            header('location: /login/index');
            return;
        }

        switch ($error_msg) {
            case 'pseudo_missing':     $data['erreur'] = 'Le pseudo doit être renseigné.'; break;
            case 'pseudo_length':      $data['erreur'] = 'Le pseudo doit comprendre entre 2 et 15 caractères.'; break;
            case 'pseudo_doesnt_fit':  $data['erreur'] = 'Le pseudo ne respecte pas le bon motif.'; break;
            case 'password_missing':   $data['erreur'] = 'Le mot de passe doit être renseigné.'; break;
            case 'password_length':    $data['erreur'] = 'Le mot de passe est trop court.'; break;
            case 'password_mismatch':  $data['erreur'] = 'Les mots de passe ne correspondent pas.'; break;
            case 'name_missing':       $data['erreur'] = 'Le nom doit être renseigné.'; break;
            case 'name_length':        $data['erreur'] = 'Le nom ne doit pas dépasser 20 caractères.'; break;
            case 'email_missing':      $data['erreur'] = 'L\'adresse e-mail est obligatoire.'; break;
            case 'email_length':       $data['erreur'] = 'L\'adresse e-mail ne doit pas dépasser 30 caractères.'; break;
            case 'email_doesnt_fit':   $data['erreur'] = 'L\'adresse e-mail ne respecte pas le motif légal.'; break;
            case 'sexe_doesnt_fit':    $data['erreur'] = 'Le sexe est inconnu.'; break;
            case 'city_missing':       $data['erreur'] = 'La ville doit être renseignée.'; break;
            case 'city_length':        $data['erreur'] = 'La ville ne doit pas dépasser 20 caractères.'; break;
            case 'zipcode_missing':    $data['erreur'] = 'Le code postal doit être renseigné.'; break;
            case 'zipcode_length':     $data['erreur'] = 'Le code postal ne doit pas dépasser 5 caractères.'; break;
            case 'adresse_missing':    $data['erreur'] = 'L\'adresse postale doit être renseignée.'; break;
            case 'adresse_length':     $data['erreur'] = 'L\'adresse postale ne doit pas dépasser 30 caractères.'; break;
            case 'pseudo_unavailable': $data['erreur'] = 'Le pseudo demandé appartient déjà à un autre utilisateur.'; break;
            case 'email_unavailable':  $data['erreur'] = 'L\'email demandé appartient déjà à un autre utilisateur.'; break;
            default:                   $data['erreur'] = null;
        }

        $this->renderView('registration/index', $data);
    }

    public function register()
    {
        $registration_model = $this->loadModel('RegistrationModel');

        $register_return = $registration_model->register();

        if ( $register_return === true) {
            header('location: /login/index/valid_registration');
        } elseif ( $register_return === 'db_error' ) {
            header('location: /error/db_error/registration');
        } else {
            header('location: /registration/index/' . $register_return);
        }
    }
}
