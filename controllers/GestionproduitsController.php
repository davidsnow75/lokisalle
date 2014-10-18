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
        $data['produits'] = ProduitManager::getProduits( $this->db, $ids );

        /* récupération des salles pour préremplir les champs du formulaire */
        $data['salles'] = $this->loadModel('SallesManagerModel')->get_items('salles');

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

    public function modifier( $id )
    {
        if ( empty($id) ) {
            header('location: /gestionproduits');
            exit;
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
                $produit = new Produit( $this->db, $id );
                $manager = new ProduitManager( $this->db, $produit );
                $manager->updateProduit( $modifs );
            } catch (Exception $e) {
                Session::set('events.gestionproduits.msg', $e->getMessage());
                header('location: /gestionproduits/modifier/' . intval($id) );
                exit;
            }

            /* renvoi vers page de base */
            Session::set('events.gestionproduits.msg', 'Le produit a été modifié avec succès.');
            header('location: /gestionproduits');
            exit;
        }

        /* sinon, on se contente d'afficher le formulaire de modification */
        $data['produit'] = ProduitManager::getProduits( $this->db, [$id] );
        $data['salles'] = $this->loadModel('SallesManagerModel')->get_items('salles');
        $data['msg'] = Session::flashget('events.gestionproduits.msg');

        $this->renderView('gestionproduits/modifier', $data);
    }
}
