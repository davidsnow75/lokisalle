<?php

/**
 * application.php
 * ----------
 * Gère les entrées et les sorties de l'appli en déléguant le travail aux
 * modules adéquats (c'est le contrôleur frontal)
 */

class Application
{
    private $url_controller  = null;
    private $url_action      = null;
    private $url_parameter_1 = null;
    private $url_parameter_2 = null;
    private $url_parameter_3 = null;

    /**
     * L'application commence ici:
     * L'url, décomposée en une hiérarchie du type "AGENT/ACTION/PARAMÈTRES",
     * permet de lancer les modules adéquats au traitement de la requête
     */
    public function __construct()
    {
        // remplit les propriétés de l'objet
        $this->analyser_url();

        // ÉTAPE 1: le contrôleur demandé existe-t-il ?
        if (file_exists('./controllers/' . $this->url_controller . '.php')) {

            // oui, alors on le crée en instanciant sa classe
            require './controllers/' . $this->url_controller . '.php';
            $this->url_controller = new $this->url_controller();

            // ÉTAPE 2: la méthode demandée est-elle disponible dans ce contrôleur ?
            if (method_exists($this->url_controller, $this->url_action)) {

                // oui, alors on l'appelle avec les éventuels arguments
                // NOTE: on commence à tester par le dernier argument possible car on sait que s'il existe,
                // alors tous les précédents existent nécessairement aussi
                if (isset($this->url_parameter_3)) {
                    // on obtient qqchose du genre: $this->home->method($param_1, $param_2, $param_3);
                    $this->url_controller->{$this->url_action}($this->url_parameter_1, $this->url_parameter_2, $this->url_parameter_3);
                } elseif (isset($this->url_parameter_2)) {
                    // semblable à au-dessus
                    $this->url_controller->{$this->url_action}($this->url_parameter_1, $this->url_parameter_2);
                } elseif (isset($this->url_parameter_1)) {
                    // idem
                    $this->url_controller->{$this->url_action}($this->url_parameter_1);
                } else {
                    // pas de paramètres, la méthode est appelée seule, comme cela par ex.: $this->home->method();
                    $this->url_controller->{$this->url_action}();
                }
            } else {
                // la méthode n'est pas disponible, on se rabat par défaut sur la méthode index(),
                // que tout contrôleur est tenu d'implémenter
                $this->url_controller->index();
            }
        } else {
            // l'url est tout à fait invalide, on se rabat par défaut sur un contrôleur "d'accueil",
            // NOTE: les trois instructions suivantes sont du type de celles éventuellement exécutées
            // par les instructions ci-dessus
            require './controllers/home.php';
            $home = new Home();
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
            $this->url_controller  = (isset($url[0]) ? $url[0] : null);
            $this->url_action      = (isset($url[1]) ? $url[1] : null);
            $this->url_parameter_1 = (isset($url[2]) ? $url[2] : null);
            $this->url_parameter_2 = (isset($url[3]) ? $url[3] : null);
            $this->url_parameter_3 = (isset($url[4]) ? $url[4] : null);
        }
    }
}
