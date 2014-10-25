<?php

class PanierController extends MembreController
{
    const ADD_SUCCESS = 'Le produit a bien été ajouté au panier.';
    const REM_SUCCESS = 'Le produit a bien été supprimé du panier.';

    public function index()
    {
        $data['panier'] = $this->loadModel('Panier', Session::get('panier'))->getPanier();
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
            $panier->add($produit);
        } catch (Exception $e) {
            $this->quit('/panier', 'events.panier.msg', $e->getMessage());
        }

        Session::set( 'panier', $panier->getPanier() );
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
            $panier->rem($produit);
        } catch (Exception $e) {
            $this->quit('/panier', 'events.panier.msg', $e->getMessage());
        }

        Session::set( 'panier', $panier->getPanier() );
        $this->quit('/panier', 'events.panier.msg', self::REM_SUCCESS);
    }

    public function vider()
    {
        $this->loadModel('Panier')->clear();
        $this->quit('/panier');
    }
}
