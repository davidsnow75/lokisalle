<?php

/**
 * Gestion des produits par l'administrateur
 */

class GestionproduitsController extends AdminController
{
    public function index()
    {
        /* récupération des salles pour préremplir les champs du formulaire */
        $salles_manager = $this->loadModel('SallesManagerModel');
        $data['salles'] = $salles_manager->get_items('salles');

        /* récupération des produits */
        $ids = func_get_args();
        $data['produits'] = ProduitManager::getProduits( $this->db, $ids );

        /* récupération d'un éventuel msg d'erreur */
        $data['msg'] = Session::flashget('events.gestionproduits.msg');

        $this->renderView('gestionproduits/index', $data);
    }

    public function ajouter()
    {
        if ( !isset($_POST) ) {
            header('location: /gestionproduits');
            exit;
        }

        /* sticky form */
        foreach($_POST as $key => $value) {
            $html_clean[$key] = htmlentities($value, ENT_QUOTES, "utf-8");
        }
        Session::set('post_data.ajouter-produit', $html_clean);

        /* initialisation du produit */
        try {
            $produit = new Produit( $this->db, $_POST );
        } catch (Exception $e) {
            Session::set('events.gestionproduits.msg', $e->getMessage());
            header('location: /gestionproduits');
            exit;
        }

        /* création du produit en BDD */
        try {
            $produitManager = new ProduitManager( $this->db, $produit );
            $produitManager->insertProduit();
        } catch (Exception $e) {
            Session::set('events.gestionproduits.msg', $e->getMessage());
            header('location: /gestionproduits');
            exit;
        }

        /* renvoi vers page de base */
        Session::set('events.gestionproduits.msg', 'Le produit a été créé avec succès.');
        header('location: /gestionproduits');
        exit;
    }
}
