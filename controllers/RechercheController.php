<?php

class RechercheController extends Controller
{
    public function index()
    {
        $this->renderView('recherche/index');
    }

    public function resultat()
    {
        if (empty($_POST)) {
            $this->quit('/recherche');
        }

        $data = $this->loadModel('ProduitCollector')->getProduitsFromRecherche( $_POST );
        $this->renderView('recherche/index', $data);
    }
}
