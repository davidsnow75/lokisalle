<?php

class GestionpromotionsController extends AdminController
{
    public function index()
    {
        $ids = func_get_args();
        $data['promotions'] = $this->loadModel('PromotionCollector')->getPromotions($ids);
        $data['msg'] = Session::flashget('events.gestionpromotions.msg');
        $this->renderView('gestionpromotions/index', $data);
    }

    public function ajouter()
    {
        if ( !isset($_POST) ) {
            $this->quit('/gestionpromotions');
        }

        /* sticky form */
        foreach($_POST as $key => $value) { $html_clean[$key] = htmlentities($value, ENT_QUOTES, "utf-8"); }
        Session::set('post_data.ajouter-promo', $html_clean);

        /* création */
        try {
            $promotion = $this->loadModel('Promotion', $_POST);
            $insertMsg = $this->loadModel('PromotionManager', $promotion)->insertPromotion();
        } catch (Exception $e) {
            $this->quit('/gestionpromotions', 'events.gestionpromotions.msg', $e->getMessage());
        }

        /* suppression du sticky form & renvoi vers page de base */
        Session::delete('post_data.ajouter-promo');
        $this->quit('/gestionpromotions', 'events.gestionpromotions.msg', $insertMsg);
    }

    public function modifier()
    {
        $id = (int) func_get_arg(0);

        if ( !$id ) {
            $this->quit('/gestionpromotions');
        }

        /* si le formulaire a été saisi */
        if ( isset($_POST['id']) && $_POST['id'] == $id ) {
            try {
                $promotion = $this->loadModel('Promotion', $id);
                $updateMsg = $this->loadModel('PromotionManager', $promotion)->updatePromotion($_POST);
            } catch (Exception $e) {
                $this->quit('/gestionpromotions/modifier/' . $id, 'events.gestionpromotions.msg', $e->getMessage());
            }

            $this->quit('/gestionpromotions', 'events.gestionpromotions.msg', $updateMsg);
        }

        /* le formulaire n'a pas été saisi */
        $data['promotions'] = $this->loadModel('PromotionCollector')->getPromotions( $id );
        $data['msg'] = Session::flashget('events.gestionpromotions.msg');
        $this->renderView('gestionpromotions/modifier', $data);
    }

    public function supprimer()
    {
        $id = (int) func_get_arg(0);

        if ( !$id ) {
            $this->quit('/gestionpromotions');
        }

        /* si le formulaire a été saisi */
        if ( isset($_POST['id']) && $_POST['id'] == $id ) {
            try {
                $promotion = $this->loadModel('Promotion', $id);
                $deleteMsg = $this->loadModel('PromotionManager', $promotion)->deletePromotion();
            } catch (Exception $e) {
                $this->quit('/gestionpromotions/supprimer/' . $id, 'events.gestionpromotions.msg', $e->getMessage());
            }

            $this->quit('/gestionpromotions', 'events.gestionpromotions.msg', $deleteMsg);
        }

        /* le formulaire n'a pas été saisi */
        try {
            $promotion = $this->loadModel('Promotion', $id);
            $this->renderView('gestionpromotions/supprimer', ['promo_id' => $id]);
        } catch (Exception $e) {
            $this->quit('/gestionpromotions/index/' . $id, 'events.gestionpromotions.msg', $e->getMessage());
        }
    }
}
