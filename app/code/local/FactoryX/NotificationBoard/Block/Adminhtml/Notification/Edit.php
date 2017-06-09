<?php
/**
 * Who:  Alvin Nguyen
 * When: 3/02/15
 * Why:  
 */
class FactoryX_NotificationBoard_Block_Adminhtml_Notification_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     *
     */
    public function __construct()
    {
        // $this->_objectId = 'id';
        parent::__construct();
        $this->_blockGroup      = 'factoryx_notificationboard';
        $this->_controller      = 'adminhtml_notification';
        $this->_mode            = 'edit';
        $modelTitle = $this->_getModelTitle();
        $this->_updateButton('save', 'label', $this->_getHelper()->__("Save $modelTitle"));
        $this->_addButton('saveandcontinue', array(
            'label'     => $this->_getHelper()->__('Save and Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    protected function _getHelper(){
        return Mage::helper('factoryx_notificationboard');
    }

    protected function _getModel(){
        return Mage::registry('current_model');
    }

    /**
     * @return string
     */
    protected function _getModelTitle(){
        return 'Notification';
    }

    /**
     * @return mixed
     */
    public function getHeaderText()
    {
        $model = $this->_getModel();
        $modelTitle = $this->_getModelTitle();
        if ($model && $model->getId()) {
           return $this->_getHelper()->__("Edit $modelTitle (ID: {$model->getId()})");
        }
        else {
           return $this->_getHelper()->__("New $modelTitle");
        }
    }


    /**
     * Get URL for back (reset) button
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('*/*/index');
    }

    /**
     * @return mixed
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', array($this->_objectId => $this->getRequest()->getParam($this->_objectId)));
    }

    /**
     * Get form save URL
     *
     * @deprecated
     * @see getFormActionUrl()
     * @return string
     */
    public function getSaveUrl()
    {
                $this->setData('form_action_url', 'save');
                return $this->getFormActionUrl();
    }


}
