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

        elseif ( empty($_POST[''])):

        endif;
    }
}
