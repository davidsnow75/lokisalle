<?php

/*
 * Cette classe décrit une instance de produit.
 *
 * Les vérifications opérées par les mutateurs sont 'grammaticales', et non logiques.
 * En effet, c'est une classe Manager de produits qui, au cours de la création, de la
 * modification ou de la suppression d'un produit, va vérifier que, par exemple, une
 * salle n'est pas utilisée simultanément par deux produits distincts, etc...
 */

class Produit extends Model
{
    protected $id;
    protected $date_arrivee;
    protected $date_depart;
    protected $prix;
    protected $etat;
    protected $salle_id;
    protected $promo_id;


    /* ce constructeur permet ou bien d'instancier un produit déjà existant en BDD
     * (en lui fournissant son id), ou bien d'initialiser un produit vide, qu'il
     * faudra remplir manuellement.
     */
    public function __construct( $id = false )
    {
        if ( $id ) {
            $sql = "SELECT * FROM produits WHERE id='" . intval($id) . "';";

            $result = $this->exequery($sql);

            if ( $result->num_rows != 0 ) {

                $produit = $result->fetch_assoc();

                $this->id           = $produit[0]['id'];
                $this->date_arrivee = $produit[0]['date_arrivee'];
                $this->date_depart  = $produit[0]['date_depart'];
                $this->prix         = $produit[0]['prix'];
                $this->etat         = $produit[0]['etat'];
                $this->salle_id     = $produit[0]['salles_id'];
                $this->promo_id     = $produit[0]['promotions_id'];
            }
        }
    }


    /* ACCESSEURS ---------------------------------------*/
    public function getID()
    {
        return $this->id;
    }


    public function getDateArrivee()
    {
        return $this->date_arrivee;
    }

    public function getDateDepart()
    {
        return $this->date_depart;
    }

    public function getPrix()
    {
        return $this->prix;
    }

    public function getEtat()
    {
        return $this->etat;
    }

    public function getSalleID()
    {
        return $this->salle_id;
    }

    public function getPromoID()
    {
        return $this->promo_id;
    }

    /* MUTATEURS ----------------------------------------*/

    public function setDates( $date_arrivee, $date_depart )
    {
        if ( empty($date_arrivee) || empty($date_depart) ) {
            return 'invalid_date';
        }

        try {
            $date_arrivee = new DateTime( $date_arrivee );
        } catch (Exception $e) {
            return 'invalid_date_arrivee';
        }

        try {
            $date_depart = new DateTime( $date_depart );
        } catch (Exception $e) {
            return 'invalid_date_depart';
        }

        $this->date_arrivee = $date_arrivee->format('U');
        $this->date_depart  = $date_depart->format('U');
    }

    public function setPrix( $prix )
    {
        if ( !empty($prix) && is_int($prix) && strlen( (string) $prix ) < 6 ) {
            $this->prix = $prix;
            return;
        }

        return 'invalid_prix';
    }

    public function setEtat( $etat )
    {
        if ( empty($etat) ) {
            return 'invalid_etat';
        }

        if ( $etat == false ) {
            $this->etat = 0;
        } else {
            $this->etat = 1;
        }
    }

    public function setSalleID( $salle_id )
    {
        if ( empty($salle_id) || !$salle_id || !is_int($salle_id) ) {
            return 'invalid_salle_id';
        }

        $this->salle_id = $salle_id;
    }

    public function setPromoID( $promo_id )
    {
        if ( empty($promo_id) || !$promo_id || !is_int($promo_id) ) {
            return 'invalid_promo_id';
        }

        $this->promo_id = $promo_id;
    }
}
