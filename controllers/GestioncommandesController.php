<?php

class GestioncommandesController extends AdminController
{
    public function index()
    {
        $collector = $this->loadModel('CommandeCollector');

        $commandes = $collector->getCommandes();

        foreach ($commandes as $key => $commande) {
            $commandes[$key]['produits'] = $collector->getRelatedProduits( $commande['commandeId'] );
        }

        $data['commandes'] = $commandes;

        Debug::logCustom('Commandes', $commandes);

        $this->renderView('gestioncommandes/index', $data);
    }
}
