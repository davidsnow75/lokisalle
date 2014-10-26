<?php

class PromotionManager extends Model
{
    protected $promotion;

    const INSERT_SUCCESS = 'La promotion a bien été enregistrée.';
    const UPDATE_SUCCESS = 'La promotion a bien été modifiée.';
    const DELETE_SUCCESS = 'La promotion a bien été supprimée.';
    const INSERT_FAILURE = 'La promotion n\'a pas pu être enregistrée.';
    const UPDATE_FAILURE = 'La promotion n\'a pas pu être mise à jour.';
    const DELETE_FAILURE = 'La promotion n\'a pas pu être supprimée.';
    const PROMO_EXISTS   = 'Ce code promo est déjà utilisé par une autre promotion.';
    const INVALID_UPDATE_INPUT = 'La promotion n\'a pas pu être mise à jour à cause de données invalides.';

    public function __construct($db, Promotion $promotion)
    {
        parent::__construct($db);
        $this->promotion = $promotion;
    }

    /* MÉTHODE PRINCIPALE */
    protected function PromotionToDb( $action )
    {
        switch ($action) {
            case 'insert':
                $this->checkCodePromoUnique();

                $sql = "INSERT INTO promotions
                        VALUES ('',
                                '" . $this->promotion->getCode_promo('sql') . "',
                                '" . $this->promotion->getReduction()  . "');";
                break;

            case 'update':
                $this->checkCodePromoUnique();

                $sql = "UPDATE promotions
                        SET code_promo = '" . $this->promotion->getCode_promo('sql') . "',
                            reduction = '"  . $this->promotion->getReduction()  . "'
                        WHERE id = '" . $this->promotion->getId() . "';";
                break;

            case 'delete':
                $sql = "DELETE FROM promotions WHERE id = '" . $this->promotion->getId() . "';";
                break;

            default: $sql = false;
        }

        return $sql ? $this->exequery($sql) : false;
    }

    /* MÉTHODES ALIAS */
    public function insertPromotion()
    {
        if ( !$this->PromotionToDb('insert') ) {
            throw new Exception(self::INSERT_FAILURE);
        }
        return self::INSERT_SUCCESS;
    }

    public function updatePromotion( $modifs )
    {
        $this->alterPromotion($modifs);

        if ( !$this->PromotionToDb('update') ) {
            throw new Exception(self::UPDATE_FAILURE);
        }
        return self::UPDATE_SUCCESS;
    }

    public function deletePromotion()
    {
        if ( !$this->PromotionToDb('delete') ) {
            throw new Exception(self::DELETE_FAILURE);
        }
        // à en croire http://php.net/manual/fr/language.oop5.cloning.php
        // cela devrait suffir à supprimer l'objet (interne et externe)
        unset( $this->promotion );

        return self::DELETE_SUCCESS;
    }

    /* MÉTHODES SPÉCIFIQUES */
    public function checkCodePromoUnique()
    {
       $sql = "SELECT id FROM promotions WHERE code_promo = '" . $this->promotion->getCode_promo('sql') . "';";
       if ( $this->exequery($sql)->num_rows ) {
           throw new Exception(self::PROMO_EXISTS);
       }
    }

    public function checkModifications( $modifs )
    {
        if ( !is_array($modifs) ) {
            throw new Exception(self::INVALID_UPDATE_INPUT);
        }

        $champs_valables = ['code_promo', 'reduction'];

        foreach ($modifs as $modif_cle => $modif) {
            if ( !in_array( $modif_cle, $champs_valables, true ) || !is_scalar( $modif ) ) {
                unset( $modifs[$modif_cle] );
            }
        }

        if ( empty($modifs) ) {
            throw new Exception(self::INVALID_UPDATE_INPUT);
        }

        return $modifs;
    }

    public function alterPromotion( $modifs )
    {
        $modifs = $this->checkModifications( $modifs );

        foreach ($modifs as $modif_key => $modif) {
            call_user_func( [$this->promotion, 'set' . ucfirst($modif_key)], $modif );
        }
    }
}
