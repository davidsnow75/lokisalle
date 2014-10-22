<?php

class ProduitManager extends Model
{
    protected $produit;

    const INSERT_SUCCESS = 'Le produit a bien été enregistré.';
    const UPDATE_SUCCESS = 'Le produit a bien été modifié.';
    const DELETE_SUCCESS = 'Le produit a bien été supprimé.';
    const INSERT_FAILURE = 'Le produit n\'a pas pu être enregistré.';
    const UPDATE_FAILURE = 'Le produit n\'a pas pu être mis à jour.';
    const DELETE_FAILURE = 'Le produit n\'a pas pu être supprimé.';
    const INVALID_UPDATE_INPUT = 'Le produit n\'a pas pu être mis à jour à cause de données invalides.';
    const INVALID_DATE_ARRIVEE = 'La date d\'arrivée doit être postérieure à la date du jour.';
    const INVALID_DATE_DEPART = 'La date d\'arrivée doit être antérieure ou égale à la date de départ.';
    const SALLE_NOT_FOUND = 'La salle demandée pour le produit n\'existe pas.';
    const PROMO_NOT_FOUND = 'La promotion demandée pour le produit n\'existe pas.';
    /* problème pour checkProduitUnique() */

    public function __construct($db, Produit $produit)
    {
        parent::__construct($db);
        $this->produit = $produit;
    }

    /*=======================================================================*/
    /*                 Méthode principale de ProduitManager                  */
    /*=======================================================================*/
    protected function ProduitToDb( $action )
    {
        $this->checkProduit();

        switch ( $action ) {
            case 'insert':
                $sql = "INSERT INTO produits
                        VALUES ('',
                                '" . $this->produit->getDateArrivee() . "',
                                '" . $this->produit->getDateDepart()  . "',
                                '" . $this->produit->getPrix()        . "',
                                '" . $this->produit->getEtat()        . "',
                                '" . $this->produit->getSalleID()     . "',
                                '" . $this->produit->getPromoID()     . "');";
                break;

            case 'update':
                $sql = "UPDATE produits
                        SET date_arrivee='"  . $this->produit->getDateArrivee() . "',
                            date_depart='"   . $this->produit->getDateDepart()  . "',
                            prix='"          . $this->produit->getPrix()        . "',
                            etat='"          . $this->produit->getEtat()        . "',
                            salles_id='"     . $this->produit->getSalleID()     . "',
                            promotions_id='" . $this->produit->getPromoID()     . "'
                        WHERE id='" . $this->produit->getID() . "';";
                break;

            case 'delete':
                $sql = "DELETE FROM produits WHERE id = '" . $this->produit->getId() . "';";
                break;

            default: $sql = false;
        }

        return $sql ? $this->exequery($sql) : false;
    }

    /*=======================================================================*/
    /*                   Alias pour l'utilisation de ProduitToDb()           */
    /*=======================================================================*/
    public function insertProduit()
    {
        if ( !$this->ProduitToDb('insert') ) {
            throw new Exception(self::INSERT_FAILURE);
        } else {
            return self::INSERT_SUCCESS;
        }
    }

    public function updateProduit( $modifs )
    {
        $this->alterProduit( $modifs );

        if ( !$this->ProduitToDb('update') ) {
            throw new Exception(self::UPDATE_FAILURE);
        } else {
            return self::UPDATE_SUCCESS;
        }
    }

    public function deleteProduit()
    {
        if ( !$this->ProduitToDb('delete') ) {
            throw new Exception(self::DELETE_FAILURE);
        }
        // à en croire http://php.net/manual/fr/language.oop5.cloning.php
        // cela devrait suffir à supprimer l'objet (interne et externe)
        unset( $this->produit );

        return self::DELETE_SUCCESS;
    }

    /*=======================================================================*/
    /*                 Vérifications de la cohérence du produit              */
    /*=======================================================================*/

    /**
     * Vérifie que la date d'arrivée du produit est postérieure à la date du jour
     *
     * @throws Exception si le produit ne satisfait pas la condition
     * @return void
     */
    public function checkDateArrivee()
    {
        if ( date( 'Ymd', $this->produit->getDateArrivee() ) <= date( 'Ymd', time() ) ) {
            throw new Exception(self::INVALID_DATE_ARRIVEE);
        }
    }

    /**
     * Vérifie que la date d'arrivée du produit est antérieure à la date de départ
     *
     * @throws Exception si le produit ne satisfait pas cette condition
     * @return void
     */
    public function checkDateRetour()
    {
        if ( $this->produit->getDateArrivee() > $this->produit->getDateDepart() ) {
            throw new Exception(self::INVALID_DATE_DEPART);
        }
    }

    /**
     * Vérifie que la salle du produit existe réellement
     *
     * @throws Exception si le produit ne satisfait pas cette condition
     * @return void
     */
    public function checkSalle()
    {
        $sql = "SELECT id FROM salles WHERE id = " . $this->produit->getSalleID() . ";";
        if ( !$this->exequery($sql)->num_rows ) {
            throw new Exception(self::SALLE_NOT_FOUND);
        }
    }

    /**
     * Vérifie que l'id de la promo du produit, s'il existe, renvoie bien à une promo existante
     *
     * @throws Exception si le produit ne satisfait pas cette condition
     * @return void
     */
    public function checkPromo()
    {
        if ( $this->produit->getPromoID() ) {
            $sql = "SELECT id FROM salles WHERE id = " . $this->produit->getPromoID() . ";";
            if ( !$this->exequery($sql)->num_rows ) {
                throw new Exception(self::PROMO_NOT_FOUND);
            }
        }
    }

    /**
     * Vérifie que la salle du produit n'est pas utilisée sur le même créneau horaire par un autre produit
     * Vérifie également que la salle demandée existe réellement !
     *
     * @throws Exception si le produit ne satisfait pas cette condition
     * @return void
     */
    public function checkProduitUnique()
    {
        $sql = "SELECT id, date_arrivee, date_depart FROM produits WHERE salles_id=" . $this->produit->getSalleID() . ";";
        $result = $this->exequery($sql);

        /* s'il n'y a pas de résultat, alors pas de conflit possible */
        if ( !$result->num_rows ) {
            return;
        }

        $dap = date( 'Ymd', $this->produit->getDateArrivee() );
        $ddp = date( 'Ymd', $this->produit->getDateDepart() );

        while ( $doublon = $result->fetch_assoc() ) {

            /* les tests que l'on s'apprête à faire n'ont de sens que si les deux produits sont différents */
            if ( $doublon['id'] == $this->produit->getID() ) {
                continue;
            }

            $da = date( 'Ymd', $doublon['date_arrivee'] );
            $dd = date( 'Ymd', $doublon['date_depart'] );

            if (
                // si les dates d'arrivée, ou les dates de départ, sont identiques
                $da == $dap || $dd == $dap

                // ou si la date d'arrivée du produit est strictement postérieure à la date d'arrivée du doubon mais antérieure ou égale à la date de départ du doublon
                || ($da < $dap && $dd >= $dap)

                // et réciproquement
                || ($dap < $da && $ddp >= $da)
            ) {
               $vrai_doublons[] = $doublon['id'];
            }
        }

        if ( !empty($vrai_doublons) ) {
            throw new Exception('Le produit manipulé est en conflit avec les produits listés <a href="/gestionproduits/index/' . implode('/', $vrai_doublons) . '" target="_blank">sur cette page</a>.');
        }
    }

    /**
     * Teste la validité globale du produit
     *
     * @throws Exception si le produit ne satisfait pas toutes les conditions
     * @return void
     */
    public function checkProduit()
    {
        /* première condition: les dates doivent être cohérentes */
        $this->checkDateArrivee();
        $this->checkDateRetour();

        /* deuxième condition: la salle (et éventuellement la promo) doit exister */
        $this->checkSalle();
        $this->checkPromo();

        /* troisième condition: une salle ne peut pas être utilisée par plus d'un produit à la fois */
        $this->checkProduitUnique();
    }

    /*=======================================================================*/
    /*                   Modifications du produit                            */
    /*=======================================================================*/

    /**
     * Vérifie que les modifs sont valables
     *
     * On ne veut considérer les modifications que si elles sont cohérentes avec un Produit.
     * D'une part, les valeurs modifiées doivent être de types scalaires et d'autre part
     * seuls les champs suivants doivent être considérés :
     * 'DateArrivee', 'DateDepart', 'Prix', 'Etat', 'SalleID', 'PromoID'
     * (cad les suffixes des mutateurs de Produit).
     *
     * @param array le tableau des modifs souhaitées
     * @throws Exception si les modifs ne satisfont pas tous les critères
     * @return array le tableau des modifs valides en cas de succès
     */
    public function checkModifications( $modifs )
    {
        if ( !is_array($modifs) ) {
            throw new Exception(self::INVALID_UPDATE_INPUT);
        }

        $champs_valables = ['DateArrivee', 'DateDepart', 'Prix', 'Etat', 'SalleID', 'PromoID'];

        foreach ($modifs as $modif_cle => $modif) {
            if ( !in_array( $modif_cle, $champs_valables, true ) || !is_scalar( $modif ) ) {
                unset( $modifs[$modif_cle] );
            }
        }

        if ( empty($modifs) ) {
            throw new Exception(self::INVALID_UPDATE_INPUT);
        }

        return $modifs;
    }

    /**
     * Modifie le produit dont s'occupe l'instance de ProduitManager
     *
     * Cette méthode va appliquer les modifications demandées, si elles sont valides,
     * à l'objet Produit dont son instance de ProduitManager s'occupe.
     *
     * @param array le tableau des modifs souhaitées et valables
     * @return string un message d'erreur en cas de modification impossible, void sinon
     */
    public function alterProduit( $modifs )
    {
        $modifs = $this->checkModifications( $modifs );

        foreach ($modifs as $modif_key => $modif) {
            call_user_func( [$this->produit, 'set' . $modif_key], $modif );
        }
    }
}
