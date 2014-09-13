<?php

/* Modèle de base de contrôleur
 * ----------------------------
 * On utilise une classe abstraite car cette classe ne doit pas être utilisée
 * directement, mais uniquement via des classes filles (donc des contrôleurs
 * particuliers).
 *
 * Est défini ici le comportement commun à tous les contrôleurs, cad à toutes
 * les pages:
 *      - Initialisation de la session (nouvelle ou précédente)
 *      - Connexion à la BDD
 *      - Chargement des modèles adéquats
 *      - Chargement des vues adéquates
 */

abstract class Controller
{
    // le lien à la BDD est ici, car on veut qu'il ne soit créé qu'une fois par
    // page, et un contrôleur <=> une page
    protected $db = null;

    // tous les contrôleurs enfants doivent implémenter une méthode index(),
    // afin de fournir une méthode par défaut commune
    abstract public function index();

    public function __construct()
    {
        // initialisation ou récupération de la session
        Session::init();

        // le lien à la bdd est créé à chaque instanciation d'un contrôleur
        $this->openDatabaseConnection();
    }

    // TODO : sécuriser d'avantage la connection ?
    private function openDatabaseConnection()
    {
        $this->db = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->db->connect_error) {
            $data['error'] = $this->db->connect_error;
            $this->renderView('error/db_error', $data);
            exit(1);
        }
    }

    /**
     * Charge le modèle donné en argument en lui transmettant la connection
     * à la BDD
     */
    public function loadModel($modele_a_charger)
    {
        return new $modele_a_charger($this->db);
    }

    /**
     * Construit la vue adéquate. Les éventuels paramètres (informations dynamiques),
     * servant à construire cette vue lui sont fournis
     */
    public function renderView($view, $data = null)
    {
        require './views/_templates/header.php';

        if ( file_exists('./views/' . $view . '.php') ) {
            require './views/' . $view . '.php';
        } else {
            require './views/error/default_error.php';
        }

        require './views/_templates/footer.php';
    }
}
