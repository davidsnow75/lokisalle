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
        if ( !($produit instanceof Produit) ) {
            throw new Exception('Le produit manipulé est invalide.');
        } else {
            $this->produit = $produit;
        }
    }

    /*=======================================================================*/
    /*                 Méthode principale de ProduitManager                  */
    /*=======================================================================*/

    /**
     * Ajoute ou met à jour un produit dans la table produits de la BDD
     *
     * ProduitToDb() est protégée et ne s'emploie de l'extérieur que via des
     * méthodes 'alias', et ce pour éviter de risquer une erreur sur le paramètre $action.
     *
     * @return string un message d'erreur en cas d'insertion impossible, void sinon
     */
    protected function ProduitToDb( $action )
    {
        try {
            $this->checkProduit();
        } catch (Exception $e) {
            return $e->getMessage();
        }

        /* le produit est valide, on continue */
        switch ( $action ) {
            case 'insert':
                $sql = "INSERT INTO produits
                        VALUES ('',
                                '" . $this->produit->getDateArrivee() . ",
                                '" . $this->produit->getDateDepart()  . ",
                                '" . $this->produit->getPrix()        . ",
                                '" . $this->produit->getEtat()        . ",
                                '" . $this->produit->getSalleID()     . ",
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

            default: $sql = ''; // TODO: vérifier si on ne peut pas mieux faire que ça
        }

        $result = $this->exequery($sql);
    }

    /*=======================================================================*/
    /*                   Alias pour l'utilisation de ProduitToDb()           */
    /*=======================================================================*/

    public function insertProduit()
    {
        /* Enregistrement (création) du produit dans la BDD */
        $insert_return = $this->ProduitToDb( 'insert' );
        if ( $insert_return ) {
            throw new Exception( $insert_return );
        }
    }

    public function updateProduit( $modifs )
    {
        /* Modification interne du produit */
        $modif_return = $this->alterProduit( $modifs );
        if ( $modif_return ) {
            throw new Exception( $modif_return );
        }

        /* Enregistrement (modification) du produit dans la BDD */
        $update_return = $this->ProduitToDb( 'update' );
        if ( $update_return ) {
            throw new Exception( $update_return );
        }
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
            throw new Exception('La date d\'arrivée doit être postérieure à la date du jour.');
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
            throw new Exception('La date d\'arrivée doit être antérieure ou égale à la date de départ.');
        }
    }

    /**
     * Vérifie que la salle du produit n'est pas utilisée sur le même créneau horaire par un autre produit
     *
     * @throws Exception si le produit ne satisfait pas cette condition
     * @return void
     */
    public function checkProduitUnique()
    {
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

    /**
     * Vérifie que l'id de la promo du produit, s'il existe, renvoie bien à une promo existante
     *
     * @throws Exception si le produit ne satisfait pas cette condition
     * @return void
     */
    /*public function checkPromo()
    {

    }*/

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

        /* deuxième condition: une salle ne peut pas être utilisée par plus d'un produit à la fois */
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
            throw new Exception('Les paramètres donnés pour modification du produit sont invalides.');
        }

        $champs_valables = ['DateArrivee', 'DateDepart', 'Prix', 'Etat', 'SalleID', 'PromoID'];

        /* et on supprime tous les autres */
        foreach ($modifs as $modif_cle => $modif) {
            if ( !in_array( $modif_cle, $champs_valables, true ) || !is_scalar( $modif ) ) {
                unset( $modifs[$modif_cle] );
            }
        }

        /* on vérifie qu'il reste des choses à traiter après ce nettoyage */
        if ( empty($modifs) ) {
            throw new Exception('Les paramètres donnés pour modification du produit sont invalides.');
        }

        return $modifs; // on peut renvoyer sereinement un tableau de modifications valides
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
        /* on s'assure d'abord de la validité des modifications demandées */
        try {
            $modifs = $this->checkModifications( $modifs );
        } catch (Exception $e) {
            return $e->getMessage();
        }

        /* on altère le produit courant avec ces modifications */
        foreach ($modifs as $modif_key => $modif) {
            try {
                call_user_func( [$this->produit, 'set' . $modif_key], $modif );
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
    }
}
