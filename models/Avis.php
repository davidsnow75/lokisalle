<?php

class Avis extends Model
{
    protected $id;
    protected $commentaire;
    protected $note;
    protected $date;
    protected $salles_id;
    protected $membres_id;

    const NOT_FOUND = 'L\'avis demandé n\'a pas été trouvé.';
    const NOTE_FORMAT = 'La note doit être un entier compris entre 0 et 10.';
    const INVALID_COMMENTAIRE = 'Le commentaire ne doit pas être vide.';
    const INVALID_SALLES_ID = 'L\'id de la salle doit être un entier non-nul.';
    const INVALID_MEMBRES_ID = 'L\'id du membre doit être un entier non-nul.';
    const INVALID_INPUT = 'Les données fournies pour la création de l\'avis sont invalides.';

    public function __construct( $db, $arg )
    {
        parent::__construct($db);

        if (is_array($arg)) {
            $this->setAvis($arg);
        } else {
            $arg = (int) $arg;

            $result = $this->exequery("SELECT * FROM avis WHERE id=$arg;");
            if ( !$result->num_rows ) {
                throw new Exception(self::NOT_FOUND);
            }

            $this->setAvis( $result->fetch_assoc() );
        }
    }

    /* ACCESSEURS */
    public function getId() { return $this->id; }

    public function getCommentaire( $output = '' ) {
        return ( $output === 'sql' ) ? $this->db->real_escape_string( $this->commentaire ) : $this->commentaire;
    }

    public function getNote()       { return $this->note; }
    public function getDate()       { return $this->date; }
    public function getSalles_id()  { return $this->salles_id; }
    public function getMembres_id() { return $this->membres_id; }

    /* MUTATEURS */
    public function setId( $id )
    {
        $this->id = (int) $id;
    }

    public function setCommentaire( $avis )
    {
        if ( empty($avis) ) {
            throw new Exception(self::INVALID_COMMENTAIRE);
        }

        $this->commentaire = htmlentities( $avis, ENT_QUOTES, "utf-8" );
    }

    public function setNote( $note )
    {
        $note = (int) $note;
        if ( $note < 0 || $note > 10 ) {
            throw new Exception(self::NOTE_FORMAT);
        } else {
            $this->note = $note;
        }
    }

    public function setDate( $date )
    {
        $this->date = $date;
    }

    public function setSalles_id( $id )
    {
        $id = (int) $id;
        if ( $id ) {
            $this->salles_id = $id;
        } else {
            throw new Exception(self::INVALID_SALLES_ID);
        }
    }

    public function setMembres_id( $id )
    {
        $id = (int) $id;
        if ( $id ) {
            $this->membres_id = $id;
        } else {
            throw new Exception(self::INVALID_MEMBRES_ID);
        }
    }

    public function setAvis( $array )
    {
        if (
            empty( $array )
            || empty( $array['commentaire'] )
            || !isset( $array['note'] )
            || empty( $array['date'] )
            || empty( $array['salles_id'] )
            || empty( $array['membres_id'] )
        ) {
            throw new Exception(self::INVALID_INPUT);
        }

        $this->setCommentaire( $array['commentaire'] );
        $this->setNote( $array['note'] );
        $this->setDate( $array['date'] );
        $this->setSalles_id( $array['salles_id'] );
        $this->setMembres_id( $array['membres_id'] );
    }
}
