<?php

/* Gestion des salles par l'administrateur
 */

class GestionsallesModel extends Model
{
    public function afficher($id_salles = [])
    {
        // demande-t-on un affichage spécifique ?
        if ( !($id_salles === []) ) {

        } else { // non, donc on liste toutes les salles
            $sql = "SELECT * FROM salles;";
            $result = $this->db->query($sql);

            if ( $result->num_rows === 0 ) {
                return [];

            } else {
                while ($salle = $result->fetch_assoc() ) {
                    $salles[] = $salle;
                }

                return $salles;
            }
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

        // tous les tests préalables au traitement des données sont faits ici
        if ( empty($_POST['pays']) ):
            return 'pays_missing';

        elseif ( strlen($_POST['pays']) > 20 OR strlen($_POST['pays']) < 2 ):
            return 'pays_length';

        elseif ( empty($_POST['ville']) ):
            return 'ville_missing';

        elseif ( strlen($_POST['ville']) > 20 OR strlen($_POST['ville']) < 2 ):
            return 'ville_length';

        elseif ( empty($_POST['adresse']) ):
            return 'adresse_missing';

        elseif ( strlen($_POST['adresse']) > 20 OR strlen($_POST['adresse']) < 2 ):
            return 'adresse_length';

        elseif ( empty($_POST['cp']) ):
            return 'zipcode_missing';

        elseif ( strlen($_POST['cp']) > 5 OR strlen($_POST['cp']) < 2 ):
            return 'zipcode_length';

        elseif ( empty($_POST['titre']) ):
            return 'titre_missing';

        elseif ( strlen($_POST['titre']) > 200 OR strlen($_POST['titre']) < 2 ):
            return 'titre_length';

        elseif ( empty($_POST['description']) ):
            return 'description_missing';

        elseif ( strlen($_POST['description']) < 3 ):
            return 'description_length';

        elseif ( empty($_POST['capacite']) ):
            return 'capacite_missing';

        elseif ( !is_int($_POST['capacite']) ):
            return 'capacite_doesnt_fit';

        elseif ( strlen($_POST['capacite']) < 4 ):
            return 'capacite_length';

        elseif ( empty($_POST['categorie']) ):
            return 'categorie_missing';

        elseif ( !in_array($_POST['categorie'], ['réunion','conférence']) ):
            return 'categorie_doesnt_fit';

        else:

            // tout est bon, mais y a-t-il eu une photo postée ?
            // TODO: implémenter un upload d'images sécurisé

            // préparation (échappement des caractères spéciaux) à l'utilisation dans mysql
            foreach($_POST as $key => $value) {
                $clean[$key] = $this->db->real_escape_string($value);
            }

            // insertion (et donc création) de la salle dans la base de données
            $sql = "INSERT INTO salles (id_salle,
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
                            '" . $clean['photo'] . "',
                            '" . $clean['capacite'] . "',
                            '" . $clean['categorie'] . "');";

            $result = $this->db->query($sql);

            if (!$result) {
                Session::set('events.error.db_error', $this->db->error);
                return 'db_error';
            }

            // Tout s'est bien passé, on n'a plus besoin du sticky form
            Session::delete('post_data.ajoutersalles');

            return 'ajout_valid';

        endif;

        // ne devrait pas arriver, mais par défaut...
        return false;
    }
}
