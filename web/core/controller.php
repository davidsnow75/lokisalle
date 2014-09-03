<?php

/* Modèle de base de contrôleur
 * ----------------------------
 * On utilise une classe abstraite car cette classe ne doit pas être utilisée
 * directement, mais uniquement via des classes filles (donc des contrôleurs
 * particuliers)
 */

abstract class Controller
{
    // le lien à la BDD est ici, car on veut qu'il ne soit créé qu'une fois par
    // page, et un contrôleur <=> une page
    protected $db = null;

    // tous les contrôleurs enfants doivent implémenter une méthode index(),
    // afin de fournir une méthode par défaut lors de leur appel
    abstract public function index($url);

    // le lien à la bdd est créé à chaque instanciation d'un contrôleur
    public function __construct()
    {
        $this->openDatabaseConnection();
    }

    // TODO : sécuriser la connection
    private function openDatabaseConnection()
    {
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    /**
     * Charge le modèle donné en argument en lui transmettant la connection
     * à la BDD
     */
    public function loadModel($modele_a_charger)
    {
        require './models/' . strtolower($modele_a_charger) . '.php';
        return new $modele_a_charger($this->db);
    }
}
