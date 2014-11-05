<?php

class GestionstatsController extends AdminController
{
    public function index()
    {
        $stats = $this->loadModel('Stats');

        $data = [
            'bestSalle'      => $stats->getBestSalle(),
            'bestRent'       => $stats->getBestRent(),
            'bestClient'     => $stats->getBestClient(),
            'chiffreAffaire' => $stats->getChiffreAffaire(),
        ];

        $this->renderView('gestionstats/index', $data);
    }
}
