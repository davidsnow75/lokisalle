<?php

class ErrorController extends Controller
{
    public function index()
    {
        $this->renderView('error/default_error');
    }

    public function notFound($url = null)
    {
        // si Error::notFound est appelée via /error/notfound
        if ( is_null($url) ) {
            header('location: /');
            exit(0);
        }

        if ( is_array($url) ) {
            $url = implode('/', $url);
        }

        $data['url'] = htmlentities($url, ENT_QUOTES, "utf-8");

        $this->renderView('error/404', $data);
    }

    public function db_error($error_context = null) {

        if ( $error_context == 'registration' ) {
            $data['error'] = Session::get('db_error');
            Session::delete('db_error');
            $this->renderView('error/db_error', $data);
        } else {
            header('location: /');
            exit(0);
        }
    }
}
