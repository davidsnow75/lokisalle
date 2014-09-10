<?php

/**
 * application.php
 * ---------------
 * Gère les entrées et les sorties de l'appli en déléguant le travail aux
 * modules adéquats (c'est le contrôleur frontal)
 */

class Application {

    private $url         = null;
    private $controller  = null;
    private $action      = null;
    private $parameters  = null;

    public function __construct()
    {
        // On peuple d'abord les attributs de l'application de façon adéquate
        $this->url = $this->analyser_url();


        ## TEST 0 ## Sans url requise, on envoie la page d'accueil
        if ( is_null($this->url) ) {
            require './controllers/HomeController.php';
            $home_ctrl = new HomeController;
            $home_ctrl->index();

            return; // rien d'autre à faire ici, on quitte le constructeur
        }


        ## TEST 1 ## Si le contrôleur demandé existe, alors on en crée une instance
        if ( file_exists('./controllers/' . $this->controller . 'Controller.php') ) {
            require './controllers/' . $this->controller . 'Controller.php';
            $thisController = $this->controller . 'Controller';
            $this->controller = new $thisController;

        } else { // l'url demandée n'a aucun sens, on envoie la page 404
            require_once './controllers/ErrorController.php';
            $error_ctrl = new ErrorController;
            $error_ctrl->notFound($this->url);

            return; // rien d'autre à faire ici, on quitte le constructeur
        }


        ## TEST 2 ## Si l'action demandée existe dans ce contrôleur
        if ( method_exists($this->controller, $this->action) ) {

            // si aucun paramètre n'a été fourni, on se contente de lancer l'action seule
            if ( empty($this->parameters) ):
                $this->controller->{$this->action}();

            else: // sinon on fournit les paramètres à l'action
                $this->controller->{$this->action}( $this->parameters );

            endif;

        } else { // l'action demandée n'existe pas, on actionne celle par défaut (index)
            $this->controller->index();

            return; // rien d'autre à faire ici, on quitte le constructeur
        }
    }


    /**
     * Récupérer et décomposer l'url pour peupler les propriétés vitales de l'application
     *
     * @param void
     * @return mixed (string ou null)
     */
    private function analyser_url() {

        // $_GET['url'] est une pseudo-url, dont l'intérêt par rapport à un système
        // avec plusieurs $_GET est notamment d'obliger à une hiérarchisation des
        // paramètres de routage (le premier étant forcément le contrôleur, le
        // second l'action, etc.)
        if (isset( $_GET['url'] )) {

            // décomposer l'url demandée en autant de partie que de slash
            $url = trim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url_array = explode('/', $url);

            // assigne aux propriétés adéquates les différentes parties (éventuelles) de l'url
            $url_depth = count($url_array);
            for ($i = 0; $i < $url_depth; $i++) {
                switch ($i) {
                    case 0:  $this->controller    = ucfirst( $url_array[0] );  break;
                    case 1:  $this->action        = $url_array[1];  break;
                    default: $this->parameters[]  = $url_array[$i]; break;
                }
            }

            // renvoie $url pour rendre possible sa transmission éventuelle au contrôleur (ex. page 404)
            return $url;
        }

        // on renvoie null car aucune url n'a été fournie via $_GET['url']
        return null;
    }
}
