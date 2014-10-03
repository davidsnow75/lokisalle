<?php

class AccueilController extends Controller
{
    public function index()
    {
        $this->renderView('accueil/index');
    }
}
