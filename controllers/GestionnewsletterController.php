<?php

class GestionnewsletterController extends AdminController
{
    public function index()
    {
        $data['nbAbonne'] = $this->loadModel('NewsletterManager')->countAbo();
        $data['msg'] = Session::flashget('events.gestionnewsletter.msg');
        $this->renderView('gestionnewsletter/index', $data);
    }

    public function envoyer()
    {
        if (
            empty($_POST['expediteur'])
            || empty($_POST['sujet'])
            || empty($_POST['message'])
        ) {
            $this->quit('gestionnewsletter', 'events.gestionnewsletter.msg', 'L\'expéditeur, le sujet et le message sont obligatoires.');
        }

        $insertMsg = $this->loadModel('NewsletterManager')->insert( $_POST );

        if ( $insertMsg ) {
            $this->quit('gestionnewsletter', 'events.gestionnewsletter.msg', 'La newsletter a bien été envoyée !');
        } else {
            $this->quit('gestionnewsletter', 'events.gestionnewsletter.msg', 'Une erreur s\'est produite lors de la tentative d\'envoi de la newsletter');
        }
    }
}
