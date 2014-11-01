<?php

class AvisCollector extends ItemCollector
{
    private $fields = 'avis.id          AS avisId,
                       avis.commentaire AS avisCommentaire,
                       avis.note        AS avisNote,
                       avis.date        AS avisDate,
                       salles.id        AS salleId,
                       salles.titre     AS salleTitre,
                       membres.id       AS membreId,
                       membres.pseudo   AS membrePseudo';

    public function getThreeLastAvis( $salle_id )
    {
        $salle_id = (int) $salle_id;

        $sql = "SELECT $this->fields
                FROM avis
                LEFT JOIN salles ON salles.id = avis.salles_id
                LEFT JOIN membres ON membres.id = avis.membres_id
                WHERE avis.salles_id = $salle_id
                ORDER BY avis.date ASC
                LIMIT 0,3;";

        return $this->getItemsCustomSQL( $sql );
    }

    public function getAvis( $ids = [] )
    {
        /* construction d'une clause WHERE si besoin est */
        if ( !empty($ids) ) {
            $ids = is_array($ids) ? $ids : [$ids];

            $where = " WHERE avis.id=";

            $last_item_key = count($ids) - 1;
            $i = -1;
            while ( ++$i < $last_item_key ) {
                $where .= intval( $ids[$i] ) . " OR avis.id=";
            }
            $where .= intval( $ids[$i] );
        } else {
            $where = '';
        }

        /* la requête proprement dite */
        $sql = "SELECT $this->fields
                FROM avis
                LEFT JOIN salles ON salles.id = avis.salles_id
                LEFT JOIN membres ON membres.id = avis.membres_id
                $where;";

        return $this->getItemsCustomSQL( $sql );
    }
}
