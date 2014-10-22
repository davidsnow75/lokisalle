<?php

/**
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

    const NOT_FOUND = 'Le produit demandé n\'existe pas.';
    const INVALID_INPUT = 'Les données fournies pour la création du produit sont invalides ou insuffisantes.';
    const INVALID_DATE_ARRIVEE = 'La date d\'arrivée doit être au format JJ/MM/AAAA.';
    const INVALID_DATE_DEPART = 'La date de départ doit être au format JJ/MM/AAAA.';
    const INVALID_PRIX = 'Le prix doit être un entier non-nul de moins de 6 chiffres.';
    const INVALID_SALLE_ID = 'L\'ID de la salle du produit doit être un entier non-nul.';

    /**
     * Crée un nouveau produit ou en récupère un de la BDD
     *
     * ce constructeur permet ou bien d'instancier un produit déjà existant en BDD
     * (en lui fournissant son id), ou bien d'initialiser un nouveau produit avec un
     * tableau de données le renseignant.
     *
     * @param mixed $arg array pour la création d'un nouveau produit
     *                   int   pour la récupération via la BDD
     */
    public function __construct( $db, $arg )
    {
        parent::__construct($db);

        if ( is_array( $arg ) ) {
            $this->setProduit( $arg );

        } else {
            $arg = (int) $arg;
            $sql = "SELECT * FROM produits WHERE id='" . $arg . "';";

            $result = $this->exequery($sql);
            if ( !$result->num_rows ) {
                throw new Exception(self::NOT_FOUND);
            }

            $this->$id = $arg
            $this->setPromo( $result->fetch_assoc() );
        }
    }

    /* ACCESSEURS ---------------------------------------*/
    public function getID()          { return $this->id; }
    public function getDateArrivee() { return $this->date_arrivee; }
    public function getDateDepart()  { return $this->date_depart; }
    public function getPrix()        { return $this->prix; }
    public function getEtat()        { return $this->etat; }
    public function getSalleID()     { return $this->salle_id; }
    public function getPromoID()     { return $this->promo_id; }

    /* MUTATEURS ----------------------------------------*/
    public function setDateArrivee( $date_arrivee )
    {
        $date_arrivee = DateTime::createFromFormat('d/m/Y H:i:s', $date_arrivee . ' 00:00:00' );
        if ( !$date_arrivee ) {
            throw new Exception(self::INVALID_DATE_ARRIVEE);
        }

        $this->date_arrivee = $date_arrivee->format('U');
    }

    public function setDateDepart( $date_depart )
    {
        $date_depart = DateTime::createFromFormat('d/m/Y H:i:s', $date_depart . ' 00:00:00' );
        if ( !$date_depart ) {
            throw new Exception(self::INVALID_DATE_DEPART);
        }

        $this->date_depart = $date_depart->format('U');
    }

    public function setPrix( $prix )
    {
        $prix = (int) $prix;
        if ( $prix && strlen( (string) $prix ) < 6 ) {
            $this->prix = $prix;
        } else {
            throw new Exception(self::INVALID_PRIX);
        }
    }

    public function setEtat( $etat )
    {
        $this->etat = (bool) $etat;
    }

    public function setSalleID( $salle_id )
    {
        $salle_id = (int) $salle_id;
        if ( $salle_id ) {
            $this->salle_id = $salle_id;
        } else {
            throw new Exception(self::INVALID_SALLE_ID);
        }
    }

    public function setPromoID( $promo_id )
    {
        $this->promo_id = (int) $promo_id;
    }

    /* MUTATEUR GLOBAL -----------------------------*/
    public function setProduit( $array )
    {
        if (
            empty( $array )
            || empty( $array['date_arrivee'] )
            || empty( $array['date_depart'] )
            || empty( $array['prix'] )
            || empty( $array['salle_id'] )
            || !isset( $array['etat'] )
            || !isset( $array['promo_id'] )
        ) {
            throw new Exception(self::INVALID_INPUT);
        }

        $etat = empty($array['etat']) ? 0 : $array['etat'];
        $promo_id = empty($array['promo_id']) ? 0 : $array['promo_id'];

        $this->setDateArrivee( $array['date_arrivee'] );
        $this->setDateDepart( $array['date_depart'] );
        $this->setPrix( $array['prix'] );
        $this->setEtat( $etat );
        $this->setSalleID( $array['salle_id'] );
        $this->setPromoID( $promo_id );
    }
}
