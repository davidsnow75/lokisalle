<?php

class Error extends Controller
{
    public function index()
    {
        $this->renderView('error/default_error');
    }

    public function notFound($url = null)
    {
        // si Error::notFound est appelée via /error/notfound
        if ( is_null($url) ) {
            $this->renderView('error/index');
            exit(0);
        }

        if ( is_array($url) ) {
            $url = implode('/', $url);
        }

        $data['url'] = htmlentities($url, ENT_QUOTES, "utf-8");

        $this->renderView('error/404', $data);
    }

    public function dbError()
    {

    }
}
