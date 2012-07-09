<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Gallery
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once JPATH_SITE.DS.'hmconfig.php';
class PhocaGalleryPath extends JObject
{
	function __construct() {}
	
	function &getInstance() {
		static $instance;
		if (!$instance) {
			$instance = new PhocaGalleryPath();
			$config = new HMConfig();
			$instance->image_abs 			= JPATH_ROOT . DS . 'images' . DS . 'phocagallery' . DS ;
			$instance->image_rel			= 'images/phocagallery/';
			$instance->avatar_abs 			= JPATH_ROOT . DS . 'images' . DS . 'phocagallery' . DS . 'avatars' . DS ;
			$instance->avatar_rel			= 'images/phocagallery/avatars/';
			$instance->image_rel_full		= JURI::base(true) . '/' . $instance->image_rel;
			$instance->image_rel_admin 		= 'administrator/components/com_phocagallery/assets/images/';
			$instance->image_rel_admin_full = JURI::base(true) . '/' . $instance->image_rel_admin;
			$instance->image_rel_front 		= 'components/com_phocagallery/assets/images/';
			$instance->image_rel_front_full = JURI::base(true) . '/' . $instance->image_rel_front;
			$instance->image_abs_front		= JPATH_ROOT . DS . 'components' . DS . 'com_phocagallery' . DS . 'assets' . DS . 'images'.DS ;
			
			for($i=1;$i<=$config->img_server_count;$i++){
				$prop = 'img_server'.$i;
				$instance->img_server_abs[]	=$config->$prop. DS;
			}
			
			for($i=1;$i<=$config->img_provider_count;$i++){
				$prop = 'img_provider'.$i;
				$instance->img_provider[]	=$config->$prop;
			}
//			$instance->server1_image_rel	=$config->img_server1_path;
//			
//			$instance->server2_image_abs	=$config->img_server2. DS;
//			$instance->server2_image_rel	=$config->img_server2_path;
		}
		return $instance;
	}

	function getPath() {
		$instance 	= &PhocaGalleryPath::getInstance();
		return $instance;
	}

}
?>