<?php
/**
	Uploading the configuration for Temando
	NOTE: temando_shipment, temando_box, temando_manifest contain online data so they are not imported.
		  temando_warehouse contain warehouse location - this should be editted as well
**/

// Is the module active?
if (!Mage::getConfig()->getModuleConfig('Temando_Temando')->is('active', 'true')) {
    Mage::log("the Temando_Temando is not active, aborting configuration");
	return;
}

$installer = $this;
$installer->startSetup();

$envConfig = array(
    "default" => array(
        'temando/general/sandbox'								=>'0',
		'temando/general/client'								=>'57326',
		'temando/general/username'								=>'admin@jacklondon.com.au',
		'temando/general/password'								=>'fxjack',
		'temando/general/payment_type'							=>'Account',
		'temando/options/show_product_estimate'					=>'0',
		'temando/options/label_type'							=>'Thermal',
		'temando/options/error_process'							=>'flat',
		'temando/options/error_process_message'					=>'NULL',
		'temando/options/shipping_fee'							=>'NULL',
		'temando/checkout/delivery_options'						=>'0',
		'temando/checkout/ship_instructions'					=>'0',
		'temando/checkout/ship_comment'							=>'0',
		'temando/checkout/deliverby'							=>'0',
		'temando/checkout/allow_pobox'							=>'0',
		'temando/checkout/allow_pobox_message'					=>'NULL',
		'temando/insurance/status'								=>'optional',
		'temando/insurance/confirm_optional'					=>'N',
		'temando/insurance/confirm_mandatory'					=>'N',
		'temando/insurance/confirm_disabled'					=>'N',
		'temando/carbon/status'									=>'optional',
		'temando/footprints/status'								=>'optional',
		'temando/shipments_display/shipment_order_statuses'		=>'NULL',
		'temando/units/measure'									=>'Centimetres',
		'temando/units/weight'									=>'Kilograms',
		'temando/defaults/consolidation'						=>'2',
		'temando/defaults/packaging'							=>'9',
		'temando/defaults/fragile'								=>'0',
		'temando/defaults/length'								=>'10',
		'temando/defaults/width'								=>'10',
		'temando/defaults/height'								=>'10',
		'carriers/temando/active'								=>'1',
		'carriers/temando/title'								=>'Australia Post - eParcel',
		'carriers/temando/sallowspecific'						=>'1',
		'carriers/temando/specificcountry'						=>'AU',
		'carriers/temando/showmethod'							=>'0',
		'carriers/temando/free_shipping_enable'					=>'0',
		'carriers/temando/free_shipping_subtotal'				=>'NULL',
		'carriers/temando/specificerrmsg'						=>'This shipping method is currently unavailable. If you would like to ship using this shipping method, please contact us.',
		'carriers/temando/allowed_methods'						=>'60031'	        
    ),
    "prod" => array(
    ),
    "staging" => array(	       
    ),
    "dev" => array(
    )
);

$coreConfig = new Mage_Core_Model_Config();

// load default
foreach($envConfig["default"] as $path => $val) {
    Mage::log(sprintf("%s->%s: %s", __METHOD__, $path, $val) );
    $coreConfig->saveConfig($path, $val, 'default', 0);
}

// load env
foreach($envConfig[FactoryX_Init_Helper_Data::_getEnv()] as $path => $val) {
    Mage::log(sprintf("%s->%s: %s", __METHOD__, $path, $val) );
    $coreConfig->saveConfig($path, $val, 'default', 0);
}

// Import tables    
//	$path = Mage::getBaseDir().'/app/code/local/FactoryX/Init/sql/mysqldump/'.'temando_carrier.sql';
//	if (file_exists($path)) $installer->run(file_get_contents($path));

//	$path = Mage::getBaseDir().'/app/code/local/FactoryX/Init/sql/mysqldump/'.'temando_hscode.sql';
//	if (file_exists($path)) $installer->run(file_get_contents($path));

$path = Mage::getBaseDir().'/app/code/local/FactoryX/Init/sql/mysqldump/'.'temando_package.sql';
if (file_exists($path)) $installer->run(file_get_contents($path));

$path = Mage::getBaseDir().'/app/code/local/FactoryX/Init/sql/mysqldump/'.'temando_rule.sql';
if (file_exists($path)) $installer->run(file_get_contents($path));

$path = Mage::getBaseDir().'/app/code/local/FactoryX/Init/sql/mysqldump/'.'temando_taxes.sql';
if (file_exists($path)) $installer->run(file_get_contents($path));

$path = Mage::getBaseDir().'/app/code/local/FactoryX/Init/sql/mysqldump/'.'temando_warehouse.sql';
if (file_exists($path)) $installer->run(file_get_contents($path));

$path = Mage::getBaseDir().'/app/code/local/FactoryX/Init/sql/mysqldump/'.'temando_zone.sql';
if (file_exists($path)) $installer->run(file_get_contents($path));

$installer->endSetup();

?>