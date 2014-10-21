<?php

class Promotion extends Model
{
    protected $id;
    protected $code_promo;
    protected $reduction;

    const NOT_FOUND = 'La promotion demandée n\'existe pas.';
    const INVALID_INPUT = 'Les données fournies pour la création de la promotion sont invalides ou insuffisantes.';
    const INVALID_CODE_PROMO = 'Le code promo doit être une chaîne de caractères de moins de 7 caractères.';
    const INVALID_REDUCTION = 'La réduction doit être un entier non-nul.';


    public function __construct( $db, $arg )
    {
        parent::__construct($db);

        if ( is_array($arg) ) {

            $createPromoError = $this->setPromo( $arg );
            if ( $createPromoError ) {
                throw new Exception( $createPromoError );
            }

        } else {

            $arg = (int) $arg;
            $sql = "SELECT * FROM promotions WHERE id='" . $arg . "';";

            $result = $this->exequery($sql);
            if ( !$result->num_rows ) {
                throw new Exception(self::NOT_FOUND);
            }

            $this->id = $arg;
            $this->setPromo( $result->fetch_assoc() );
        }
    }

    public function setCode_promo( $code )
    {
        $code = (string) $code;
        if ( $code && strlen($code) < 7 )
        {
            $this->code_promo = $code;
        } else {
            throw new Exception(self::INVALID_CODE_PROMO);
        }
    }

    public function setReduction( $reduction )
    {
        $reduction = (int) $reduction;
        if ( $reduction && strlen( (string) $reduction ) < 6 )
        {
            $this->reduction = $reduction;
        } else {
            throw new Exception(self::INVALID_REDUCTION);
        }
    }

    public function setPromo( $array )
    {
        if (
            empty( $array )
            || empty( $array['code_promo'] )
            || empty( $array['reduction'] )
        ) {
            return self::INVALID_INPUT;
        }

        try {
            $this->setCode_promo( $array['code_promo'] );
            $this->setReduction( $array['reduction'] );
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
