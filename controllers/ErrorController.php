<?php

class ErrorController extends Controller
{
    public function index()
    {
        // on vérifie que la méthode a été lancée par l'application elle-même
        if ( Session::flashget('events.error.default_error') ) {
            $this->renderView('error/default_error');
        } else {
            header('location: /');
            exit(0);
        }
    }

    public function notFound()
    {
        if ( Session::get('events.error.notfound_url') ) {

            $url = Session::flashget('events.error.notfound_url');

            if ( is_array($url) ) {
                $url = implode('/', $url);
            }

            $data['url'] = htmlentities($url, ENT_QUOTES, "utf-8");

            $this->renderView('error/404', $data);

        } else {
            header('location: /');
            exit(0);
        }
    }

    public function db_error()
    {
        if ( Session::get('events.error.db_error') ) {
            $data['error'] = Session::flashget('events.error.db_error');
            $this->renderView('error/db_error', $data);
        } else {
            header('location: /');
            exit(0);
        }
    }
}
