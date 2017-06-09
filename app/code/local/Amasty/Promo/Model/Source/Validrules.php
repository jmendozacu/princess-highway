<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2016 Amasty (https://www.amasty.com)
 * @package Amasty_Promo
 */

class Amasty_Promo_Model_Source_Validrules
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = array (
            0 => 'Current Product Only',
            1 => 'Whole Shopping Cart Content'
        );

        return $options;
    }

}
