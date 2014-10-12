<?php

/* Gestion des produits par l'administrateur
 */

class GestionproduitsController extends AdminController
{
    public function index()
    {
        $this->renderView('gestionproduits/index');
    }
}
