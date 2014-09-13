<?php

/* Prend en charge la session de l'utilisateur à chaque instanciation d'un contrôleur */

class Session
{
    private static function parse_key($submitted_key)
    {

    }

    /**
     * Récupère des informations de la session courante
     * via un argument du type niveau0/niveau1 (soit
     * $_SESSION['niveau1']['niveau2'] )
     */
    public static function get($key)
    {
        $key = trim($key, '/');
        $key = explode('/', $key);
        $key_depth = count($key);

        if ( isset($_SESSION[$key[0]] ) ) {
            $session_key = $_SESSION[$key[0]];

            for ($i = 1; $i < $key_depth; $i++) {
                if ( isset( $session_key[$key[$i]] ) ) {
                    $session_key = $session_key[$key[$i]];
                } else {
                    break;
                }
            }

            return $session_key;
        }

        return false;
    }

    public static function set($session_key, $value)
    {
        $_SESSION[$session_key] = $value;
    }

    public static function delete($session_key)
    {
        unset($_SESSION[$session_key]);
    }

    public static function init()
    {
        // si session_id() renvoie qqch, alors c'est qu'une session est déjà en cours
        if ( session_id() === '') {
           session_start();
        }
    }

    public static function destroy()
    {
        session_destroy();
    }

    public static function userIsLoggedIn()
    {
        if ( self::get('user_logged_in') === true ) {
            return true;
        }

        // par défaut, on considère l'utilisateur déconnecté
        return false;
    }
}
