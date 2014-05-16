-- MySQL dump 10.13  Distrib 5.5.33, for osx10.6 (i386)
--
-- Host: localhost    Database: shopprinc_1_8_1_0
-- ------------------------------------------------------
-- Server version	5.5.33

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cms_block`
--

DROP TABLE IF EXISTS `cms_block`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_block` (
  `block_id` smallint(6) NOT NULL AUTO_INCREMENT COMMENT 'Block ID',
  `title` varchar(255) NOT NULL COMMENT 'Block Title',
  `identifier` varchar(255) NOT NULL COMMENT 'Block String Identifier',
  `content` mediumtext COMMENT 'Block Content',
  `creation_time` timestamp NULL DEFAULT NULL COMMENT 'Block Creation Time',
  `update_time` timestamp NULL DEFAULT NULL COMMENT 'Block Modification Time',
  `is_active` smallint(6) NOT NULL DEFAULT '1' COMMENT 'Is Block Active',
  PRIMARY KEY (`block_id`)
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8 COMMENT='CMS Block Table';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_block`
--
-- WHERE:  identifier not like '%pronav%'

LOCK TABLES `cms_block` WRITE;
/*!40000 ALTER TABLE `cms_block` DISABLE KEYS */;
INSERT INTO `cms_block` VALUES (1,'Footer Links','footer_links','<ul>\r\n<li><a href=\"{{store direct_url=\"about-magento-demo-store\"}}\">About Us</a></li>\r\n<li><a href=\"{{store direct_url=\"customer-service\"}}\">Customer Service</a></li>\r\n<li class=\"last privacy\"><a href=\"{{store direct_url=\"privacy-policy-cookie-restriction-mode\"}}\">Privacy Policy</a></li>\r\n</ul>','2013-12-12 23:18:45','2013-12-12 23:18:45',1),(2,'Cookie restriction notice','cookie_restriction_notice_block','<p>This website requires cookies to provide all of its features. For more information on what data is contained in the cookies, please see our <a href=\"{{store direct_url=\"privacy-policy-cookie-restriction-mode\"}}\">Privacy Policy page</a>. To accept cookies from this site, please click the Allow button below.</p>','2013-12-12 23:18:45','2013-12-12 23:18:45',1),(14,'cta middle','cta-middle','<!-- template sinle CTA -->\r\n<div class=\"cta-one-column\">\r\n   <img src=\"/skin/frontend/default/princess/images/media/11_go_hp_1.jpg\" alt=\"summer\" width=\"940\" />\r\n</div>\r\n\r\n\r\n<!-- template 2 CTA -->\r\n<div class=\"cta-two-column\">\r\n   <div class=\"cta-one\">\r\n      <img src=\"/skin/frontend/default/princess/images/media/calltoaction/cta03-subscribe.jpg\" alt=\"Subscribe\" /></div>\r\n   <div class=\"cta-two\">\r\n      <img src=\"/skin/frontend/default/princess/images/media/calltoaction/cta02-endofseasonsale.jpg\" alt=\"End of season sale\" /></div>\r\n</div>\r\n\r\n<!-- template 3 CTA -->\r\n<!--\r\n<div class=\"cta-three-column\">\r\n   <div class=\"cta-one\">\r\n      <img src=\"/skin/frontend/default/princess/images/media/calltoaction/cta03-subscribe.jpg\" alt=\"Subscribe\" />\r\n   </div>\r\n   <div class=\"cta-two\">\r\n      <img src=\"/skin/frontend/default/princess/images/media/calltoaction/cta02-endofseasonsale.jpg\" alt=\"End of season sale\" />\r\n   </div>\r\n   <div class=\"cta-three\">\r\n      <img src=\"/skin/frontend/default/princess/images/media/calltoaction/cta02-endofseasonsale.jpg\" alt=\"End of season sale\" /></div>\r\n</div>\r\n-->','2013-12-23 02:36:16','2014-05-14 15:59:18',0),(15,'Featured Products','featuredproducts','<!-- This code doesn\'t change. To add featured products to the homepage simply add them into the \'featured\' category -->\r\n{{block type=\"catalog/product_list\" category_id=\"45\" template=\"catalog/product/featured-products.phtml\"}}','2013-12-23 02:39:06','2014-05-14 15:58:57',0),(16,'cta bottom','cta-bottom','<!-- template sinle CTA -->\r\n\r\n<div class=\"cta-one-column\">\r\n   <img src=\"/skin/frontend/default/princess/images/media/calltoaction/cta-spring13-fullwidth.jpg\" alt=\"Princess Highway Spring 2013\" />\r\n</div>\r\n\r\n\r\n<!-- template 2 CTA -->\r\n<div class=\"cta-two-column\">\r\n   <div class=\"cta-one\">\r\n      <img src=\"/skin/frontend/default/princess/images/media/calltoaction/cta03-subscribe.jpg\" alt=\"Subscribe\" /></div>\r\n   <div class=\"cta-two\">\r\n      <img src=\"/skin/frontend/default/princess/images/media/calltoaction/cta02-endofseasonsale.jpg\" alt=\"End of season sale\" /></div>\r\n</div>\r\n\r\n<!-- template 3 CTA -->\r\n\r\n<div class=\"cta-three-column\">\r\n   <div class=\"cta-one\">\r\n      <img src=\"/skin/frontend/default/princess/images/media/calltoaction/cta03-subscribe.jpg\" alt=\"Subscribe\" />\r\n   </div>\r\n   <div class=\"cta-two\">\r\n      <img src=\"/skin/frontend/default/princess/images/media/calltoaction/cta02-endofseasonsale.jpg\" alt=\"End of season sale\" />\r\n   </div>\r\n   <div class=\"cta-three\">\r\n      <img src=\"/skin/frontend/default/princess/images/media/calltoaction/cta02-endofseasonsale.jpg\" alt=\"End of season sale\" /></div>\r\n</div>\r\n','2013-12-23 02:40:07','2014-05-14 15:58:40',0),(17,'Nav CTA Sale','nav-cta-sale','<img src=\"/skin/frontend/default/princess/images/media/calltoaction/navcta-advert-002.jpg\" alt=\"Princess Highway Spring 2013\" width=\"460\" height=\"100\" />','2013-12-23 02:44:34','2014-02-05 04:00:22',1),(18,'Nav CTA Accessories','nav-cta-accessories','<img src=\"/skin/frontend/default/princess/images/media/calltoaction/navcta-advert-002.jpg\" alt=\"Gorman Spring 2013\" />','2013-12-23 03:38:05','2013-12-23 03:38:05',1),(19,'Nav CTA New Arrivals','nav-cta-new-arrivals','<img src=\"/skin/frontend/default/princess//images/media/calltoaction/navcta-advert-002.jpg\" alt=\"Gorman Spring 2013\" />','2013-12-23 03:38:29','2013-12-23 04:04:20',1),(20,'Nav CTA Clothing','nav-cta-clothing','<img src=\"/skin/frontend/default/princess/images/media/calltoaction/navcta-advert-002.jpg\" alt=\"Gorman Spring 2013\" />','2013-12-23 03:38:53','2013-12-23 03:38:53',1),(21,'Nav CTA Summer Season Look','nav-cta-summer-season-look','<img src=\"/skin/frontend/default/princess/images/media/calltoaction/navcta-advert-002.jpg\" alt=\"Gorman Spring 2013\" />','2013-12-23 03:39:40','2013-12-27 01:39:04',1),(22,'Nav CTA Gift Cards','nav-cta-gift-cards','<img src=\"/skin/frontend/default/princess/images/media/calltoaction/navcta-advert-002.jpg\" alt=\"Princess Highway Spring 2013\" />','2013-12-23 03:41:07','2013-12-23 04:04:43',1),(23,'Nav CTA Bags','nav-cta-bags','<img src=\"/skin/frontend/default/princess/images/media/calltoaction/navcta-advert-002.jpg\" alt=\"Gorman Spring 2013\" />','2013-12-23 03:41:52','2013-12-27 01:41:01',1),(24,'Nav CTA Best Sellers','nav-cta-best-sellers','<img src=\"/skin/frontend/default/princess/images/media/calltoaction/navcta-advert-002.jpg\" alt=\"Princess Highway Spring 2013\" />','2013-12-23 03:42:43','2013-12-23 03:42:43',1),(25,'Email Header Block','email-header','<body style=\"text-align: -webkit-center;color:#616161; font: 13px century gothic, sans-serif;\">\r\n<center>\r\n	<div id=\"main\" style=\"max-width:980px\">\r\n		<div id=\"border\" style=\"border:10px solid #AC6FF2;padding:10px\">\r\n			<div id=\"logo\" height=\"80px\">\r\n				<a href=\"{{store url=\"\"}}\"><img src=\"{{skin url=\"images/logo_email.png\" _area=\'frontend\' _theme=\'princess\'}}\" alt=\"{{var store.getFrontendName()}}\" border=\"0\"/></a>\r\n			</div>\r\n			<div class=\"nav-container\" style=\"align:center; left:135px; height:29px; text-align:center; margin:0 0 15px;  z-index:998\">\r\n				<center>\r\n					<table id=\"nav\" style=\"width:800px; font-family: century gothic, sans-serif; font-size:10px\"><tr>\r\n						 <td style=\"height:24px;color:#808080; font: 13px century gothic, sans-serif;\"><a style=\"padding:2px 7px; display:block; text-decoration:none; text-transform:uppercase; color:#808080\" href=\"{{store url=\"\"}}summer-season-look.html\">Summer Season Look</a></td>\r\n						<td style=\"height:24px;color:#808080; font: 13px century gothic, sans-serif;\"><a style=\"padding:2px 7px; display:block; text-decoration:none; text-transform:uppercase; color:#808080\" href=\"{{store url=\"\"}}new-arrivals.html\">New Arrivals</a></td>\r\n						<td style=\"height:24px;color:#808080; font: 13px century gothic, sans-serif;\"><a style=\"padding:2px 7px; display:block; text-decoration:none; text-transform:uppercase; color:#808080\" href=\"{{store url=\"\"}}clothing.html\">Clothing</a></td>\r\n						<td style=\"height:24px;color:#808080; font: 13px century gothic, sans-serif;\"><a style=\"padding:2px 7px; display:block; text-decoration:none; text-transform:uppercase; color:#808080\" href=\"{{store url=\"\"}}accessories.html\">Accessories</a></td>\r\n						<td style=\"height:24px;color:#808080; font: 13px century gothic, sans-serif;\"><a style=\"padding:2px 7px; display:block; text-decoration:none; text-transform:uppercase; color:#808080\" href=\"{{store url=\"\"}}bags.html\">Bags</a></td>\r\n						<td style=\"height:24px;color:#808080; font: 13px century gothic, sans-serif;\"><a style=\"padding:2px 7px; display:block; text-decoration:none; text-transform:uppercase; color:#808080\" href=\"{{store url=\"\"}}gift-cards.html\">Gift Cards</a></td>\r\n						<td style=\"height:24px;color:#808080; font: 13px century gothic, sans-serif;\"><a style=\"padding:2px 7px; display:block; text-decoration:none; text-transform:uppercase; color:#808080\" href=\"{{store url=\"\"}}best-sellers.html\">Best Sellers</a></td>\r\n						<td style=\"height:24px;color:#808080; font: 13px century gothic, sans-serif;\" class=\'sale\'><a style=\"padding:2px 7px; display:block; text-decoration:none; text-transform:uppercase; color:#616161;font-size: 15px; font-weight: bold\" href=\"{{store url=\"\"}}sale.html\">Sale</a></td>	            \r\n					</tr></table>\r\n				</center>\r\n			</div>','2014-01-06 01:42:33','2014-01-09 05:02:31',1),(26,'Email Style','email-style','td,th { color:#808080; font: 13px century gothic, sans-serif; }\r\nth { font: 14px century gothic, sans-serif; }\r\n#nav td a:hover { color:#9C5FE8; text-decoration:none; }\r\n#nav td a:active { color:#808080; background-color:#fff; text-decoration:none; }\r\n#thankyou{color:#AC6FF2}','2014-01-06 01:43:49','2014-01-09 03:51:00',1),(27,'Email Footer Block','email-footer','		</div>\r\n	</div>\r\n</center>\r\n</body>','2014-01-06 01:44:18','2014-01-06 01:44:18',1),(28,'Email Header Block','email-header-simple','<body style=\"text-align: -webkit-center;color:#808080; font: 13px century gothic, sans-serif;\">\r\n<center>\r\n	<div id=\"main\" style=\"max-width:980px\"><div>\r\n','2014-01-06 01:44:52','2014-01-09 03:48:50',1),(29,'Email Special Offer','email-special-offer','<div style=\"background: none repeat scroll 0 0 #AC6FF2; border: 2px dashed #9C5FE8; margin-bottom: 10px; padding: 10px; text-align:center;\">\r\nYou\'re in for the Monday Happy Hour! Please this special promotion code \"<b>SP-YZVGS-{{var order.increment_id}}</b>\" to get $10 off your next purchase. Please wait up to 24 hours before this code is active.\r\n</div>\r\n','2014-01-06 01:45:18','2014-01-09 03:49:09',1),(30,'Email On Sale Block - Sales','email-sale-message','{{block type=\"cms/block\" block_id=\"sale-message\"}} View our Shipping & Delivery terms <a href=\"{{config path=\"web/unsecure/base_url\"}}/shipping-delivery.html \">here</a>.','2014-01-06 01:46:45','2014-01-06 01:46:45',1),(31,'Sale Message','sale-message','<strong>Please note</strong> that during <b>SALE</b> periods orders may take an extra 3-4 days to dispatch on top of normal dispatch times.\r\n\r\n\r\n','2014-01-06 01:47:16','2014-01-06 01:47:16',1),(32,'Support Message','support-message','If you have any questions about your order please contact us at <a href=\"mailto:{{config path=\'trans_email/ident_sales/email\'}}\" style=\"color:#AC6FF2;\">{{config path=\'trans_email/ident_sales/email\'}}</a> or call us on {{config path=\"general/store_information/phone\"}} Monday to Friday from 9am to 6pm & Saturday to Sunday from 10am to 5pm AEST.','2014-01-09 03:52:26','2014-01-09 03:52:26',1),(33,'Promotion Email Block','promotion-email-block','<!-- LINK AREA -->\r\n<center><a href=\"{{config path=\"web/unsecure/base_url\"}}sale.html\">\r\n<img src=\"{{config path=\"web/unsecure/base_url\"}}skin/frontend/default/princess/images/media/24_go_midseason_signature.png\" alt=\"END OF SEASON SALE\" />\r\n</a></center>\r\n','2014-01-09 03:54:48','2014-01-09 05:06:03',1),(34,'Subscription Page Right Image','subscription-right-img','<img src=\"/skin/frontend/default/princess/images/media/subscription-right-img.jpg\" alt=\"\" />','2014-01-09 05:37:38','2014-01-09 05:41:05',1);
/*!40000 ALTER TABLE `cms_block` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-16 12:00:18
