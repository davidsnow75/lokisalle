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
    private $valid_controller = false;

    /*
     *  Définit le triplet (contrôleur, action, paramètres) le plus adéquat en réponse à une requête
     *  et délégue à ce triplet le travail de fournir une réponse à cette requête
     */
    public function __construct()
    {
        // On peuple d'abord les attributs de l'application en fonction d'une éventuelle URL requise
        $this->analyser_url();

        /* Maintenant,
            - ou bien un contrôleur a été explicitement demandé et on doit vérifier qu'il existe
            - ou bien l'URL était vide, et $this->controller est au contrôleur par défaut (DEFAULT_CONTROLLER)
        */
        if ( file_exists('./controllers/' . $this->controller . 'Controller.php') ) {
            // on corrige le nom (par convention, tous les contrôleurs sont du type NomController,
            // mais les URL de type nom/action/[parametres])
            $this->controller .= 'Controller';
            // on garde trace de ce succès
            $this->valid_controller = true;
        } else {
            // un contrôleur inexistant a été demandé, on se rabat alors sur le contrôleur d'erreur en vue d'une 404
            $this->controller = 'ErrorController';
            $this->action = 'notFound';
            $this->parameters = [$this->url];
        }

        /* Trois cas de figure possibles ici:
            - l'URL demandait un contrôleur, et celui-ci existe, alors on crée une instance de ce contrôleur
            - l'URL était vide, alors on crée une instance du contrôleur par défaut
            - l'URL demandait un contrôleur invalide, alors on crée une instance du contrôleur d'erreur
        */
        $this->controller = new $this->controller;

        // on s'assure que l'action demandée au contrôleur (valide) lui appartient, sinon 404
        if ( $this->valid_controller && !method_exists($this->controller, $this->action) ) {
            $this->controller = new ErrorController;
            $this->action = 'notFound';
            $this->parameters = [$this->url];
        }

        // on possède maintenant toutes les informations adéquates, on lance donc l'application
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
}
