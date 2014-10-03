<?php

/**
 * Gestion des membres
 *
 * Cette classe n'a pas vocation a être seulement utilisée par un AdminController,
 * par exemple, on s'en servira pour ajouter un nouvel utilisateur (de son propre
 * fait donc).
 *
 */

class MembresManagerModel extends ItemManagerModel
{
    protected function test_post_data( &$post_data )
    {
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
            // tout semble correct, mais on doit vérifier que le pseudo et l'e-mail sont disponibles
            $sql = "SELECT id FROM membres
                    WHERE pseudo='" . $this->db->real_escape_string($_POST['pseudo']) . "';";
            if ( $this->exequery($sql)->num_rows != 0) {
                return 'pseudo_unavailable';
            }

            $sql = "SELECT id FROM membres
                    WHERE email='" . $this->db->real_escape_string($_POST['email'])  . "';";
            if ( $this->exequery($sql)->num_rows != 0) {
                return 'email_unavailable';
            }

            // tout a été testé et tout va bien
            return true;

        endif;
    }

    protected function get_sql_request( $action )
    {
        if ( empty($action) ) {
            return '';
        }

        // on chiffre le mdp avant tout autre traitement pour ne pas l'altérer
        $_POST['mdp'] = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

        // filtre des données potentiellement dangereuses
        foreach($_POST as $key => $value) {
            $clean[$key] = $this->db->real_escape_string( $value );
        }

        switch ( $action ) {

            // insertion (et donc création) de la salle dans la base de données
            case 'add_item':
                $sql = "INSERT INTO membres
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
            break;

            // modification de la salle dans la base de données
            case 'modify_item':
                $sql = "UPDATE membres
                        SET statut='1'
                        WHERE id='" . $clean['id'] . "';";
            break;

            default: $sql = '';
        }

        return $sql;
    }

    public function user_is_godlike()
    {
        if ( Session::get('user.pseudo') === 'manitou' ) {
            return true;
        }

         return false;
    }
}
