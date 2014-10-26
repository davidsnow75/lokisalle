<?php

class PanierController extends MembreController
{
    const ADD_SUCCESS = 'Le produit a bien été ajouté au panier.';
    const REM_SUCCESS = 'Le produit a bien été supprimé du panier.';
    const PROMO_SUCCESS = 'La promotion a bien été appliquée au panier.';
    const SOLD_PRODUITS = 'Des produits ont été supprimés de votre panier car ils n\'étaient plus disponibles. Merci de bien vouloir relancer le paiement.';
    const COMMANDE_SUCCESS = 'Votre commande a bien été enregistrée, merci !';
    const CGV = 'Vous devez accepter les conditions générales de vente avant de pouvoir valider votre commande.';

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
                $panier->remProduit($produit->getID());
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

    public function payer()
    {
        if ( !isset($_POST['payer']) ) {
            $this->quit('/panier');
        }

        if ( empty($_POST['cgv_ok']) ) {
            $this->quit('/panier', 'events.panier.msg', self::CGV);
        }

        $panier = $this->loadModel('Panier', Session::get('panier'));

        try {
            $commande = $this->loadModel('Commande', $panier->toDb());
            $soldProduitsId = false;
        } catch (Exception $e) {
            $soldProduitsId = explode('/', $e->getMessage());
        }

        if ( $soldProduitsId ) {
            foreach( $soldProduitsId as $id ) {
                $panier->remProduit($id);
            }

            Session::set( 'panier', $panier->toSession() );
            $this->quit('/panier', 'events.panier.msg', self::SOLD_PRODUITS);
        }

        try {
            $commande->insert();
        } catch (Exception $e) {
            $this->quit('/panier', 'events.panier.msg', $e->getMessage());
        }

        $panier->clear();
        $this->quit('/panier', 'events.panier.msg', self::COMMANDE_SUCCESS);
    }
}
