<?php

/* Gestion des salles par l'administrateur
 */

class GestionsallesModel extends Model
{
    public function get_salles($id_salles = [])
    {
        // demande-t-on un affichage spécifique ?
        if ( is_array($id_salles) && $id_salles !== [] ) {

            // quel est la clé dans $id_salle du dernier id demandé ?
            $last_id_salle_key = (count($id_salles) - 1);

            // la requête commence quoi qu'il en soit comme suit:
            $sql = "SELECT * FROM salles WHERE id='";

            // et se termine comme suit:
            $i = 0;
            while( $i < $last_id_salle_key ) {
                $sql .= intval($id_salles[$i]) . "' OR id_salle='";
                $i++;
            }
            $sql .= intval($id_salles[$i]) . "';"; // on a atteint la dernière clé du tableau


            $result = $this->exequery($sql);

            if ( $result->num_rows === 0 ) {
                return [];

            } else {
                while ($salle = $result->fetch_assoc() ) {
                    $salles[] = $salle;
                }

                return $salles;
            }

        } else {

            $sql = "SELECT * FROM salles;";
            $result = $this->exequery($sql);

            if ( $result->num_rows === 0 ) {
                return [];

            }

            while ($salle = $result->fetch_assoc() ) {
                $salles[] = $salle;
            }

            return $salles;
        }
    }

    public function ajouter()
    {
        // sans $_POST, inutile de continuer
        if ( empty($_POST) ) { return false; }

        // pour obtenir un 'sticky form'
        foreach($_POST as $key => $value) {
            $html_clean[$key] = htmlentities($value, ENT_QUOTES, "utf-8");
        }

        // on enregistre les données avant les tests pour s'assurer qu'elles ne seront pas perdues
        Session::set('post_data.ajoutersalles', $html_clean);

        // test de la validité des données envoyées
        $postdata_validity = $this->test_postdata($_POST);

        // si le test a renvoyé une chaîne de caractère par exemple, alors on s'arrête là
        if ( $postdata_validity !== true ) {
            return $postdata_validity;

        } else {
            // tout est bon, mais y a-t-il eu une photo postée ?
            // TODO: implémenter un upload d'images sécurisé

            // préparation (échappement des caractères spéciaux) à l'utilisation dans mysql
            foreach($_POST as $key => $value) {
                $clean[$key] = $this->db->real_escape_string($value);
            }

            // insertion (et donc création) de la salle dans la base de données
            $sql = "INSERT INTO salles (id,
                                        pays,
                                        ville,
                                        adresse,
                                        cp,
                                        titre,
                                        description,
                                        photo,
                                        capacite,
                                        categorie)
                    VALUES ('',
                            '" . $clean['pays']  . "',
                            '" . $clean['ville']     . "',
                            '" . $clean['adresse']     . "',
                            '" . $clean['cp']   . "',
                            '" . $clean['titre']    . "',
                            '" . $clean['description']   . "',
                            '" . '/uploads/img/default_salle.jpg' . "',
                            '" . $clean['capacite'] . "',
                            '" . $clean['categorie'] . "');";

            $result = $this->exequery($sql);

            // Tout s'est bien passé, on n'a plus besoin du sticky form
            Session::delete('post_data.ajoutersalles');

            return 'ajout_valid';
        }

        // ne devrait pas arriver, mais par défaut...
        return false;
    }

    public function modifier($id_salle)
    {
        // on vérifie qu'on a de quoi travailler...
        if ( empty($id_salle) || empty($_POST) ) {
            return false;
        }

        // test de la validité des données envoyées
        $postdata_validity = $this->test_postdata($_POST);

        // si le test a renvoyé une chaîne de caractère par exemple, alors on s'arrête là
        if ( $postdata_validity !== true ) {
            return $postdata_validity;

        } else {
            // tout est bon, mais y a-t-il eu une photo postée ?
            // TODO: implémenter un upload d'images sécurisé

            // préparation (échappement des caractères spéciaux) à l'utilisation dans mysql
            foreach($_POST as $key => $value) {
                $clean[$key] = $this->db->real_escape_string($value);
            }

            // insertion (et donc création) de la salle dans la base de données
            $sql = "UPDATE salles
                    SET pays='" . $clean['pays'] . "',
                        ville='" . $clean['ville'] . "',
                        adresse='" . $clean['adresse'] . "',
                        cp='" . $clean['cp'] . "',
                        titre='" . $clean['titre'] . "',
                        description='" . $clean['description'] . "',
                        photo='" . '/uploads/img/default_salle.jpg' . "',
                        capacite='" . $clean['capacite'] . "',
                        categorie='" . $clean['categorie'] . "'
                    WHERE id='" . $clean['id'] . "';";

            echo $sql;

            $result = $this->exequery($sql);

            return 'modif_valid';
        }

        // ne devrait pas arriver, mais par défaut...
        return false;
    }

    // TODO: suppression multiple ?
    public function supprimer($id_salle)
    {
        if ( empty($id_salle) ) {
            return;
        }

        $result = $this->exequery( "DELETE FROM salles WHERE id='" . intval($id_salle) . "';" );

        if ( $this->db->affected_rows === 0 ) {
            return 'unknown_id_salle';
        }

        return 'delete_valid';
    }


    // NOTE: attention, le paramètre est passé par référence
    protected function test_postdata(&$post)
    {
        // les nombres sont passés en chaînes de caractère, on convertit donc pour se simplifier le travail
        if ( !empty($post['capacite']) ) { $post['capacite'] = intval($post['capacite']); }

        // tous les tests préalables au traitement des données sont faits ici
        if ( empty($post['pays']) ):
            return 'pays_missing';

        elseif ( strlen($post['pays']) > 20 OR strlen($post['pays']) < 2 ):
            return 'pays_length';

        elseif ( empty($post['ville']) ):
            return 'ville_missing';

        elseif ( strlen($post['ville']) > 20 OR strlen($post['ville']) < 2 ):
            return 'ville_length';

        elseif ( empty($post['adresse']) ):
            return 'adresse_missing';

        elseif ( strlen($post['adresse']) > 20 OR strlen($post['adresse']) < 2 ):
            return 'adresse_length';

        elseif ( empty($post['cp']) ):
            return 'zipcode_missing';

        elseif ( strlen($post['cp']) > 5 OR strlen($post['cp']) < 2 ):
            return 'zipcode_length';

        elseif ( empty($post['titre']) ):
            return 'titre_missing';

        elseif ( strlen($post['titre']) > 200 OR strlen($post['titre']) < 2 ):
            return 'titre_length';

        elseif ( empty($post['description']) ):
            return 'description_missing';

        elseif ( strlen($post['description']) < 3 ):
            return 'description_length';

        elseif ( empty($post['capacite']) ):
            return 'capacite_missing';

        elseif ( !is_int($post['capacite']) ):
            return 'capacite_doesnt_fit';

        elseif ( strlen( (string) $post['capacite']) > 4 ):
            return 'capacite_length';

        elseif ( empty($post['categorie']) ):
            return 'categorie_missing';

        elseif ( !in_array($post['categorie'], ['réunion','conférence']) ):
            return 'categorie_doesnt_fit';

        else: // tout va bien
            return true;

        endif;
    }
}
