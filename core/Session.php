<?php

/* Prend en charge la session de l'utilisateur
 * TODO: flash data
 */

class Session
{
    /* Démarre une session ou en récupère une déjà existante
     */
    public static function init()
    {
        // si session_id() renvoie qqch, alors c'est qu'une session est déjà en cours
        if ( session_id() === '') {
           session_start();
        }
    }

    /* Réinitialisation de la session
     * TODO: revoir http://php.net/manual/fr/function.session-destroy.php
     */
    public static function wipe_all()
    {
        // Détruit toutes les variables de session
        $_SESSION = array();
    }

    /**
     * retourne la valeur d'une clé dans la session
     *
     * Usage:
     *    echo $_SESSION['user']['infos']['name']; est équivalent à
     *    echo get('user.infos.name');
     *
     * @param string la chaîne décrivant le chemin de la valeur
     * @param array  le tableau où chercher la valeur (NE PAS SPÉCIFIER)
     * @param integer l'index de départ où chercher la clé (NE PAS SPÉCIFIER)
     *
     * @return mixed si une valeur est trouvée à la clé donnée, null sinon
     */
    public static function get($string, &$array = [], $index = 0) {

        static $keys;
        static $keys_last_index;

        if ( !is_null($string) ) {
            $array =& $_SESSION;
            $keys = explode('.', $string);
            $keys_last_index = count($keys) - 1;
        }

        if ( isset($array[$keys[$index]]) ) {
            if ( $index === $keys_last_index ) {
                return $array[$keys[$index]];
            }
            if ( is_array($array[$keys[$index]]) ) {
                return self::get(null, $array[$keys[$index]], $index + 1);
            }
        }

        return null; // valeur de retour par défaut
    }

    /**
     * retourne la valeur d'une clé dans la session en la supprimant
     *
     * Usage:
     *   - echo $_SESSION['user']['infos']['name']; unset($_SESSION['user']['infos']['name']);
     * est équivalent à
     *   - echo flashget('user.infos.name');
     *
     * @param string la chaîne décrivant le chemin de la valeur
     * @param array  le tableau où chercher la valeur (NE PAS SPÉCIFIER)
     * @param integer l'index de départ où chercher la clé (NE PAS SPÉCIFIER)
     *
     * @return mixed si une valeur est trouvée à la clé donnée, null sinon
     */
    public static function flashget($string, &$array = [], $index = 0) {

        static $keys;
        static $keys_last_index;

        if ( !is_null($string) ) {
            $array =& $_SESSION;
            $keys = explode('.', $string);
            $keys_last_index = count($keys) - 1;
        }

        if ( isset($array[$keys[$index]]) ) {
            if ( $index === $keys_last_index ) {
                $retour = $array[$keys[$index]];
                unset($array[$keys[$index]]);
                return $retour;
            }
            if ( is_array($array[$keys[$index]]) ) {
                return self::flashget(null, $array[$keys[$index]], $index + 1);
            }
        }

        return null; // valeur de retour par défaut
    }

    /**
     * écrit une valeur dans une clé de la session
     *
     * Usage:
     *    $_SESSION['user']['infos']['name'] = $valeur; est équivalent à
     *    Session::set('user.infos.name', $valeur);
     *
     * @param string la chaîne décrivant le chemin de la valeur
     * @param mixed la valeur à inscrire à la clé spécifiée
     * @param array  le tableau où chercher la valeur (NE PAS SPÉCIFIER)
     * @param integer l'index de départ où chercher la clé (NE PAS SPÉCIFIER)
     *
     * @return bool true la valeur a pu être inscrite, false sinon
     */
    public static function set($string, $valeur, &$array = [], $index = 0) {

        static $keys;
        static $keys_last_index;

        if ( !is_null($string) ) {
            $array =& $_SESSION;
            $keys = explode('.', $string);
            $keys_last_index = count($keys) - 1;
        }

        if ($index === $keys_last_index) {
            $array[$keys[$index]] = $valeur;
            return true; // en cas de succès

        } else {
            if ( isset($array[$keys[$index]]) && is_array($array[$keys[$index]]) ) {
                self::set(null, $valeur, $array[$keys[$index]], $index + 1);
            } else {
                $array[$keys[$index]] = [];
                self::set(null, $valeur, $array[$keys[$index]], $index + 1);
            }
        }

        return false; // en cas d'échéc
    }

    /**
     * détruit une clé (et donc la valeur qu'elle référençait) dans la session
     *
     * Usage:
     *    unset($_SESSION['user']['infos']['name']); est équivalent à
     *    Session::delete('user.infos.name');
     *
     * @param string la chaîne décrivant le chemin de la valeur
     * @param array  le tableau où chercher la valeur (NE PAS SPÉCIFIER)
     * @param integer l'index de départ où chercher la clé (NE PAS SPÉCIFIER)
     *
     * @return true si unset() réussit, false sinon
     */
    public static function delete($string, &$array = [], $index = 0) {

        static $keys;
        static $keys_last_index;

        if ( !is_null($string) ) {
            $array =& $_SESSION;
            $keys = explode('.', $string);
            $keys_last_index = count($keys) - 1;
        }

        if ( isset($array[$keys[$index]]) ) {
            if ( $index === $keys_last_index ) {
                unset($array[$keys[$index]]);
                return true;
            }
            if ( is_array($array[$keys[$index]]) ) {
                return self::delete(null, $array[$keys[$index]], $index + 1);
            }
        }

        return false; // valeur de retour par défaut
    }

    /* TODO: déplacer cette fonction dans une classe indépendante
     */
    public static function userIsLoggedIn()
    {
        if ( self::get('user.logged_in') === true ) {
            return true;
        }

        // par défaut, on considère l'utilisateur déconnecté
        return false;
    }

    /* TODO: déplacer cette fonction dans une classe indépendante
     */
    public static function userIsAdmin()
    {
        if ( self::get('user.statut') === '1' ) {
            return true;
        }

        // par défaut, on considère l'utilisateur n'est pas admin
        return false;
    }

    /* TODO: déplacer cette fonction dans une classe indépendante
     */
    public static function user_is_godlike()
    {
        if ( Session::get('user.pseudo') === 'Erwan' ) {
            return true;
        }

         return false;
    }
}
