<?php

class Commande extends Model
{
    protected $id;
    protected $montant;
    protected $date;
    protected $membres_id;
    protected $produits;

    const INVALID_COMMANDE = 'La commande est invalide.';

    public function getId()         { return $this->id; }
    public function getMontant()    { return $this->montant; }
    public function getDate()       { return $this->date; }
    public function getMembres_id() { return $this->membres_id; }
    public function getProduits()   { return $this->membres_id; }

    public function __construct( $db, $commande )
    {
        parent::__construct($db);

        $this->setMontant( $commande['montant'] );
        $this->date = time();
        $this->setMembres_id( $commande['membres_id'] );
        $this->setProduits( $commande['produits'] );
    }

    public function setMontant( $montant )
    {
        $this->montant = (int) $montant;
    }

    public function setMembres_id( $membres_id )
    {
        $this->membres_id = (int) $membres_id;
    }

    public function setProduits( $produits )
    {
        $collector = new ProduitCollector($this->db);
        $this->produits = $collector->getProduits( $produits, 'id, etat' );

        $sold_produits = [];

        foreach ($this->produits as $produit) {
            if ( $produit['etat'] ) {
                $sold_produits[] = $produit['id'];
            }
        }

        if ( !empty($sold_produits) ) {
            throw new Exception(implode('/', $sold_produits));
        }
    }

    public function insert()
    {
        if (
            empty($this->montant)
            || empty($this->date)
            || empty($this->membres_id)
            || empty($this->produits)
        ) {
            throw new Exception(self::INVALID_COMMANDE);
        }

        /* insertion dans la table commandes */
        $sql = "INSERT INTO commandes
                VALUES ('',
                        " . $this->getMontant() . ",
                        " . $this->getDate()    . ",
                        " . $this->getMembres_id() . ");";

        $this->exequery($sql);

        /* insertion dans la table details_commandes */
        $this->id = $this->db->insert_id;

        foreach ( $this->produits as $produit ) {
            $this->exequery("INSERT INTO details_commandes VALUES ('', " . $this->id . ", " . $produit['id'] . " );");
        }
    }
}
