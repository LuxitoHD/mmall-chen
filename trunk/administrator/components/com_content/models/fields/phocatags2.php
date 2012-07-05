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

class JFormFieldPhocaTags2 extends JFormField
{
	protected $type 		= 'PhocaTags2';

	protected function getInput() {
		
		$id = (int) $this->form->getValue('id');

		$activeTags = array();
		if ((int)$id > 0) {
			$activeTags	= $this->getTags2($id, 1);
		}
		return $this->getAllTagsSelectBox($this->name.'[]', $this->id, $activeTags, NULL,'id' );
	}
	
	public function getTags2($imgId, $select = 0) {
	
		$db =& JFactory::getDBO();
		
		if ($select == 1) {
			$query = 'SELECT r.tagid';
		} else {
			$query = 'SELECT a.*';
		}
		$query .= ' FROM #__phocagallery_tags AS a'
				//.' LEFT JOIN #__phocagallery AS f ON f.id = r.imgid'
				.' LEFT JOIN #__phocagallery_tags_articles_ref AS r ON a.id = r.tagid'
			    .' WHERE r.imgid = '.(int) $imgId;
		$db->setQuery($query);
		

		if (!$db->query()) {
			echo PhocaGalleryException::renderErrorInfo('Database Error: Getting Selected Tags - Check "#__phocagallery_tags" or "#__phocagallery_tags_ref" table in your database.');
			return false;
		}
		if ($select == 1) {
			$tags = $db->loadResultArray();
		} else {
			$tags = $db->loadObjectList();
		}	
	
		return $tags;
	}
	
	public function getAllTagsSelectBox($name, $id, $activeArray, $javascript = NULL, $order = 'id' ) {
		$db =& JFactory::getDBO();
		
		$query1 = 'SELECT a.id AS value, a.title AS text'
				.' FROM #__phocagallery_tags AS a where a.is_cy=\'是\''
				. ' ORDER BY '. $order;
		$db->setQuery($query1);
		
		$tags1 = $db->loadObjectList();
		
		$html = array();

		// Initialize some field attributes.
		$class = $this->element['class'] ? ' class="checkboxes ' . (string) $this->element['class'] . '"' : ' class="checkboxes"';

		// Start the checkbox field output.
		$html[] = '<fieldset id="' . $this->id . '"' . $class . '>';

		// Get the field options.
//		$options = $this->getOptions();

		// Build the checkbox field output.
		$html[] = '<ul>';
		foreach ($tags1 as $i => $option)
		{

			// Initialize some option attributes.
			$checked = (in_array((string) $option->value, (array) $activeArray) ? ' checked="checked"' : '');
			$class = !empty($option->class) ? ' class="' . $option->class . '"' : '';
			$disabled = !empty($option->disable) ? ' disabled="disabled"' : '';

			// Initialize some JavaScript option attributes.
			$onclick = !empty($option->onclick) ? ' onclick="' . $option->onclick . '"' : '';

			$html[] = '<li>';
			$html[] = '<input type="checkbox" id="' . $this->id . $i . '" name="' . $this->name . '[]"' . ' value="'
				. htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8') . '"' . $checked . $class . $onclick . $disabled . '/>';

			$html[] = '<label for="' . $this->id . $i . '"' . $class . '>' . JText::_($option->text) . '</label>';
			$html[] = '</li>';
		}
		$html[] = '</ul>';

		// End the checkbox field output.
		$html[] = '</fieldset>';
		$html[] = '<div style="clear:both"></div><label title="" class="hasTip" for="jform_tags" id="jform_tags-lbl">非常用标签</label>';

		$tags1 =  implode($html);
		
		
		
		$query = 'SELECT a.id AS value, a.title AS text'
				.' FROM #__phocagallery_tags AS a where a.is_cy=\'否\''
				. ' ORDER BY '. $order;
		$db->setQuery($query);
		
		if (!$db->query()) {
			$this->setError('Database Error - Getting All Tags');
			return false;
		}
		
		$tags = $db->loadObjectList();
		
		$tagsO = JHTML::_('select.genericlist', $tags, $name, 'class="inputbox" size="4" multiple="multiple"'. $javascript, 'value', 'text', $activeArray, $id);
		
		return $tags1.$tagsO;
	}
}
?>