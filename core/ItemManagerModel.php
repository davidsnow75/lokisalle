<?php

/*
 * Une instance d'ItemManagerModel permet d'effectuer le travail générique
 * à tout gestionnaire d'éléments en base de données
 */

abstract class ItemManagerModel extends Model
{
    abstract protected function test_post_data( &$post_data );
    abstract protected function get_sql_request( $action );

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
            $result = $this->exequery($sql);

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

        $result = $this->exequery($sql);

        if ( $result->num_rows === 0 ) {
            return []; // pas d'élément trouvé
        }

        while ($item = $result->fetch_assoc() ) {
            $items[] = $item;
        }

        return $items;
    }

    /**
     * ajoute un item en BDD
     *
     * @param string la table où aller insérer l'élément
     * @return string une chaîne résumant le résultat de l'opération, false en cas d'erreur fatale
     */
    public function add_item( $table )
    {
        // S'il manque qqchose, on s'arrête
        if ( empty($_POST) || empty($table) || !is_string( $table ) ) {
            return false;
        }

        // on enregistre les données avant les tests pour s'assurer
        // qu'elles ne seront pas perdues en cas de tests invalides
        foreach($_POST as $key => $value) {
            $html_clean[$key] = htmlentities($value, ENT_QUOTES, "utf-8");
        }
        Session::set('post_data.add_item_' . $table, $html_clean);

        // test de la validité des données envoyées
        $post_data_ok = $this->test_post_data($_POST);
        if ( $post_data_ok !== true ) {
            return $post_data_ok;
        }

        // tout est bon, mais y a-t-il eu une photo postée ?
        // TODO: implémenter un upload d'images sécurisé

        // insertion (et donc création) de l'item dans la base de données
        $sql = $this->get_sql_request( 'add_item' );
        $result = $this->exequery($sql);

        // Tout s'est bien passé, on n'a plus besoin du sticky form
        Session::delete('post_data.add_item_' . $table);

        return 'valid_add_item';
    }

    /**
     * modifie un item en BDD
     *
     * @return string une chaîne résumant le résultat de l'opération, false en cas d'erreur fatale
     */
    public function modify_item()
    {
        // S'il manque qqchose, on s'arrête
        if ( empty($_POST) ) {
            return false;
        }

        // test de la validité des données envoyées
        $post_data_ok = $this->test_post_data($_POST);
        if ( $post_data_ok !== true ) {
            return $post_data_ok;
        }

        // tout est bon, mais y a-t-il eu une photo postée ?
        // TODO: implémenter un upload d'images sécurisé

        // insertion (et donc création) de l'item dans la base de données
        $sql = $this->get_sql_request( 'modify_item' );
        $result = $this->exequery($sql);

        return 'valid_modify_item';
    }

    /**
     * supprime un item en BDD
     *
     * @param string la table où aller supprimer l'élément
     * @return string une chaîne résumant le résultat de l'opération, false en cas d'erreur fatale
     */
    public function delete_item( $table, $item_id )
    {
        if ( empty($item_id) ) {
            return false;
        }

        $result = $this->exequery(
            "DELETE FROM " . $this->db->real_escape_string($table) . "
             WHERE id='" . intval($item_id) . "';"
        );

        if ( $this->db->affected_rows === 0 ) {
            return 'unknown_item_id';
        }

        return 'valid_delete_item';
    }
}
