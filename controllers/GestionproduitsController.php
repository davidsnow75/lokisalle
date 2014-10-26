<?php

class GestionproduitsController extends AdminController
{
    public function index()
    {
        $ids = func_get_args();
        $data['produits'] = $this->loadModel('ProduitCollector')->getProduits( $ids );
        $data['promotions'] = $this->loadModel('PromotionCollector')->getPromotions();
        $data['salles'] = $this->loadModel('SallesManagerModel')->get_items('salles');
        $data['msg'] = Session::flashget('events.gestionproduits.msg');
        $this->renderView('gestionproduits/index', $data);
    }

    public function ajouter()
    {
        if ( !isset($_POST) ) {
            $this->quit('/gestionproduits');
        }

        /* sticky form */
        foreach($_POST as $key => $value) { $html_clean[$key] = htmlentities($value, ENT_QUOTES, "utf-8"); }
        Session::set('post_data.ajouter-produit', $html_clean);

        /* création */
        try {
            $produit = $this->loadModel('Produit', $_POST);
            $insertMsg = $this->loadModel('ProduitManager', $produit)->insertProduit();
        } catch (Exception $e) {
            $this->quit('/gestionproduits', 'events.gestionproduits.msg', $e->getMessage());
        }

        /* suppression du sticky form & renvoi vers page de base */
        Session::delete('post_data.ajouter-produit');
        $this->quit('/gestionproduits', 'events.gestionproduits.msg', $insertMsg);
    }

    public function modifier( $id )
    {
        $id = (int) func_get_arg(0);

        if ( !$id ) {
            $this->quit('/gestionproduits');
        }

        /* si le formulaire a été saisi */
        if ( isset($_POST['id']) && $_POST['id'] == $id ) {

            foreach ($_POST as $key => $value) {
                switch ($key) {
                    case 'date_arrivee': $modifs['DateArrivee'] = $value; break;
                    case 'date_depart' : $modifs['DateDepart']  = $value; break;
                    case 'prix'        : $modifs['Prix']        = $value; break;
                    case 'etat'        : $modifs['Etat']        = $value; break;
                    case 'salle_id'    : $modifs['SalleID']     = $value; break;
                    case 'promo_id'    : $modifs['PromoID']     = $value; break;
                }
            }

            try {
                $produit = $this->loadModel( 'Produit', $id );
                $deleteMsg = $this->loadModel('ProduitManager', $produit)->updateProduit( $modifs );
            } catch (Exception $e) {
                $this->quit('/gestionproduits/modifier/' . intval($id), 'events.gestionproduits.msg', $e->getMessage());
            }

            $this->quit('/gestionproduits', 'events.gestionproduits.msg', $updateMsg);
        }

        /* le formulaire n'a pas été saisi */
        $data['produit'] = $this->loadModel('ProduitCollector')->getSingleProduit( $id, 'withPromo' );
        $data['promotions'] = $this->loadModel('PromotionCollector')->getPromotions();
        $data['salles'] = $this->loadModel('SallesManagerModel')->get_items('salles');
        $data['msg'] = Session::flashget('events.gestionproduits.msg');
        $this->renderView('gestionproduits/modifier', $data);
    }

    public function supprimer()
    {
        $id = (int) func_get_arg(0);

        if ( !$id ) {
            $this->quit('/gestionproduits');
        }

        /* si le formulaire a été saisi */
        if ( isset($_POST['id']) && $_POST['id'] == $id ) {
            try {
                $produit = $this->loadModel('Produit', $id);
                $deleteMsg = $this->loadModel('ProduitManager', $produit)->deleteProduit();
            } catch (Exception $e) {
                $this->quit('/gestionproduits/supprimer/' . $id, 'events.gestionproduits.msg', $e->getMessage());
            }

            $this->quit('/gestionproduits', 'events.gestionproduits.msg', $deleteMsg);
        }

        /* le formulaire n'a pas été saisi */
        try {
            $produit = $this->loadModel('Produit', $id);
            $this->renderView('gestionproduits/supprimer', ['produit_id' => $id]);
        } catch (Exception $e) {
            $this->quit('/gestionproduits/index/' . $id, 'events.gestionproduits.msg', $e->getMessage());
        }
    }
}
