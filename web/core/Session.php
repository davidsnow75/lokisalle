<?php

/* Prend en charge la session de l'utilisateur à chaque instanciation d'un contrôleur */

class Session
{
    public static function get($session_key)
    {
        if ( isset($_SESSION[$session_key]) ) {
            return $_SESSION[$session_key];
        }
    }

    public static function set($session_key, $value)
    {
        $_SESSION[$session_key] = $value;
    }

    public static function init()
    {
        // si session_id() renvoie qqch, alors c'est qu'une session est déjà en cours
        if ( session_id() === '') {
           session_start();
        }
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
