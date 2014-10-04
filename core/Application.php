<?php

/*
 * Application
 * -----------
 * Gère les entrées de l'appli en déléguant le travail aux
 * contrôleurs adéquats (c'est le contrôleur frontal)
 *
 */

class Application {

    private $url              = '';
    private $controller       = DEFAULT_CONTROLLER; // ce contrôleur par défaut est défini dans config.php
    private $action           = 'index'; // tous les contrôleurs doivent implémenter index() (cf Controller.php)
    private $parameters       = [];

    /*
     *  Définit le triplet (contrôleur, action, paramètres) le plus adéquat en réponse à une requête
     *  et délégue à ce triplet le travail de fournir une réponse à cette requête
     */
    public function __construct()
    {
        // initialisation ou récupération de la session si tôt car on veut pouvoir en bénéficier pour le débug
        Session::init();

        // on sauvegarde l'état des superglobales au moment de l'entrée dans l'appli
        Debug::logGlobals();

        // On peuple d'abord les attributs de l'application en fonction d'une éventuelle URL requise
        $this->analyser_url();

        /* Maintenant,
            - ou bien un contrôleur a été explicitement demandé et on doit vérifier qu'il existe
            - ou bien l'URL était vide, et $this->controller est au contrôleur par défaut (DEFAULT_CONTROLLER)
        */
        if ( file_exists('../controllers/' . $this->controller . 'Controller.php') ) {
            // on corrige le nom (par convention, tous les contrôleurs sont du type NomController,
            // mais les URL de type nom/action/[parametres])
            $this->controller .= 'Controller';
            // puis on instancie ce contrôleur
            $this->controller = new $this->controller;
        }

        /* Si $this->controller n'est pas maintenant une instance de Controller, alors c'est que le
         * contrôleur demandé n'existait pas, donc 404
         * Si c'en est une, alors s'il ne possède pas la méthode demandée, alors 404
         */
        if ( !($this->controller instanceof Controller) || !method_exists($this->controller, $this->action) ) {
            $this->controller = new ErrorController;
            $this->action = 'notFound';
            Session::set('events.error.notfound_url', $this->url); // on passe par la session pour assurer une cohérence dans la suite des opérations
        }

        // à fins de débug
        Debug::logURL( $this->url );
        Debug::logController( $this->controller );
        Debug::logAction( $this->action );
        Debug::logParameters( $this->parameters );

        // on possède maintenant toutes les informations adéquates, on lance donc l'application
        // NOTE: call_user_func_array() ne passe pas au contrôleur un tableau des paramètres, mais les paramètres séparement !
        // TODO: fixer une limite au nombre de paramètres que peut recevoir une action ?
        call_user_func_array( [$this->controller, $this->action], $this->parameters );
    }


    /*
     *  Récupére une éventuelle URL et la décompose pour peupler les propriétés vitales de l'application
     */
    private function analyser_url() {

        if (isset( $_GET['url'] )) {

            // décomposer l'url demandée en autant de partie que de slash
            $url = trim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url_array = explode('/', $url);

            // si on demande un url commençant par /admin, il ne faut pas la traiter telle quelle
            // (désactivé dans notre cas)
            if ( ADMIN_CONTROLLERS_ARE_PREFIXED ) {
                $url_array = $this->clean_admin_from_url_array($url_array);
            }

            // peuple l'objet des infos tirées de l'URL
            $this->url        = $url;
            $this->controller = isset($url_array[0]) ? ucfirst($url_array[0]) : $this->controller;
            $this->action     = isset($url_array[1]) ? $url_array[1]          : $this->action;

            // nous voulons récupérer les éventuels paramètres dans un tableau.
            // un moyen efficace pour cela est le suivant:

            // on supprime contrôleur et action (peu importe à unset() qu'ils existent ou non)
            unset( $url_array[0], $url_array[1] );

            // il ne reste plus dans $url_array que les paramètres, alors on réindexe le tableau
            $this->parameters = array_values($url_array);
        }
    }

    /*
     * modifie $url_array s'il commence par 'admin' en un tableau compréhensible par l'application
     */
    private function clean_admin_from_url_array( $url_array )
    {
        if ( isset($url_array[0]) && $url_array[0] === 'admin' ) {

            if ( isset($url_array[1]) ) {
                $url_array[1] = ADMIN_CONTROLLER_PREFIX . $url_array[1];
            } else {
                $url_array[1] = 'connexion'; // on veut que /admin soit traité par ConnexionController
            }

            unset( $url_array[0] );
            $url_array = array_values( $url_array );
        }

        return $url_array;
    }
}
