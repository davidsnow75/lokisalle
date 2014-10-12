<?php

trait ItemCollector
{
    public static function getItems( $db, $table, $id_items = [], $fields = '*' )
    {
        // Si la table est absente ou incorrecte, alors on s'arrête là
        if ( empty($table) || !is_string( $table ) ) {
            return [];
        }

        // avant de continuer, on sécurise l'argument passé
        $table = $db->real_escape_string( $table );

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

        $result = $db->query($sql);

        if ( $result->num_rows === 0 ) {
            return []; // pas d'élément trouvé
        }

        while ($item = $result->fetch_assoc() ) {
            $items[] = $item;
        }

        return $items;
    }
}
