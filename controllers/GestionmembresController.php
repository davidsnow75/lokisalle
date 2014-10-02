<?php

/* Gestion des membres par l'administrateur
 */

class GestionmembresController extends AdminController
{
    public function index()
    {
        $requested_ids = func_get_args();

        $gestionsalles_model = $this->loadModel('GestionsallesModel');

        $data['salles'] = $gestionsalles_model->get_salles($requested_ids);

        $data['msg'] = $this->test_events_msg();

        $this->renderView('gestionsalles/index', $data);
    }
}
