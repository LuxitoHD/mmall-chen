<?php
/**
 * @version		$Id: default.php 21726 2011-07-02 05:46:46Z infograf768 $
 * @package		Joomla.Site
 * @subpackage	mod_menu
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

// Note. It is important to remove spaces between elements.
?>
<ul id="n_list">
<?php
foreach ($list as $i => &$item) :
	$class = 'item-'.$item->id;
	if ($item->id == $active_id) {
		$class .= ' this';
	}

	if (	$item->type == 'alias' &&
			in_array($item->params->get('aliasoptions'),$path)
		||	in_array($item->id, $path)) {
		$class .= ' active';
	}
	
   $currentitemcount ++;
   if ($item->shallower or $currentitemcount == count($list)) {
      $class .= ' last ';
   }
   
   if ($lastdeeper or $currentitemcount == 1) {
      $class .= ' first ';
   } 
   
   if ($item->deeper) {
      $class .= ' deeper ';
      $lastdeeper = true;
   } else {
      $lastdeeper = false;   
   }

	if ($item->parent) {
		$class .= ' parent';
	}

	if (!empty($class)) {
		$class = ' class="'.trim($class) .'"';
	}

	echo '<li'.$class.'>';

	// Render the menu item.
	switch ($item->type) :
		case 'separator':
		case 'url':
		case 'component':
			require JModuleHelper::getLayoutPath('mod_menu', 'default_'.$item->type);
			break;

		default:
			require JModuleHelper::getLayoutPath('mod_menu', 'default_url');
			break;
	endswitch;

	echo '<i class="vline"></i></li>';
endforeach;
?>
	<li class="logo"><a id="n_sample" href="#"><img title="" alt="" src="/mmall/templates/fjt007_j25/images/nav_logo.png"></a></li>
</ul>
