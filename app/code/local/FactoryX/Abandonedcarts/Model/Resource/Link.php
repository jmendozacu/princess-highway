<?php

/**
 * Class FactoryX_Abandonedcarts_Model_Resource_Link
 */
class FactoryX_Abandonedcarts_Model_Resource_Link extends Mage_Core_Model_Mysql4_Abstract
{

    protected function _construct()
    {
        $this->_init('abandonedcarts/link', 'link_id');
    }

}