<?php
/*
 * @package		Joomla.Framework
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 *
 * @component Phoca Component
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2 or later;
 */
defined('_JEXEC') or die();
phocagalleryimport('phocagallery.tag.tag');

class JFormFieldPhocaTags1 extends JFormField
{
	protected $type 		= 'PhocaTags1';

	protected function getInput() {
		
		$id = (int) $this->form->getValue('id');

		$activeTags = array();
		if ((int)$id > 0) {
			$activeTags	= PhocaGalleryTag::getTags1($id, 1);
		}
		return PhocaGalleryTag::getAllTagsSelectBox($this->name.'[]', $this->id, $activeTags, NULL,'id' );
	}
}
?>