<?php

class Panier extends Model
{
    const TVA = 19.6;

    protected $produits;
    protected $promotions;
    protected $total;

    public function __construct( $db, $panier = [] )
    {
        parent::__construct($db);

        $this->produits = isset( $panier['produits'] ) ? $panier['produits'] : [];
        $this->promotions = isset( $panier['promotions'] ) ? $panier['promotions'] : [];
        $this->total = $this->setTotal();
    }

    /* accesseurs */
    public function getTotal() { return $this->total; }
    public function getPanier() {
        return [
            'produits' => $this->produits,
            'promotions' => $this->promotions,
            'total' => $this->total,
            'tva' => $this->getTVA()
        ];
    }

    /* méthodes spécifiques */
    public function has(Produit $produit)
    {
        return isset( $this->produits[$produit->getID()] );
    }

    public function add(Produit $produit)
    {
        if ( $this->has($produit) ) {
            throw new Exception('Ce produit est déjà présent dans le panier.');
        }

        $id = $produit->getID();
        $collector = new ProduitCollector($this->db);

        $this->produits[$id] = $collector->getSingleProduit( $id, 'withPromo' )[0];
        $this->total = $this->setTotal();
    }

    public function rem(Produit $produit)
    {
        unset( $this->produits[$produit->getID()] );
        $this->total = $this->setTotal();
    }

    public function clear()
    {
        Session::delete('panier');
        $this->produits = [];
        $this->promotions = [];
        $this->total = 0;
    }

    public function setTotal() {
        $total = 0;
        foreach ($this->produits as $produit) {
            $total += $produit['produitPrix'];
        }
        return $total;
    }

    public function getTVA() {
        return $this->total * self::TVA/100;
    }

    public function addPromo(Promotion $promo)
    {
    }
}
