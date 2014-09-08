<?php

class RegistrationModel
{
    protected $db;

    // tous les modèles reçoivent lors de leur instanciation la connexion
    // à la BDD établie par le contrôleur (cf. /core/Controller.php)
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function register()
    {
        // tous les tests préalables au traitement des données sont faits ici
        if (empty($_POST['pseudo'])):
            $erreur = 'empty_pseudo';

        elseif (empty($_POST['mdp']) OR empty($_POST['mdp_bis'])):
            $erreur = 'missing_password';

        elseif ($_POST['mdp'] !== $_POST['mdp']):
            $erreur = 'different_passwords';

        elseif (strlen($_POST['mdp']) < 6):
            $erreur = 'password_too_short';

        elseif (strlen($_POST['pseudo']) > 64 OR strlen($_POST['pseudo']) < 2):
            $erreur = 'pseudo_length';

        elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['pseudo'])):
            $erreur = 'pseudo_doesnt_fit';

        elseif (empty($_POST['email'])):
            $erreur = 'mandatory_email';

        elseif (strlen($_POST['email']) > 64):
            $erreur = 'email_length';

        elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)):
            $erreur = 'email_doesnt_fit';

        elseif (!empty($_POST['pseudo'])
            AND strlen($_POST['pseudo']) <= 64
            AND strlen($_POST['pseudo']) >= 2
            AND preg_match('/^[a-z\d]{2,64}$/i', $_POST['pseudo'])
            AND !empty($_POST['email'])
            AND strlen($_POST['email']) <= 64
            AND filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
            AND !empty($_POST['mdp'])
            AND !empty($_POST['mdp_bis'])
            AND ($_POST['mdp'] === $_POST['mdp_bis'])):

            // on hashe le mdp avant tout autre traitement pour ne pas l'altérer
            $_POST['mdp'] = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

            // préparation (échappement des caractères spéciaux) à l'utilisation dans mysql
            foreach($_POST as $key => $value) {
                $clean[$key] = $this->db->real_escape_string($value);
            }

        endif;

        return $erreur;
    }
}
