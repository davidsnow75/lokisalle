<?php

class LoginModel
{
    protected $db;

    // tous les modèles reçoivent lors de leur instanciation la connexion
    // à la BDD établie par le contrôleur (cf. /core/Controller.php)
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function login()
    {
        if ( !isset($_POST['username']) ||
              empty($_POST['username']) ||
             !isset($_POST['password']) ||
              empty($_POST['password'])
        ) {
            return 'empty_fields';
        }

        // Les données sont présentes:
        // Test 1: l'utilisateur existe-t-il ?

        $clean_username = $this->db->real_escape_string($_POST['username']);

        $result = $this->db->query('SELECT id_membre,
                                     pseudo,
                                     mdp,
                                     nom,
                                     email,
                                     sexe,
                                     ville,
                                     cp,
                                     adresse,
                                     statut
                                FROM membres
                                WHERE pseudo="' . $clean_username . '"');

        // si la requête n'a rien renvoyé, c'est que l'utilisateur n'existe pas
        if ( $result->num_rows === 0 ) {
            return 'unknown_user';
        }

        // l'utilisateur existe, on le récupère
        // NOTE: on ne récupère que le premier (normalement il n'y a qu'une seule
        // ligne de retournée, un pseudo devant être unique !)
        $user = $result->fetch_assoc();

        // Vérification du mot de passe
        if ( password_verify($_POST['password'], $user['mdp']) ) {
            // le mot de passe est bon, alors on ajoute l'utilisateur à la session
            Session::set('user_logged_in', true);
            foreach ($user as $key => $value) {
                Session::set($key, $value);
            }

        } else {
            return 'wrong_password';
        }

        // par défaut, l'utilisateur n'est pas connecté
        return false;
    }
}
