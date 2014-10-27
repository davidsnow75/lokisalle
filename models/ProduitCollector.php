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

    public function getValidSingleProduit( $id, $join = '' )
    {
        $id = (int) $id;

        if ( $join === 'withPromo' ) {
            $sql = "SELECT $this->fields, $this->fieldsWidthPromo
                    FROM produits
                    LEFT JOIN salles ON salles.id = produits.salles_id
                    LEFT JOIN promotions ON promotions.id = produits.promotions_id
                    WHERE produits.id = $id
                      AND FROM_UNIXTIME( produits.date_arrivee ) > CURDATE()
                      AND produits.etat = 0;";
        } else {
            $sql = "SELECT $this->fields
                    FROM produits
                    LEFT JOIN salles ON salles.id = produits.salles_id
                    WHERE produits.id = $id
                      AND FROM_UNIXTIME( produits.date_arrivee ) > CURDATE()
                      AND produits.etat = 0;";
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

    public function getProduitsFromRecherche( $array )
    {
        $mois     = empty($array['mois']) ? 0 : intval($array['mois']);
        $annee    = empty($array['annee']) ? 0 : intval($array['annee']);
        $keywords = empty($array['keywords']) ? [] : explode('|', $array['keywords']);

        /* on ne garde que les 4 premières valeurs de $keywords, que l'on échappe */
        foreach ($keywords as $key => $keyword) {
            if ( $key < 4 ) {
                $keywords[$key] = $this->db->real_escape_string($keyword);
            } else {
                unset($keywords[$key]);
            }
        }

        /* tout est propre et bien ordonné, on peut commencer à travailler */

        /* la base de travail */
        $sql = "SELECT $this->fields
                FROM produits
                LEFT JOIN salles ON salles.id = produits.salles_id
                WHERE FROM_UNIXTIME( produits.date_arrivee ) > CURDATE()
                    AND produits.etat = 0";

        $recherche = [
            'mois' => '',
            'annee' => '',
            'keywords' => []
        ];

        if ( $mois ) {
            $sql .= " AND DATE_FORMAT( FROM_UNIXTIME(produits.date_arrivee), '%c' ) = $mois";
            $recherche['mois'] = strftime('%B', mktime(null, null, null, $mois));
        }

        if ( $annee ) {
            $sql .= " AND DATE_FORMAT( FROM_UNIXTIME(produits.date_arrivee), '%Y' ) = $annee";
            $recherche['annee'] = $annee;
        }

        if ( $keywords ) {
            foreach ( $keywords as $key => $keyword ) {
                $sql .= " AND salles.description LIKE '%$keyword%'";
                $recherche['keywords'][] = $keyword;
            }
        }

        /* on a fini de rajouter des critères, on clôt la requête */
        $sql .= ";";

        return [
            'produits' => $this->getItemsCustomSQL( $sql ),
            'recherche' => $recherche
        ];
    }
}
