<?php

class GestionavisController extends AdminController
{
    public function index()
    {
        $ids = func_get_args();
        $data['avis'] = $this->loadModel('AvisCollector')->getAvis( $ids );
        $data['msg'] = Session::flashget('events.gestionavis.msg');
        $this->renderView('gestionavis/index', $data);
    }

    public function supprimer()
    {
        $id = empty($_POST['id']) ? false : intval($_POST['id']);

        if ( !$id ) {
            $this->quit('/gestionavis');
        }

        try {
            $avis = $this->loadModel('Avis', $id);
            $deleteMsg = $this->loadModel('AvisManager', $avis)->deleteAvis();
        } catch (Exception $e) {
            $this->quit('/gestionavis', 'events.gestionavis.msg', $e->getMessage());
        }

        $this->quit('/gestionavis', 'events.gestionavis.msg', $deleteMsg);
    }
}
