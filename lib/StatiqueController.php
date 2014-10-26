<?php

class StatiqueController extends Controller
{
    public function index()
    {
        if ( empty($this->view) ) {
            $this->quit('/');
        } else {
            $this->renderView( $this->view );
        }
    }
}
