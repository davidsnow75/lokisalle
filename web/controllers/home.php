<?php

class Home extends Controller
{
    public function index($url = null)
    {
        require "./views/_templates/header.php";
        require "./views/home/index.php";
        require "./views/_templates/footer.php";
    }
}
