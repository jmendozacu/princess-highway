<?php
/**
 * FactoryX_StoreLocator extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   FactoryX
 * @package    FactoryX_StoreLocator
 * @copyright
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * @category   FactoryX
 * @package    FactoryX_StoreLocator
 * @author
 */
class FactoryX_StoreLocator_Block_Adminhtml_Location extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     *
     */
    public function __construct()
    {
        $this->_blockGroup = 'ustorelocator';
        $this->_controller = 'adminhtml_location';
        $this->_headerText = Mage::helper('ustorelocator')->__('Manage Store Locations');
        $this->_addButtonLabel = Mage::helper('ustorelocator')->__('Add New Location');
        parent::__construct();
    }
}