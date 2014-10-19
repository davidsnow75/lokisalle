<?php

abstract class ItemCollector extends Model
{
    protected function returnItems( $sql )
    {
        $result = $this->exequery($sql);

        if ( $result->num_rows === 0 ) {
            return [];
        }

        while ($item = $result->fetch_assoc() ) {
            $items[] = $item;
        }

        return $items;
    }

    public function getItems( $table, $ids = [], $fields = '*' )
    {
        // avant de continuer, on sécurise les arguments passés
        $table = $this->db->real_escape_string( $table );
        $fields = $this->db->real_escape_string( $fields );

        // Y a-t-il eu des items spécifiquement demandés ?
        if ( !empty($ids) ) {

            if ( !is_array($ids) ) {
                $ids = [$ids];
            }

            $last_item_key = count($ids) - 1;

            // construction de la requête
            $sql = "SELECT " . $fields . " FROM " . $table . " WHERE id='";
            $i = -1;
            while ( ++$i < $last_item_key ) {
                $sql .= intval( $ids[$i] ) . "' OR id='";
            }
            $sql .= intval( $ids[$i] ) . "';";

        } else { // pas d'id spécifiquement demandé, donc on récupère tous les items

            $sql = "SELECT " . $fields . " FROM " . $table . ";";
        }

        return $this->returnItems( $sql );
    }

    public function getItemsCustomSQL( $sql )
    {
        return $this->returnItems( $sql );
    }
}
