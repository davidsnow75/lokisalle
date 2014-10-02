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

    // simple utilitaire pour automatiser la gestion d'erreur
    public function exequery( $sql )
    {
        $result = $this->db->query($sql);

        if ( !$result ) { // la requête a renvoyé une erreur
            Session::set('events.error.db_error', $this->db->error);
            header('location: /error/db_error');
            exit(1);
        }

        return $result;
    }
}
