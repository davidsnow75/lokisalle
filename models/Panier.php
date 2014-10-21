<?php // Il est inutile de gérer les quantités car dans Lokisalle, un produit peut apparaître au plus une fois dans un panier.

class Produit
{
    protected $id;
    protected $date_arrivee;
    protected $date_depart;
    protected $prix;
    protected $etat;
    protected $salle_id;
    protected $promo_id;

    public function __construct( $produit )
    {
        $this->id           = $produit['id'];
        $this->date_arrivee = $produit['date_arrivee'];
        $this->date_depart  = $produit['date_depart'];
        $this->prix         = $produit['prix'];
        $this->etat         = $produit['etat'];
        $this->salle_id     = $produit['salles_id'];
        $this->promo_id     = $produit['promotions_id'];
    }

    public function getID()          { return $this->id; }
    public function getDateArrivee() { return $this->date_arrivee; }
    public function getDateDepart()  { return $this->date_depart; }
    public function getPrix()        { return $this->prix; }
    public function getEtat()        { return $this->etat; }
    public function getSalleID()     { return $this->salle_id; }
    public function getPromoID()     { return $this->promo_id; }
}


class Panier
{
    const TVA = 19.6;

    protected $produits = [];

    public function getArticles() { return $this->produits; }

    public function has(Produit $produit)
    {
        return isset( $this->produits[$produit->getID()] );
    }

    public function add(Produit $produit)
    {
        if ( $this->has($produit) ) {
            throw new Exception('L\'article est déjà présent dans le panier.');
        }

        $this->produits[$produit->getID()] = $produit;
    }

    public function rem(Produit $produit)
    {
        unset( $this->produits[$produit->getID()] );
    }

    public function getTotal() {
        $total = 0;

        foreach ($this->produits as $produit) {
            $total += $produit->getPrix();
        }

        return $total + $total * self::TVA/100;
    }
}


$produit1 = new Produit([ 'id' => 1, 'date_arrivee' => '01/01/1000', 'date_depart' => '01/01/1000', 'prix' => 10, 'etat' => 0, 'salles_id' => 1, 'promotions_id' => 0 ]);
$produit2 = new Produit([ 'id' => 2, 'date_arrivee' => '02/02/1000', 'date_depart' => '02/02/1000', 'prix' => 20, 'etat' => 0, 'salles_id' => 1, 'promotions_id' => 0 ]);
$produit3 = new Produit([ 'id' => 3, 'date_arrivee' => '02/02/1000', 'date_depart' => '02/02/1000', 'prix' => 20, 'etat' => 1, 'salles_id' => 1, 'promotions_id' => 0 ]);

$panier = new Panier;

try {
    $panier->add($produit1);
    $panier->add($produit2);
    $panier->add($produit3);
    $panier->rem($produit1);
    $panier->add($produit2);
} catch (Exception $e) {
    echo $e->getMessage();
}

echo $panier->getTotal();

?><pre><?php var_dump($panier->getArticles()); ?></pre><?php
