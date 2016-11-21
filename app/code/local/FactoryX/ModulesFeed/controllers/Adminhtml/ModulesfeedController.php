<?php

/**
 * Class FactoryX_ModulesFeed_Adminhtml_ModulesfeedController
 */
class FactoryX_ModulesFeed_Adminhtml_ModulesfeedController extends Mage_Adminhtml_Controller_Action
{

	/**
	 * Check the ACL permission
	 * @return mixed
	 */
	protected function _isAllowed()
	{
		return Mage::getSingleton('admin/session')->isAllowed('system/tools/modulesfeed');
	}

	/**
	 * This is the action used to display the grid
	 */
	public function indexAction()
	{
		$this->_title($this->__('System'))->_title($this->__('Tools'))->_title($this->__('Modules Details'));

		if($this->getRequest()->getParam('ajax')) {
			$this->_forward('grid');
			return;
		}

		$this->loadLayout();
		$this->_setActiveMenu('system');
		$this->_addBreadcrumb(Mage::helper('adminhtml')->__('System'), Mage::helper('adminhtml')->__('System'));
		$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Tools'), Mage::helper('adminhtml')->__('Tools'));
		$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Reports Viewer'), Mage::helper('adminhtml')->__('Modules Details'));

		$this->_addContent($this->getLayout()->createBlock('modulesfeed/adminhtml_modulesfeed', 'modulesfeed'));

		$this->renderLayout();
	}

	/**
	 * Report list action
	 */
	public function gridAction()
	{
		$this->getResponse()->setBody($this->getLayout()->createBlock('modulesfeed/adminhtml_modulesfeed_grid')->toHtml());
	}

}