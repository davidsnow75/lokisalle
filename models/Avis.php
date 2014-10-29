<?php

class Avis extends Model
{
    protected $id;
    protected $commentaire;
    protected $note;
    protected $date;
    protected $salles_id;
    protected $membres_id;

    public function __construct( $db, $arg )
    {
        parent::__construct($db);

        if (is_array($arg)) {
            $this->setAvis($arg);
        } else {
            $arg = (int) $arg;
        }
    }
}
