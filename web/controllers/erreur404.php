<?php

class erreur404 extends Controller
{
    public function index($url)
    {
        require './views/_templates/header.php';
        /* le code est dans le contrôleur, pas bien... */
        $url = implode('/', $url);
        $url = htmlentities($url, ENT_QUOTES, "utf-8");
        require './views/erreur404.php';
        require './views/_templates/footer.php';
    }
}
