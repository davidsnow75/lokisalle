<?php

class AccueilController extends Controller
{
    public function index()
    {
        $data['produits'] = ProduitManager::getThreeLastProduits($this->db);
        $this->renderView('accueil/index', $data);
    }
}
