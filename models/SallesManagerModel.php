<?php

/* Gestion des salles par l'administrateur
 */

class SallesManagerModel extends ItemManagerModel
{
    // NOTE: attention, le paramètre est passé par référence
    protected function test_post_data( &$post_data )
    {
        // les nombres sont passés en chaînes de caractère, on convertit donc pour se simplifier le travail
        if ( !empty($post_data['capacite']) ) { $post_data['capacite'] = intval($post_data['capacite']); }
        if ( empty($post_data['photo']) ) { $post_data['photo'] = '/uploads/img/default_salle.jpg'; }

        // tous les tests préalables au traitement des données sont faits ici
        if ( empty($post_data['pays']) ):
            return 'pays_missing';

        elseif ( strlen($post_data['pays']) > 20 OR strlen($post_data['pays']) < 2 ):
            return 'pays_length';

        elseif ( empty($post_data['ville']) ):
            return 'ville_missing';

        elseif ( strlen($post_data['ville']) > 20 OR strlen($post_data['ville']) < 2 ):
            return 'ville_length';

        elseif ( empty($post_data['adresse']) ):
            return 'adresse_missing';

        elseif ( strlen($post_data['adresse']) > 20 OR strlen($post_data['adresse']) < 2 ):
            return 'adresse_length';

        elseif ( empty($post_data['cp']) ):
            return 'zipcode_missing';

        elseif ( strlen($post_data['cp']) > 5 OR strlen($post_data['cp']) < 2 ):
            return 'zipcode_length';

        elseif ( empty($post_data['titre']) ):
            return 'titre_missing';

        elseif ( strlen($post_data['titre']) > 200 OR strlen($post_data['titre']) < 2 ):
            return 'titre_length';

        elseif ( empty($post_data['description']) ):
            return 'description_missing';

        elseif ( strlen($post_data['description']) < 3 ):
            return 'description_length';

        elseif ( strlen($post_data['photo']) > 200 ):
            return 'photo_salle_url_length';

        elseif ( empty($post_data['capacite']) ):
            return 'capacite_missing';

        elseif ( !is_int($post_data['capacite']) ):
            return 'capacite_doesnt_fit';

        elseif ( strlen( (string) $post_data['capacite']) > 4 ):
            return 'capacite_length';

        elseif ( empty($post_data['categorie']) ):
            return 'categorie_missing';

        elseif ( !in_array($post_data['categorie'], ['réunion','conférence']) ):
            return 'categorie_doesnt_fit';

        else: // tout va bien
            return true;

        endif;
    }

    protected function get_sql_request( $action )
    {
        if ( empty($action) ) {
            return '';
        }

        // filtre des données potentiellement dangereuses
        foreach($_POST as $key => $value) {
            $clean[$key] = $this->db->real_escape_string( $value );
        }

        switch ( $action ) {

            // insertion (et donc création) de la salle dans la base de données
            case 'add_item':
                $sql = "INSERT INTO salles
                        VALUES ('',
                                '" . $clean['pays']            . "',
                                '" . $clean['ville']           . "',
                                '" . $clean['adresse']         . "',
                                '" . $clean['cp']              . "',
                                '" . $clean['titre']           . "',
                                '" . $clean['description']     . "',
                                '" . $clean['photo'] . "',
                                '" . $clean['capacite']        . "',
                                '" . $clean['categorie']       . "');";
            break;

            // modification de la salle dans la base de données
            case 'modify_item':
                $sql = "UPDATE salles
                        SET pays='"        . $clean['pays']            . "',
                            ville='"       . $clean['ville']           . "',
                            adresse='"     . $clean['adresse']         . "',
                            cp='"          . $clean['cp']              . "',
                            titre='"       . $clean['titre']           . "',
                            description='" . $clean['description']     . "',
                            photo='"       . $clean['photo'] . "',
                            capacite='"    . $clean['capacite']        . "',
                            categorie='"   . $clean['categorie']       . "'
                        WHERE id='"        . $clean['id']              . "';";
            break;

            default: $sql = '';
        }

        return $sql;
    }
}
