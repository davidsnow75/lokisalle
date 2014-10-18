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

    /**
     * Crée un nouveau produit ou en récupère un de la BDD
     *
     * ce constructeur permet ou bien d'instancier un produit déjà existant en BDD
     * (en lui fournissant son id), ou bien d'initialiser un nouveau produit avec un
     * tableau de données le renseignant.
     *
     * @param mixed $arg array pour la création d'un nouveau produit
     *                   int   pour la récupération via la BDD
     *
     * @throws Exception si l'initialisation échoue, avec un message décrivant l'erreur
     * @return void
     */
    public function __construct( $db, $arg )
    {
        /* on n'oublie pas de récupérer le connecteur mysqli */
        parent::__construct($db);

        /* on a passé un tableau, c'est donc qu'on veut créer un produit */
        if ( is_array( $arg ) ) {
            $creation_produit_msg = $this->setProduit( $arg );

            /* si qqch a été retourné par setProduit(), alors c'est qu'il y a eu une erreur */
            if ( $creation_produit_msg ) {
                throw new Exception( $creation_produit_msg );
            }

            return; // l'objet a été correctement initialisé, on s'arrête là
        }

        /* Si le paramètre n'était pas un tableau, alors on va supposer qu'on demande la
         * récupération d'un produit de la BDD.
         */
        $sql = "SELECT * FROM produits WHERE id='" . intval($arg) . "';";
        $result = $this->exequery($sql);

        if ( $result->num_rows == 0 ) {
            throw new Exception('Le produit demandé n\'existe pas en base de données');
        }

        /* Si on est là, c'est qu'on a trouvé qqch en BDD, et cette chose est normalement unique.
         * On peut donc peupler l'objet des infos de cette chose.
         */
        $produit = $result->fetch_assoc();

        $this->id           = $produit['id'];
        $this->date_arrivee = $produit['date_arrivee'];
        $this->date_depart  = $produit['date_depart'];
        $this->prix         = $produit['prix'];
        $this->etat         = $produit['etat'];
        $this->salle_id     = $produit['salles_id'];
        // $this->promo_id     = $produit['promotions_id'];
    }


    /* ACCESSEURS ---------------------------------------*/
    public function getID()          { return $this->id; }
    public function getDateArrivee() { return $this->date_arrivee; }
    public function getDateDepart()  { return $this->date_depart; }
    public function getPrix()        { return $this->prix; }
    public function getEtat()        { return $this->etat; }
    public function getSalleID()     { return $this->salle_id; }
    // public function getPromoID()     { return $this->promo_id; }

    /* MUTATEURS ----------------------------------------*/

    public function setDateArrivee( $date_arrivee )
    {
        $date_arrivee = DateTime::createFromFormat('d/m/Y H:i:s', $date_arrivee . ' 00:00:00' );

        if ( !$date_arrivee ) {
            throw new Exception('Le format de la date d\'arrivée fourni est incorrect.');
        }

        $this->date_arrivee = $date_arrivee->format('U');
    }

    public function setDateDepart( $date_depart )
    {
        $date_depart = DateTime::createFromFormat('d/m/Y H:i:s', $date_depart . ' 00:00:00' );

        if ( !$date_depart ) {
            throw new Exception('Le format de la date de départ fourni est incorrect.');
        }

        $this->date_depart = $date_depart->format('U');
    }

    public function setPrix( $prix )
    {
        $prix = (int) $prix; // on s'assure de bien travailler sur un entier

        if ( !$prix || strlen( (string) $prix ) > 6 ) {
            throw new Exception('Le prix doit être un entier non-nul et ne doit pas compter plus de 6 chiffres.');
        }

        $this->prix = $prix;
    }

    public function setEtat( $etat )
    {
        if ( $etat ) {
            $this->etat = 1;
        } else {
            $this->etat = 0;
        }
    }

    public function setSalleID( $salle_id )
    {
        $salle_id = (int) $salle_id;

        if ( !$salle_id ) {
            throw new Exception('L\'ID de la salle du produit doit être un entier non-nul.');
        }

        $this->salle_id = $salle_id;
    }

    // public function setPromoID( $promo_id )
    // {
    //     $promo_id = (int) $promo_id;

    //     $this->promo_id = empty($promo_id) ? 0 : $promo_id;
    // }

    /* Méthodes spécifiques -----------------------------*/

    public function setProduit( $produit_data )
    {
        /* Vérification de la présence des paramètres.
         * NOTE: promo_id est facultatif, mais doit exister. Il sera
         * simplement fixé à 0 et ne renverra donc rien lors d'une requête SQL.
         */
        if (
            !is_array( $produit_data)
            || empty( $produit_data['salle_id'] )
            || empty( $produit_data['date_arrivee'] )
            || empty( $produit_data['date_depart'] )
            || empty( $produit_data['prix'] )
        ) {
            return 'Les paramètres fournis pour le peuplement de l\'objet sont invalides ou insuffisants.';
        }

        /* on essaie de peupler le produit */
        try {

            $this->setDateArrivee( $produit_data['date_arrivee'] );
            $this->setDateDepart( $produit_data['date_depart'] );
            $this->setPrix( $produit_data['prix'] );
            $this->setEtat( 0 );
            $this->setSalleID( $produit_data['salle_id'] );

            // if ( empty($produit_data['promo_id']) ) {
            //     $this->setPromoID( 0 );
            // } else {
            //     $this->setPromoID( $produit_data['promo_id'] );
            // }

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
