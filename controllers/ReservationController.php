<?php

class ReservationController extends Controller
{
    public function index()
    {
        $data['produits'] = $this->loadModel('ProduitCollector')->getAllValidProduits();
        $this->renderView('reservation/index', $data);
    }
}
