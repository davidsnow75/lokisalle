<?php

class ProduitCollector extends ItemCollector
{
    private $fields = 'produits.id           AS produitID,
                       produits.date_arrivee AS produitDebut,
                       produits.date_depart  AS produitFin,
                       produits.prix         AS produitPrix,
                       produits.etat         AS produitEtat,
                       salles.id             AS salleID,
                       salles.pays           AS sallePays,
                       salles.ville          AS salleVille,
                       salles.adresse        AS salleAdresse,
                       salles.cp             AS salleCP,
                       salles.titre          AS salleTitre  ,
                       salles.description    AS salleDescription,
                       salles.photo          AS sallePhoto,
                       salles.capacite       AS salleCapacite,
                       salles.categorie      AS salleCategorie';

      private $fieldsWidthPromo = 'promotions.id         AS promoId,
                                   promotions.code_promo AS promoCode,
                                   promotions.reduction  AS promoReduction';

    public function getProduits( $ids = [], $fields = '' )
    {
        /* construction d'une clause WHERE si besoin est */
        if ( !empty($ids) ) {
            $ids = is_array($ids) ? $ids : [$ids];

            $where = " WHERE produits.id=";

            $last_item_key = count($ids) - 1;
            $i = -1;
            while ( ++$i < $last_item_key ) {
                $where .= intval( $ids[$i] ) . " OR produits.id=";
            }
            $where .= intval( $ids[$i] );
        } else {
            $where = '';
        }

        /* la requête proprement dite */
        if ( $fields ) {
            $sql = "SELECT " . $this->db->real_escape_string($fields) . " FROM produits $where;";

        } else {
            $sql = "SELECT $this->fields, $this->fieldsWidthPromo
                    FROM produits
                    LEFT JOIN salles ON salles.id = produits.salles_id
                    LEFT JOIN promotions ON promotions.id = produits.promotions_id
                    $where;";
        }

        return $this->getItemsCustomSQL( $sql );
    }

    public function getSingleProduit( $id, $join = '' )
    {
        if ( $join === 'withPromo' ) {
            $sql = "SELECT $this->fields, $this->fieldsWidthPromo
                    FROM produits
                    LEFT JOIN salles ON salles.id = produits.salles_id
                    LEFT JOIN promotions ON promotions.id = produits.promotions_id
                    WHERE produits.id = '" . intval( $id ) . "';";
        } else {
            $sql = "SELECT $this->fields
                    FROM produits
                    LEFT JOIN salles ON salles.id = produits.salles_id
                    WHERE produits.id = '" . intval( $id ) . "';";
        }

        return $this->getItemsCustomSQL( $sql );
    }

    public function getAllValidProduits()
    {
        $sql = "SELECT $this->fields
                FROM produits
                LEFT JOIN salles ON salles.id = produits.salles_id
                WHERE FROM_UNIXTIME( produits.date_arrivee ) > CURDATE()
                      AND produits.etat = 0
                ORDER BY produits.date_arrivee;";

        return $this->getItemsCustomSQL( $sql );
    }

    public function getThreeLastProduits()
    {
        $sql = "SELECT $this->fields
                FROM produits
                LEFT JOIN salles ON salles.id = produits.salles_id
                WHERE FROM_UNIXTIME( produits.date_arrivee ) > CURDATE()
                      AND produits.etat = 0
                ORDER BY produits.id DESC
                LIMIT 0,3;";

        return $this->getItemsCustomSQL( $sql );
    }

    public function getThreeSimilarProduits( $produit )
    {
        $id    = (int) $produit['produitID'];
        $ville = $this->db->real_escape_string( $produit['salleVille'] );
        $month = date( 'm', $produit['produitDebut'] );

        $sql = "SELECT $this->fields
                FROM produits
                LEFT JOIN salles ON salles.id = produits.salles_id
                WHERE produits.id != $id
                      AND produits.etat = 0
                      AND salles.ville = '$ville'
                      AND DATE_FORMAT( FROM_UNIXTIME(produits.date_arrivee), '%m' ) = $month
                LIMIT 0,3;";

        return $this->getItemsCustomSQL( $sql );
    }
}
