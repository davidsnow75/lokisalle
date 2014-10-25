<?php

class Debug
{
    protected static function log( $key, $data )
    {
        if ( DEBUG ) {

            $class = 'debug__log';

            if ( !is_scalar($data) ) {

                ob_start();
                var_dump( $data );
                $data = ob_get_clean();

                $class .= ' debug__log--compound';
            }

            Session::set('debug.' . $key, '<span class="' . $class . '">' . $data . '</span>');
        }
    }

    public static function logGlobals()
    {
        if ( !empty($_GET) ) {
            self::logGET( $_GET );
        }

        if ( !empty($_POST) ) {
            self::logPOST( $_POST );
        }
    }

    public static function logGET( $get )
    {
        self::log('get', $_GET);
    }

    public static function logPOST( $post )
    {
        self::log('post', $_POST);
    }

    public static function logURL( $url )
    {
        self::log('url', $url);
    }

    public static function logController( $controller )
    {
        self::log('controller', get_class($controller) );
    }

    public static function logAction( $action )
    {
        self::log('action', $action);
    }

    public static function logParameters( $parameters )
    {
        self::log('parameters', $parameters);
    }

    public static function logCustom( $key, $data )
    {
        if ( !in_array($key, ['get', 'post', 'url', 'controller', 'action', 'parameters']) ) {
            self::log( $key, $data );
        }
    }
}
