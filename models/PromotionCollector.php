<?php

class PromotionCollector extends ItemCollector
{
    private $fields = 'promotions.id         AS promoId,
                       promotions.code_promo AS promoCode,
                       promotions.reduction  AS promoReduction';

    public function __construct($db)
    {
        parent::__construct($db);
        $this->fields = str_replace( ["\r", "\n"], '', $this->fields );
    }

    public function getPromotions( $ids = [], $fields = false )
    {
        if ( !$fields ) {
            $fields = $this->fields;
        }
        return $this->getItems('promotions', $ids, $fields);
    }
}
