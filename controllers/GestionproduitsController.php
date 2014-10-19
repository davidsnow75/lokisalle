<?php

/**
 * Gestion des produits par l'administrateur
 */

class GestionproduitsController extends AdminController
{
    public function index()
    {
        /* récupération des produits */
        $ids = func_get_args();
        $data['produits'] = $this->loadModel('ProduitCollector')->getProduits( $ids );

        /* récupération des salles pour préremplir les champs du formulaire */
        $data['salles'] = $this->loadModel('SallesManagerModel')->get_items('salles');

        /* récupération d'un éventuel msg d'erreur */
        $data['msg'] = Session::flashget('events.gestionproduits.msg');

        $this->renderView('gestionproduits/index', $data);
    }

    public function ajouter()
    {
        if ( !isset($_POST) ) {
            $this->quit('/gestionproduits');
        }

        /* sticky form */
        foreach($_POST as $key => $value) {
            $html_clean[$key] = htmlentities($value, ENT_QUOTES, "utf-8");
        }
        Session::set('post_data.ajouter-produit', $html_clean);

        /* initialisation du produit */
        try {
            $produit = $this->loadModel( 'Produit', $_POST );
            $this->loadModel('ProduitManager', $produit)->insertProduit();
        } catch (Exception $e) {
            $this->quitWithLog('/gestionproduits', 'events.gestionproduits.msg', $e->getMessage());
        }

        /* renvoi vers page de base */
        $this->quitWithLog('/gestionproduits', 'events.gestionproduits.msg', 'Le produit a été créé avec succès.');
    }

    public function modifier( $id )
    {
        if ( empty($id) ) {
            $this->quit('/gestionproduits');
        }

        /* si on a renvoyé le formulaire de modification d'un produit */
        if ( isset($_POST['id']) && $_POST['id'] == $id ) {

            $modifs = [];

            foreach ($_POST as $key => $value) {
                switch ($key) {
                    case 'date_arrivee': $modifs['DateArrivee'] = $value; break;
                    case 'date_depart' : $modifs['DateDepart']  = $value; break;
                    case 'prix'        : $modifs['Prix']        = $value; break;
                    case 'etat'        : $modifs['Etat']        = $value; break;
                    case 'salle_id'    : $modifs['SalleID']     = $value; break;
                }
            }

            try {
                $produit = $this->loadModel( 'Produit', $id );
                $this->loadModel('ProduitManager', $produit)->updateProduit( $modifs );
            } catch (Exception $e) {
                $this->quitWithLog('/gestionproduits/modifier/' . intval($id), 'events.gestionproduits.msg', $e->getMessage());
            }

            /* renvoi vers page de base */
            $this->quitWithLog('/gestionproduits', 'events.gestionproduits.msg', 'Le produit a été modifié avec succès.');
        }

        /* sinon, on se contente d'afficher le formulaire de modification */
        $data['produit'] = $this->loadModel('ProduitCollector')->getProduits( $id );
        $data['salles']  = $this->loadModel('SallesManagerModel')->get_items('salles');
        $data['msg']     = Session::flashget('events.gestionproduits.msg');

        $this->renderView('gestionproduits/modifier', $data);
    }
}
