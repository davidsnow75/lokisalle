<?php

/**
 * application.php
 * ---------------
 * Gère les entrées et les sorties de l'appli en déléguant le travail aux
 * modules adéquats (c'est le contrôleur frontal)
 */

class Application
{
    private $url        = null;
    private $controller = null;
    private $action     = null;
    private $parameter1 = null;
    private $parameter2 = null;
    private $parameter3 = null;

    /**
     * L'application commence ici:
     * L'url, décomposée en une hiérarchie du type "AGENT/ACTION/PARAMÈTRES",
     * permet de lancer les modules adéquats au traitement de la requête
     */
    public function __construct()
    {
        // remplit les propriétés de l'objet
        $this->url = $this->analyser_url();

        // ETAPE 0: A-t-on demandé une url ?
        if ( !is_null($this->controller) ) {

            // ÉTAPE 1: le contrôleur demandé existe-t-il ?
            if ( file_exists('./controllers/' . $this->controller . '_ctrl.php') ) {

                // oui, alors on le crée en instanciant sa classe
                require_once './controllers/' . $this->controller . '_ctrl.php';
                $this->controller = new $this->controller();

                // ÉTAPE 2: la méthode demandée est-elle disponible dans ce contrôleur ?
                if ( method_exists($this->controller, $this->action) ) {

                    // oui, alors on l'appelle avec les éventuels arguments
                    // NOTE: on commence à tester par le dernier argument possible car on sait que s'il existe,
                    // alors tous les précédents existent nécessairement aussi
                    if ( isset($this->parameter3) ) {
                        // on obtient qqchose du genre: $this->home->method($param_1, $param_2, $param_3);
                        $this->controller->{$this->action}($this->parameter1, $this->parameter2, $this->parameter3);

                    } elseif ( isset($this->parameter2) ) {
                        // semblable à au-dessus
                        $this->controller->{$this->action}($this->parameter1, $this->parameter2);

                    } elseif ( isset($this->parameter1) ) {
                        // idem
                        $this->controller->{$this->action}($this->parameter1);

                    } else {
                        // pas de paramètres, la méthode est appelée seule, comme cela par ex.: $this->home->method();
                        $this->controller->{$this->action}();
                    }
                } else {
                    // la méthode n'est pas disponible, on se rabat par défaut sur la méthode index(),
                    // que tout contrôleur est tenu d'implémenter
                    $this->controller->index();
                }
            } else {
                // l'url est tout à fait invalide, on envoie la page 404
                require_once './controllers/error_ctrl.php';
                $erreur = new Error;
                $erreur->notFound($this->url);
            }
        } else {
            // pas d'url fournie, donc on appelle le contrôleur "d'accueil"
            // NOTE: les trois instructions suivantes sont du type de celles éventuellement exécutées
            // par les instructions ci-dessus
            require_once './controllers/home_ctrl.php';
            $home = new Home;
            $home->index();
        }
    }

    /**
     * Récupère et décomposer l'url pour la préparer avant son traitement
     */
    private function analyser_url()
    {
        // $_GET['url'] est une pseudo-url, dont l'intérêt par rapport à un système
        // avec plusieurs $_GET est notamment d'obliger à une hiérarchisation des
        // paramètres de routage (le premier étant forcément le contrôleur, le
        // second l'action, etc.)
        if (isset($_GET['url'])) {

            // décomposer l'url demandée en autant de partie que de slash
            $url = trim($_GET['url'], '/'); // supprime les caractères invisibles & les slashs de début & fin de chaîne
            $url = filter_var($url, FILTER_SANITIZE_URL); // supprime les caractères illégaux d'une url
            $url = explode('/', $url); // décompose

            // assigne aux propriétés adéquates les différentes parties (éventuelles) de l'url
            $this->controller = (isset($url[0]) ? $url[0] : null);
            $this->action     = (isset($url[1]) ? $url[1] : null);
            $this->parameter1 = (isset($url[2]) ? $url[2] : null);
            $this->parameter2 = (isset($url[3]) ? $url[3] : null);
            $this->parameter3 = (isset($url[4]) ? $url[4] : null);

            // renvoie $url pour rendre possible sa transmission éventuelle au contrôleur
            return $url;
        }
    }
}
