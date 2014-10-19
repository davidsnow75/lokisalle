<?php

/* Modèle de base de contrôleur
 * ----------------------------
 * On utilise une classe abstraite car cette classe ne doit pas être utilisée
 * directement, mais uniquement via des classes filles (donc des contrôleurs
 * particuliers).
 *
 * Est défini ici le comportement commun à tous les contrôleurs, cad à toutes
 * les pages:
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
        // le lien à la bdd est créé à chaque instanciation d'un contrôleur
        $this->openDatabaseConnection();
    }

    // TODO : sécuriser d'avantage la connection ?
    protected function openDatabaseConnection()
    {
        $this->db = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->db->connect_error) {
            $data['error'] = $this->db->connect_error;
            $this->renderView('error/db_error', $data);
            exit(1);
        }

        $this->db->set_charset("utf8");
    }

    /**
     * Renvoie une instance d'une classe à qui on aura passé en premier argument pour son
     * constructeur le connecteur à la BDD.
     *
     * Cette fonction peut être appelée avec un minimum d'un argument (le nom de la classe)
     * et un maximum illimité d'argument. À partir du second argument, ils seront tout simplement
     * transmis au constructeur de la classe qui les utilisera si besoin est.
     */
    public function loadModel()
    {
        $args = func_get_args();

        if (empty($args)) {
            return false; // si aucun argument n'a été passé
        }

        $reflection = new ReflectionClass( $args[0] );
        $args[0] = $this->db;

        return $reflection->newInstanceArgs( $args );
    }

    /**
     * Construit la vue adéquate. Les éventuels paramètres (informations dynamiques),
     * servant à construire cette vue lui sont fournis
     */
    public function renderView($view, $data = null)
    {
        require '../views/functions.php';
        require '../views/_templates/header.php';

        if ( file_exists('../views/' . $view . '.php') ) {
            require '../views/' . $view . '.php';
        } else {
            require '../views/error/default_error.php';
        }

        require '../views/_templates/footer.php';
    }

    /**
     *
     */
    public function quit( $location ) {
        header('location: http://lokisalle' . $location);
        exit;
    }

    public function quitWithLog( $location, $logkey, $log ) {
        Session::set( $logkey, $log );
        $this->quit( $location );
    }
}
