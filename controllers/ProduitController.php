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

        $temp = $collector->getSingleProduit( $id );
        $data['produit'] = $temp[0];

        if ( empty($data['produit']) ) {
            $this->quit('/reservation');
        } else {
            $data['similarProduits'] = $collector->getThreeSimilarProduits( $data['produit'] );
        }

        $data['avis'] = $this->loadModel('AvisCollector')->getThreeLastAvis( $data['produit']['salleID'] );

        $data['msg'] = Session::flashget('events.produit.msg');

        $this->renderView('produit/index', $data);
    }

    public function commenter()
    {
        if ( empty($_POST) || empty($_POST['produit_id'])) {
            $this->quit('/');
        }

        $produit_id = $_POST['produit_id'];

        $array['commentaire'] = isset($_POST['commentaire']) ? $_POST['commentaire'] : '';
        $array['note']        = isset($_POST['note'])        ? $_POST['note'] : '';
        $array['date']        = time();
        $array['salles_id']   = isset($_POST['salles_id'])   ? $_POST['salles_id'] : '';
        $array['membres_id']  = Session::get('user.id');

        try {
            $avis = $this->loadModel('Avis', $array);
            $insertMsg = $this->loadModel('AvisManager', $avis)->insertAvis();
        } catch (Exception $e) {
            $this->quit('/produit/index/' . $produit_id, 'events.produit.msg', $e->getMessage() );
        }

        $this->quit('/produit/index/' . $produit_id, 'events.produit.msg', $insertMsg);
    }
}
