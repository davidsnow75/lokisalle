<?php

/* Manager de Produit
 *
 * À instancier dans un bloc try
 *
 * try {
 *     $produitmanager = new ProduitManager( $produit );
 * } catch (Exception $e) {
 *     echo $e->getMessage();
 * }
 *
 */

class ProduitManager extends Model
{
    /**
     * destiné à recevoir une instance de Produit
     */
    protected $produit;

    /**
     * Constructeur de ProduitManager
     *
     * @param object une instance de Produit
     * @throws Exception l'argument fourni n'est pas une instance de Produit
     * @return void
     */
    public function __construct( $produit )
    {
        if ( empty($produit) || !($produit instanceof Produit) ) {
            throw new Exception('Le produit manipulé est invalide.');
        } else {
            $this->produit = $produit;
        }
    }

    /**
     * Ajoute un produit dans la table produits de la BDD
     *
     * @return string un message d'erreur en cas d'insertion impossible
     */
    public function addProduit()
    {
        try {
            $this->checkProduit();
        } catch (Exception $e) {
            return $e->getMessage();
        }

        // le produit est valide, on continue
        $sql = "INSERT INTO produits
                VALUES ('',
                        '" . $this->produit->getDateArrivee() . ",
                        '" . $this->produit->getDateDepart()  . ",
                        '" . $this->produit->getPrix()        . ",
                        '" . $this->produit->getEtat()        . ",
                        '" . $this->produit->getSalleID()     . ",
                        '" . $this->produit->getPromoID()     . "');";

        $result = $this->exequery($sql);
    }

    /**
     * Vérifie la validité du produit
     *
     * @throws Exception si le produit ne satisfait pas toutes les conditions
     * @return void
     */
    public function checkProduit()
    {
        /* première condition: les dates doivent être cohérentes */
        if ( date( 'Ymd', $this->produit->getDateArrivee() ) <= date( 'Ymd', time() ) ) {
            throw new Exception('La date d\'arrivée doit être postérieure à la date du jour.');
        }

        if ( $this->produit->getDateArrivee() > $this->produit->getDateDepart() ) {
            throw new Exception('La date d\'arrivée doit être antérieure ou égale à la date de départ.');
        }

        /* deuxième condition: une salle ne peut pas être utilisée par plus d'un produit à la fois */
        $sql = "SELECT id, date_arrivee, date_depart FROM produits WHERE salles_id='" . $this->produit->getSalleID() . "';";
        $result = $this->exequery($sql);

        if ( $result->num_rows != 0 ) {

            while ( $doublon_produit = $result->fetch_assoc() ) {
                if (
                    $doublon_produit['date_arrivee'] < $this->produit->getDateArrivee()
                    && $this->produit->getDateArrivee() < $doublon_produit['date_depart']
                ) {
                    $vrai_doublon_produit[] = $doublon_produit['id'];
                }
            }
        }

        if ( !empty($vrai_doublon_produit) ) {
            throw new Exception('Le produit manipulé est en conflit avec les produits aux références suivantes : ' . implode(', ', $vrai_doublon_produit) . '.');
        }
    }
}
