<?php

class AvisManager extends Model
{
    protected $avis;

    const INSERT_SUCCESS = 'L\'avis a bien été enregistré.';
    const INSERT_FAILURE = 'L\'avis n\'a pas pu être enregistré.';
    const ONE_AVIS_PER_MEMBRE = 'Un membre ne peut pas donner son avis plusieurs fois sur une même salle.';
    const SALLE_NOT_FOUND = 'L\'avis renvoie à une salle inexistante.';

    public function __construct( $db, Avis $avis)
    {
        parent::__construct($db);
        $this->avis = $avis;
    }

    /*=======================================================================*/
    /*                    Méthode principale de AvisManager                  */
    /*=======================================================================*/
    protected function AvisToDb( $action )
    {
        switch ( $action ) {
            case 'insert':
                $this->checkAvis();

                $sql = "INSERT INTO avis
                        VALUES ('',
                                '" . $this->avis->getCommentaire('sql') . "',
                                " . $this->avis->getNote()             . ",
                                " . $this->avis->getDate()             . ",
                                " . $this->avis->getSalles_id()        . ",
                                " . $this->avis->getMembres_id()       . ");";
                break;

            default: $sql = false;
        }

        return $sql ? $this->exequery($sql) : false;
    }

    /*=======================================================================*/
    /*                      Alias pour l'utilisation de AvisToDb()           */
    /*=======================================================================*/
    public function insertAvis()
    {
        if ( !$this->AvisToDb('insert') ) {
            throw new Exception(self::INSERT_FAILURE);
        } else {
            return self::INSERT_SUCCESS;
        }
    }

    /*=======================================================================*/
    /*                      Vérifications avant opérations                   */
    /*=======================================================================*/

    public function checkSalle()
    {
        $sql = "SELECT id FROM salles WHERE id = " . $this->avis->getSalles_id() . ";";
        if ( !$this->exequery($sql)->num_rows ) {
            throw new Exception(self::SALLE_NOT_FOUND);
        }
    }

    public function checkNoDuplicate()
    {
        $sql = "SELECT id
                FROM avis
                WHERE salles_id = " . $this->avis->getSalles_id() . "
                    AND membres_id = " . $this->avis->getMembres_id() . ";";

        if ( $this->exequery($sql)->num_rows ) {
            throw new Exception(self::ONE_AVIS_PER_MEMBRE);
        }
    }

    public function checkAvis()
    {
        $this->checkSalle();
        $this->checkNoDuplicate();
    }
}
