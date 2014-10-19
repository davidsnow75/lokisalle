<?php

class AccueilController extends Controller
{
    public function index()
    {
        $data['produits'] = $this->loadModel('ProduitCollector')->getThreeLastProduits();
        $this->renderView('accueil/index', $data);
    }
}
