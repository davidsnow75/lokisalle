<?php

/* Ce contrôleur renvoie les détails d'un produit */

class ProduitController extends Controller
{
    public function index()
    {
        $id = func_get_arg(0);

        if ( !$id ) {
            $this->quit('/');
        }

        $collector = $this->loadModel('ProduitCollector');

        $data['produit'] = $collector->getSingleProduit( $id );

        if ( empty($data['produit']) ) {
            $this->quit('/reservation');
        } else {
            $data['similarProduits'] = $collector->getThreeSimilarProduits( $data['produit'][0] );
        }

        $this->renderView('produit/index', $data);
    }
}
