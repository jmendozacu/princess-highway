<?php

/**
 * Class FactoryX_ShippedFrom_Model_Orders
 */
class FactoryX_ShippedFrom_Model_Orders extends Mage_Core_Model_Abstract
{
    /**
     *
     */
    protected function _construct()
    {
        $this->_init('shippedfrom/orders', 'order_id');
    }
}