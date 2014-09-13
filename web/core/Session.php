<?php

/* Prend en charge la session de l'utilisateur */

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

    /* Retourne une valeur de la session si elle s'y trouve, sinon NULL
     * Usage: echo $_SESSION['user']['data']['id'] <=> echo Session::get('user.data.id')
     */
    public static function get($key)
    {
        $key = explode('.', $key);
        $key_depth = count($key);

        if ( isset($_SESSION[$key[0]] ) ) {
            $session_key = $_SESSION[$key[0]];

            for ($i = 1; $i < $key_depth; $i++) {
                if ( isset( $session_key[$key[$i]] ) ) {
                    $session_key = $session_key[$key[$i]];
                } else {
                    break; // on arrive en bout de chaine
                }
            }

            return $session_key;
        }

        return null;
    }

    /* Assigne une valeur à une clé de la session
     * TODO: gérer la profondeur comme pour self::get()
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /* Supprime une entrée de la session
     */
    public static function delete($key)
    {
        unset($_SESSION[$key]);
    }

    /* TODO: déplacer cette fonction dans une classe indépendante
     */
    public static function userIsLoggedIn()
    {
        if ( self::get('user_logged_in') === true ) {
            return true;
        }

        // par défaut, on considère l'utilisateur déconnecté
        return false;
    }
}
