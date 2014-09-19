<?php

class RegistrationModel extends Model
{
    public function register()
    {
        // préalable indispensable
        if ( empty($_POST) ) { return 'pseudo_missing'; }

        // pour obtenir un 'sticky form'
        foreach($_POST as $key => $value) {
            if ( !in_array($key, ['mdp', 'mdp_bis'])  ) {
                $html_clean[$key] = htmlentities($value, ENT_QUOTES, "utf-8");
            }
        }

        // on enregistre les données avant les tests pour s'assurer qu'elles ne seront pas perdues
        Session::set('post_data.register', $html_clean);

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

        elseif ( empty($_POST['sexe']) ):
            return 'sexe_missing';

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
            // tout semble correct, mais on doit vérifier que le pseudo ou l'email ne sont pas déjà
            // utilisés par un autre utilisateur
            $sql = "SELECT id_membre
                    FROM membres
                    WHERE pseudo='" . $this->db->real_escape_string($_POST['pseudo']) . "';";
            if ( $this->db->query($sql)->num_rows != 0) {
                return 'pseudo_unavailable';
            }

            $sql = "SELECT id_membre
                    FROM membres
                    WHERE email='" . $this->db->real_escape_string($_POST['email'])  . "';";
            if ( $this->db->query($sql)->num_rows != 0) {
                return 'email_unavailable';
            }

            // Tout va bien, on continue

            // on chiffre le mdp avant tout autre traitement pour ne pas l'altérer
            $_POST['mdp'] = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

            // préparation (échappement des caractères spéciaux) à l'utilisation dans mysql
            foreach($_POST as $key => $value) {
                $clean[$key] = $this->db->real_escape_string($value);
            }

            // insertion (et donc création) de l'utilisateur dans la base de données
            $sql = "INSERT INTO membres (id_membre,
                                         pseudo,
                                         mdp,
                                         nom,
                                         email,
                                         sexe,
                                         ville,
                                         cp,
                                         adresse,
                                         statut)
                    VALUES ('',
                            '" . $clean['pseudo']  . "',
                            '" . $clean['mdp']     . "',
                            '" . $clean['nom']     . "',
                            '" . $clean['email']   . "',
                            '" . $clean['sexe']    . "',
                            '" . $clean['ville']   . "',
                            '" . $clean['cp']      . "',
                            '" . $clean['adresse'] . "',
                            '0');";

            $result = $this->db->query($sql);

            if (!$result) {
                Session::set('events.error.db_error', $this->db->error);
                return 'db_error';
            }

            // Tout s'est bien passé, on n'a plus besoin du sticky form
            Session::delete('post_data.register');

            return true;

        endif;

        return 'Ceci ne devrait pas arriver !';
    }
}
