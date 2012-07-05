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

defined('JPATH_PLATFORM') or die;

abstract class PhocaGalleryBatch
{
	
	public static function item($published, $category = 0)
	{
		// Create the copy/move options.
		$options = array(
			JHtml::_('select.option', 'c', JText::_('JLIB_HTML_BATCH_COPY')),
			JHtml::_('select.option', 'm', JText::_('JLIB_HTML_BATCH_MOVE'))
		);
		
		$db = &JFactory::getDBO();

       //build the list of categories
		$query = 'SELECT a.title AS text, a.id AS value, a.parent_id as parentid'
		. ' FROM #__phocagallery_categories AS a'
		// TODO. ' WHERE a.published = '.(int)$published
		. ' ORDER BY a.ordering';
		$db->setQuery( $query );
		$data = $db->loadObjectList();
		$tree = array();
		$text = '';
		$catId= -1;
		$tree = PhocaGalleryRenderAdmin::CategoryTreeOption($data, $tree, 0, $text, $catId);
		
		if ($category == 1) {
			array_unshift($tree, JHTML::_('select.option', 0, JText::_('JLIB_HTML_ADD_TO_ROOT'), 'value', 'text'));
		}

		
		// Create the batch selector to change select the category by which to move or copy.
		$lines = array(
			'<label id="batch-choose-action-lbl" for="batch-choose-action">',
			JText::_('JLIB_HTML_BATCH_MENU_LABEL'),
			'</label>',
			'<fieldset id="batch-choose-action" class="combo">',
				'<select name="batch[category_id]" class="inputbox" id="batch-category-id">',
					'<option value="">'.JText::_('JSELECT').'</option>',
					/*JHtml::_('select.options',	JHtml::_('category.options', $extension, array('published' => (int) $published))),*/
					JHTML::_('select.options',  $tree ),
				'</select>',
				JHTML::_( 'select.radiolist', $options, 'batch[move_copy]', '', 'value', 'text', 'm'),
			'</fieldset>'
		);

		return implode("\n", $lines);
	}
	
	public static function itemTag($published, $category = 0)
	{
		$name = 'batch[category_id]';
		$id=	'batch-category-id';
		$order = 'id';
		$db =& JFactory::getDBO();
		
		$query1 = 'SELECT a.id AS value, a.title AS text'
				.' FROM #__phocagallery_tags AS a where a.is_cy=\'是\''
				. ' ORDER BY '. $order;
		$db->setQuery($query1);
		
		$tags1 = $db->loadObjectList();
		
		$html = array();

		// Initialize some field attributes.
//		$class = $this->element['class'] ? ' class="checkboxes ' . (string) $this->element['class'] . '"' : ' class="checkboxes"';

		// Start the checkbox field output.
//		$html[] = '<fieldset id="' . $this->id . '"' . $class . '>';

		// Get the field options.
//		$options = $this->getOptions();

		// Build the checkbox field output.
		$html[] = '常用标签<ul>';
		foreach ($tags1 as $i => $option)
		{

			// Initialize some option attributes.
			$checked = (in_array((string) $option->value, (array) $activeArray) ? ' checked="checked"' : '');
			$class = !empty($option->class) ? ' class="' . $option->class . '"' : '';
			$disabled = !empty($option->disable) ? ' disabled="disabled"' : '';

			// Initialize some JavaScript option attributes.
			$onclick = !empty($option->onclick) ? ' onclick="' . $option->onclick . '"' : '';

			$html[] = '<li style="float:left;padding:0px;">';
			$html[] = '<input style="line-height:30px;" type="checkbox" id="' . $id . $i . '" name="' . $name . '[]"' . ' value="'
				. htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8') . '"' . $checked . $class . $onclick . $disabled . '/>';

			$html[] = '<label style="min-width:80px;margin:0px;line-height:23px;" for="' . $id . $i . '"' . $class . '>' . JText::_($option->text) . '</label>';
			$html[] = '</li>';
		}
		$html[] = '</ul>';

		// End the checkbox field output.
//		$html[] = '</fieldset>';
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
		
		$tagsO = JHTML::_('select.genericlist', $tags, $name, 'class="inputbox" size="4" multiple="multiple"'. NULL, 'value', 'text', NULL, $id);
		
		return $tags1.$tagsO.'<input name="batch[move_copy]" value="t" type="hidden"><div style="clear:both"></div>';
	}
	
	public static function itemTag1($published, $category = 0)
	{
		// Create the copy/move options.
		$options = array(
			JHtml::_('select.option', 'c', JText::_('JLIB_HTML_BATCH_COPY')),
			JHtml::_('select.option', 'm', JText::_('JLIB_HTML_BATCH_MOVE'))
		);
		
		$db = &JFactory::getDBO();

       //build the list of categories
		$query = 'SELECT a.title AS text, a.id AS value'
		. ' FROM #__phocagallery_tags AS a'
		// TODO. ' WHERE a.published = '.(int)$published
		. ' ORDER BY a.ordering';
		$db->setQuery( $query );
		$data = $db->loadObjectList();
		$tree = array();
		$text = '';
		$catId= -1;
//		$tree = PhocaGalleryRenderAdmin::CategoryTreeOption($data, $tree, 0, $text, $catId);
//		
//		if ($category == 1) {
//			array_unshift($tree, JHTML::_('select.option', 0, JText::_('JLIB_HTML_ADD_TO_ROOT'), 'value', 'text'));
//		}

		
		// Create the batch selector to change select the category by which to move or copy.
		$lines = array(
			'<label id="batch-choose-action-lbl" for="batch-choose-action">',
			JText::_('选择设置的标签'),
			'</label>',
			'<fieldset id="batch-choose-action" class="combo">',
				'<select name="batch[category_id]" class="inputbox" id="batch-category-id">',
					'<option value="">'.JText::_('JSELECT').'</option>',
					/*JHtml::_('select.options',	JHtml::_('category.options', $extension, array('published' => (int) $published))),*/
					JHTML::_('select.options',  $data ),
				'</select>',
				'<input name="batch[move_copy]" value="t" type="hidden">',
			'</fieldset>'
		);

		return implode("\n", $lines);
	}
}
