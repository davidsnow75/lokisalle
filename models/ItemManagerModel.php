<?php

/*
 * Une instance d'ItemManagerModel permet d'effectuer le travail générique
 * à tout gestionnaire d'éléments en base de données
 */

class ItemManager extends Model
{
    /**
     * récupère en BDD les données des éléments demandés
     *
     * @param string la table où aller chercher les éléments
     * @param array un tableau (facultatif) des ids d'éléments de la table
     * @return array un tableau des éléments en BDD
     */
    public function get_items( $table, $id_items = [] )
    {
        // Si la table est absente ou incorrecte, alors on s'arrête là
        if ( empty($table) || !is_string( $table ) ) {
            return [];
        }

        // avant de continuer, on sécurise l'argument passé
        $table = $this->db->real_escape_string( $table );

        // Y a-t-il eu des items spécifiquement demandés ?
        if ( is_array($id_items) && $id_items !== [] ) {

            $last_item_key = count($id_items) - 1;

            // construction de la requête
            $sql = "SELECT * FROM " . $table . " WHERE id='";
            $i = -1;
            while ( ++$i < $last_item_key ) {
                $sql .= intval( $id_items[$i] ) . "' OR id='";
            }
            $sql .= intval( $id_items[$i] ) . "';";

            // exécution de la requête
            $result = $this->db->query($sql);

            if ( !$result ) { // la requête a renvoyé une erreur
                Session::set('events.error.db_error', $this->db->error);
                return 'db_error';
            }

            if ( $result->num_rows === 0 ) {
                return []; // pas d'élément trouvé
            }

            while ($item = $result->fetch_assoc() ) {
                $items[] = $item;
            }

            return $items;
        }

        // pas d'id spécifiquement demandé, donc on récupère tous les items
        $sql = "SELECT * FROM " . $table . ";";

        $result = $this->db->query($sql);

        if ( !$result ) { // la requête a renvoyé une erreur
            Session::set('events.error.db_error', $this->db->error);
            return 'db_error';
        }

        if ( $result->num_rows === 0 ) {
            return []; // pas d'élément trouvé
        }

        while ($item = $result->fetch_assoc() ) {
            $items[] = $item;
        }

        return $items;
    }
}
