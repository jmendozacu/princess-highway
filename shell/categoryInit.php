<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Shell
 * @copyright   Copyright (c) 2009 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

require_once 'abstract.php';

/**
 * Magento Compiler Shell Script
 *
 * @category    Mage
 * @package     Mage_Shell
 * @author      Alvin Nguyen <alvin@factoryx.com.au>
 */
class FactoryX_CategoryInit extends Mage_Shell_Abstract
{
    /**
     * Run script
     *
     */
    public function run()
    {
    	try {
    	
            // GET TOP CATEGORIES
            $categories = Mage::getModel('catalog/category')->getCollection()
                            ->addAttributeToFilter('level', array('eq'=>2))
                            ->addAttributeToFilter('is_active', array('eq'=>1))
                            ->addAttributeToFilter('include_in_menu', array('eq'=>1))
                            ->load();
            $sql = '';
            foreach ($categories as $id => $category) {
                $fullcategory = Mage::getModel('catalog/category')->load($category->getId());
                echo $fullcategory->getId() . " ". $fullcategory->getParentId() ." ". $fullcategory->getName()  ." " . $fullcategory->getUrlPath() .  "\n";

                // Create Block for the nav
                $block = Mage::getModel('cms/block');
                $block->setTitle('Pronav - '.$fullcategory->getName());
                $block->setIdentifier('pronav_'.$fullcategory->getId());
                $block->setStores(array(array(0)));
                $block->setIsActive(1);
                $block->setContent('<div class="row">
                        <div class="span12">
                        <table class="pronav-sub-menu">
                        <tr>
                        <td>
                        <div class="sub-category-menu">
                           <ul>
                                {{widget type="pronav/category_widget_subcategories_list" levels="1" columns="1" thumbnail_images="No" category_images="No" selected_cat="Yes" template="pronav/items/widget/link/subcategories/list.phtml" id_path="category/'.$fullcategory->getId().'"}}
                           </ul>
                        </div>
                        </td>
                        <td>
                             <div class="menu-promo">
                                   <!-- SETUP YOUR PIC HERE -->
                                   <a href="#small-promo"></a>
                                   <!-- END PIC SETUP -->
                             </div>
                        </td>
                        </tr>
                        </table>
                        </div>
                        </div>');
                $block->save();

                echo $block->getId()."\n";
                $pronav = Mage::getModel('pronav/pronav');
                $pronav_data = array(
                        'name' => $fullcategory->getName(),
                        'url_key' => $fullcategory->getUrlPath(),
                        'i_index' => $fullcategory->getPosition(),
                        'store_id' => 0,
                        'static_block' => $block->getId(),
                        'link' => 1,
                        'sub_position' => 1,
                        'sub_start' => 1,
                        'no_follow' => 1,
                        'responsive' => 1,
                        'status' => 1
                    );
                $pronav->setData($pronav_data);
                $pronav->save();

            }
	    }
        catch(Exception $e) {
            var_dump($e);
        }
    	
    }

    public function testEmailTemplate(){

        // Run the email import
        shell_exec('mysql -uprincess_highway -pszDFhSTKo3jlLq27ZCYO --host=rds.stage.int.aws.factoryx.com.au princess_highway < /var/www/magento/scripts/core_email_template.sql');
        shell_exec('mysql -uprincess_highway -pszDFhSTKo3jlLq27ZCYO --host=rds.stage.int.aws.factoryx.com.au princess_highway < /var/www/magento/scripts/cms_block_email.sql');
       /*
        $emailTemplates = Mage::getModel('core/email_template')->getCollection();
        foreach ($emailTemplates as $emailTemplate) {
            $templateId = $emailTemplate->getId();$storeId = 0;
            $emailTemplate = Mage::getModel('core/email_template')->load($templateId);
            $emailTemplate->setSenderEmail(Mage::getStoreConfig('trans_email/ident_general/email', $storeId));
            $emailTemplate->setSenderName(Mage::getStoreConfig('trans_email/ident_general/name', $storeId));
            $emailTemplate->send('alvin@factoryx.com.au','Alvin Nguyen');
        }
       */
    }
}

// DANGER!!! THIS WILL CLEAR THE CMS TABLE
// DANGER!!! THIS WILL CLEAR THE EMAIL TABLE

$shell = new FactoryX_CategoryInit();
$shell->testEmailTemplate();
$shell->run();

