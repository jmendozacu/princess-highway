<?php

$installer = $this;
$installer->startSetup();
	
// Add a thank_you_image_url column to the contests table 
$installer
	->getConnection()
	->addColumn(
		$this->getTable('contests/contest'), 'thank_you_image_url', 'varchar(255) default NULL'
	);
	
$installer->endSetup();