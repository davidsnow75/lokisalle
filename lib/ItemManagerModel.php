<?php

/*
 * Une instance d'ItemManagerModel permet d'effectuer le travail générique
 * à tout gestionnaire d'éléments en base de données
 */

abstract class ItemManagerModel extends Model
{
    /**
     * vérification avant traitement de la validité des données envoyées par POST
     *
     * Les données variant avec les Managers, cette fonction doit être
     * implémentée spécifiquement pour chacun d'entre eux.
     * NOTE: il peut advenir que le type des données testées soit modifié par cette
     * méthode, d'où l'importance de passer l'argument par référence.
     *
     * @param array la superglobale $_POST, passée par référence
     * @return true en cas de données valides, string en cas d'échec (le msg d'erreur)
     */
    abstract protected function test_post_data( &$post_data );

    /**
     * construction d'une requête SQL adaptée à l'instance particulière de ItemManagerModel
     *
     * @param string le type de requête à construire
     * @return string la requête SQL en cas de succès, une chaîne vide en cas d'erreur
     */
    abstract protected function get_sql_request( $action );

    /**
     * récupère en BDD les données des éléments demandés
     *
     * @param string la table où aller chercher les éléments
     * @param array un tableau (facultatif) des ids d'éléments de la table
     * @param string une chaîne (facultative) listant les champs à récupérer dans la table
     * @return array un tableau des éléments en BDD
     */
    public function get_items( $table, $id_items = [], $fields = '*' )
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
            $sql = "SELECT " . $fields . " FROM " . $table . " WHERE id='";
            $i = -1;
            while ( ++$i < $last_item_key ) {
                $sql .= intval( $id_items[$i] ) . "' OR id='";
            }
            $sql .= intval( $id_items[$i] ) . "';";

        } else { // pas d'id spécifiquement demandé, donc on récupère tous les items

            $sql = "SELECT " . $fields . " FROM " . $table . ";";
        }

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
            if ( $key !== 'mdp' && $key !== 'mdp_bis' ) {
                $html_clean[$key] = htmlentities($value, ENT_QUOTES, "utf-8");
            }
        }
        Session::set('post_data.add_item_' . $table, $html_clean);

        // test de la validité des données envoyées
        $post_data_ok = $this->test_post_data($_POST);
        if ( $post_data_ok !== true ) {
            return $post_data_ok;
        }

        // tout est bon, mais y a-t-il eu une photo postée ?
        // TODO: implémenter un upload d'images sécurisé

        // Les données sont validées, on n'a plus besoin du sticky form
        Session::delete('post_data.add_item_' . $table);

        // insertion (et donc création) de l'item dans la base de données
        $sql = $this->get_sql_request( 'add_item' );
        $result = $this->exequery($sql);


        return 'valid_add_item';
    }

    /**
     * modifie un item en BDD
     *
     * @return string une chaîne résumant le résultat de l'opération, false en cas d'erreur fatale
     */
    public function modify_item( $test_post_data = true )
    {
        // S'il manque qqchose, on s'arrête
        if ( empty($_POST) ) {
            return false;
        }

        if ( $test_post_data ) {
            // test de la validité des données envoyées
            $post_data_ok = $this->test_post_data($_POST);
            if ( $post_data_ok !== true ) {
                return $post_data_ok;
            }
        }

        // tout est bon, mais y a-t-il eu une photo postée ?
        // TODO: implémenter un upload d'images sécurisé

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
