<?php

class CommandeCollector extends ItemCollector
{
    protected $fields = 'commandes.id          AS commandeId,
                         commandes.montant     AS commandeMontant,
                         commandes.date        AS commandeDate,
                         membres.id            AS membreId,
                         membres.pseudo        AS membrePseudo';

    protected $join = 'LEFT JOIN membres ON membres.id = commandes.membres_id';

    public function getCommandes( $id = false )
    {
        $id = (int) $id;

        $sql = "SELECT $this->fields
                FROM commandes
                $this->join";

        if ( $id ) {
            $sql .= " WHERE commandes.id = $id;";
        } else {
            $sql .= ";";
        }

        return $this->getItemsCustomSQL( $sql );
    }

    public function getRelatedProduits( $id )
    {
        $id = (int) $id;

        $sql = "SELECT produits.id           AS produitId,
                       produits.date_arrivee AS produitArrivee,
                       produits.date_depart  AS produitDepart,
                       produits.prix         AS produitPrix,
                       produits.etat         AS produitEtat,
                       salles.id             AS salleId,
                       salles.pays           AS sallePays,
                       salles.ville          AS salleVille,
                       salles.adresse        AS salleAdresse,
                       salles.cp             AS salleCp,
                       salles.titre          AS salleTitre,
                       salles.description    AS salleDescription,
                       salles.photo          AS sallePhoto,
                       salles.capacite       AS salleCapacite,
                       salles.categorie      AS salleCategorie
                FROM details_commandes
                LEFT JOIN produits ON produits.id = details_commandes.produits_id
                LEFT JOIN salles   ON salles.id = produits.salles_id
                WHERE details_commandes.commandes_id = $id;";

        return $this->getItemsCustomSQL( $sql );
    }

    public function getCommandesFromUser( $id )
    {
        $id = (int) $id;

        $sql = "SELECT details_commandes.produits_id
                FROM details_commandes
                LEFT JOIN commandes ON commandes.id = details_commandes.commandes_id
                WHERE commandes.membres_id = $id;";

        return $this->getItemsCustomSQL( $sql );
    }
}
