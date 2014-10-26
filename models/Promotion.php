<?php

class Promotion extends Model
{
    protected $id;
    protected $code_promo;
    protected $reduction;

    const NOT_FOUND = 'La promotion demandée n\'existe pas.';
    const INVALID_INPUT = 'Les données fournies pour la création de la promotion sont invalides ou insuffisantes.';
    const INVALID_CODE_PROMO = 'Le code promo doit être une chaîne de caractères de moins de 7 caractères.';
    const INVALID_REDUCTION = 'La réduction doit être un entier non-nul de moins de 6 chiffres.';

    public function __construct( $db, $arg )
    {
        parent::__construct($db);

        if ( is_array($arg) ) {
            $this->setPromo( $arg );

        } else {
            $value = (int) $arg;

            if ( $value ) {
                $field = 'id';
            } else {
                $value = "'" . $this->db->real_escape_string( (string) $arg ) . "'";
                $field = 'code_promo';
            }

            $sql = "SELECT * FROM promotions WHERE $field = $value;";

            $result = $this->exequery($sql);
            if ( !$result->num_rows ) {
                throw new Exception(self::NOT_FOUND);
            }

            $this->setPromo( $result->fetch_assoc() );
        }
    }

    /* accesseurs */
    public function getId() { return $this->id; }
    public function getCode_promo( $output = '' ) {
        return ( $output === 'sql' ) ? $this->db->real_escape_string($this->code_promo) : $this->code_promo;
    }
    public function getReduction() { return $this->reduction; }

    /* mutateurs */
    public function setId( $id )
    {
        $this->id = $id;
    }

    public function setCode_promo( $code )
    {
        $code = (string) $code;
        if ( $code && strlen($code) < 7 ) {
            $this->code_promo = $code;
        } else {
            throw new Exception(self::INVALID_CODE_PROMO);
        }
    }

    public function setReduction( $reduction )
    {
        $reduction = (int) $reduction;
        if ( $reduction && strlen( (string) $reduction ) < 6 ) {
            $this->reduction = $reduction;
        } else {
            throw new Exception(self::INVALID_REDUCTION);
        }
    }

    /* mutateur global */
    public function setPromo( $array )
    {
        if (
            empty( $array )
            || empty( $array['code_promo'] )
            || empty( $array['reduction'] )
        ) {
            throw new Exception(self::INVALID_INPUT);
        }

        if ( !empty( $array['id']) ) {
            $this->setId( $array['id'] );
        }

        $this->setCode_promo( $array['code_promo'] );
        $this->setReduction( $array['reduction'] );
    }
}
