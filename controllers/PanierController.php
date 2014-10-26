<?php

class PanierController extends MembreController
{
    const ADD_SUCCESS = 'Le produit a bien été ajouté au panier.';
    const REM_SUCCESS = 'Le produit a bien été supprimé du panier.';
    const PROMO_SUCCESS = 'La promotion a bien été appliquée au panier.';

    public function index()
    {
        $data['panier'] = $this->loadModel('Panier', Session::get('panier'))->toDisplay();
        $data['msg'] = Session::flashget('events.panier.msg');
        $this->renderView('panier/index', $data);
    }

    public function ajouter()
    {
        $id = (int) func_get_arg(0);
        if ( !$id ) {
            $this->quit('/panier');
        }

        $panier = $this->loadModel('Panier', Session::get('panier'));

        try {
            $produit = $this->loadModel('Produit', $id);
            $panier->addProduit($produit);
        } catch (Exception $e) {
            $this->quit('/panier', 'events.panier.msg', $e->getMessage());
        }

        Session::set( 'panier', $panier->toSession() );
        $this->quit('/panier', 'events.panier.msg', self::ADD_SUCCESS);
    }

    public function supprimer()
    {
        $id = (int) func_get_arg(0);
        if ( !$id ) {
            $this->quit('/panier');
        }

        $panier = $this->loadModel('Panier', Session::get('panier'));

        try {
            $produit = $this->loadModel('Produit', $id);
            if ( $panier->hasProduit($produit) ) {
                $panier->remProduit($produit);
            } else {
                $this->quit('/panier');
            }
        } catch (Exception $e) {
            $this->quit('/panier', 'events.panier.msg', $e->getMessage());
        }

        Session::set( 'panier', $panier->toSession() );
        $this->quit('/panier', 'events.panier.msg', self::REM_SUCCESS);
    }

    public function vider()
    {
        $this->loadModel('Panier')->clear();
        $this->quit('/panier');
    }

    public function addpromo()
    {
        if ( empty($_POST['code_promo']) ) {
            $this->quit('/panier');
        }

        $panier = $this->loadModel('Panier', Session::get('panier'));

        try {
            $promotion = $this->loadModel('Promotion', $_POST['code_promo']);
            $panier->addPromotion($promotion);
        } catch (Exception $e) {
            $this->quit('/panier', 'events.panier.msg', $e->getMessage());
        }

        Session::set( 'panier', $panier->toSession() );
        $this->quit('/panier', 'events.panier.msg', self::PROMO_SUCCESS);
    }
}
