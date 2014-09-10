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
        // pour obtenir un 'sticky form'
        foreach($_POST as $key => $value) {
            $html_clean[$key] = htmlentities($value, ENT_QUOTES, "utf-8");
        }

        Session::set('registration_post', $html_clean);

        // tous les tests préalables au traitement des données sont faits ici
        if ( empty($_POST['pseudo']) ):
            return 'pseudo_missing';

        elseif ( strlen($_POST['pseudo']) > 15 OR strlen($_POST['pseudo']) < 2 ):
            return 'pseudo_length';

        elseif ( !preg_match('/^[a-z\d]{2,15}$/i', $_POST['pseudo']) ):
            return 'pseudo_doesnt_fit';

        elseif ( empty($_POST['mdp']) OR empty($_POST['mdp_bis']) ):
            return 'password_missing';

        elseif ( strlen($_POST['mdp']) < 6 ):
            return 'password_length';

        elseif ( $_POST['mdp'] !== $_POST['mdp_bis'] ):
            return 'password_mismatch';

        elseif ( empty($_POST['nom']) ):
            return 'name_missing';

        elseif ( strlen($_POST['nom']) > 20 ):
            return 'name_length';

        elseif ( empty($_POST['email']) ):
            return 'email_missing';

        elseif ( strlen($_POST['email']) > 30 ):
            return 'email_length';

        elseif ( !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ):
            return 'email_doesnt_fit';

        elseif ( !in_array($_POST['sexe'], ['m','f']) ):
            return 'sexe_doesnt_fit';

        elseif ( empty($_POST['ville']) ):
            return 'city_missing';

        elseif ( strlen($_POST['ville']) > 20 ):
            return 'city_length';

        elseif ( empty($_POST['cp']) ):
            return 'zipcode_missing';

        elseif ( strlen($_POST['cp']) > 5 ):
            return 'zipcode_length';

        elseif ( empty($_POST['adresse']) ):
            return 'adresse_missing';

        elseif ( strlen($_POST['adresse']) > 30 ):
            return 'adresse_length';

        else:
            // on hashe le mdp avant tout autre traitement pour ne pas l'altérer
            $_POST['mdp'] = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

            // préparation (échappement des caractères spéciaux) à l'utilisation dans mysql
            foreach($_POST as $key => $value) {
                $clean[$key] = $this->db->real_escape_string($value);
            }

            // insertion (et donc création) de l'utilisateur dans la base de données
            $sql = 'INSERT INTO membre (id_membre,
                                        pseudo,
                                        mdp,
                                        nom,
                                        email,
                                        sexe,
                                        ville,
                                        cp,
                                        adresse,
                                        statut)
                    VALUES ';

            return 'registration_success';
        endif;

        return 'Ceci ne devrait pas arriver !';
    }
}
