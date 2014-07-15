<?phpclass FactoryX_CustomReports_Block_Signedupnoorder_Grid extends Mage_Adminhtml_Block_Widget_Grid{    public function __construct()    {        parent::__construct();        $this->setId('signedupnoorderReportGrid');        $this->setDefaultSort('subscriber_subscriptiondate');        $this->setDefaultDir('desc');    }	    protected function _prepareCollection()    {			// Get the customer emails		$orderEmailsCollection = Mage::getModel('sales/order')->getCollection()->addAttributeToSelect('customer_email');		$filterOrdersEmails = array();				// Array containing the emails from the orders		foreach ($orderEmailsCollection as $orderEmail)		{			$filterOrdersEmails[] = $orderEmail->getCustomerEmail();		}	        $collection = Mage::getModel('newsletter/subscriber')->getCollection()			->addFieldToSelect(array('subscriber_id','subscriber_email','subscriber_firstname','subscriber_lastname','subscriber_subscriptiondate'))			->addFieldToFilter('subscriber_email',array('nin'=>$filterOrdersEmails));		        $this->setCollection($collection);        parent::_prepareCollection();        return $this;    }    protected function _prepareColumns()    {         $this->addColumn('subscriber_id', array(            'header'    => Mage::helper('reports')->__('Subscriber ID'),			'width'     => '50',            'index'     => 'subscriber_id'        ));		        $this->addColumn('subscriber_email', array(            'header'    => Mage::helper('reports')->__('Subscriber Email'),            'width'     => '300',            'index'     => 'subscriber_email'        ));        $this->addColumn('subscriber_firstname', array(            'header'    => Mage::helper('reports')->__('First Name'),            'width'     => '300',            'index'     => 'subscriber_firstname',        ));        $this->addColumn('subscriber_lastname', array(            'header'    => Mage::helper('reports')->__('Last Name'),            'width'     => '300',            'index'     => 'subscriber_lastname',        ));				$this->addColumn('subscriber_subscriptiondate', array(            'header'    =>Mage::helper('reports')->__('Subscription Date'),            'align'     =>'right',			'width'     => '150',			'type'      =>'datetime',            'index'     =>'subscriber_subscriptiondate'        ));        $this->addExportType('*/*/exportSignedupnoorderCsv', Mage::helper('reports')->__('CSV'));        $this->addExportType('*/*/exportSignedupnoorderExcel', Mage::helper('reports')->__('Excel'));        return parent::_prepareColumns();    }}