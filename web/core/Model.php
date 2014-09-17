<?php

class Model
{
    protected $db;

    // tous les modèles reçoivent lors de leur instanciation la connexion
    // à la BDD établie par le contrôleur (cf. /core/Controller.php)
    public function __construct($db)
    {
        $this->db = $db;
    }
}
