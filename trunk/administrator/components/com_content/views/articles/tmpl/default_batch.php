<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;


$published = $this->state->get('filter.published');

	function itemTag($published, $category = 0)
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
?>
<fieldset class="batch">
	<legend><?php echo JText::_('COM_CONTENT_BATCH_OPTIONS');?></legend>

	<?php if ($published >= 0) : ?>
		<?php echo JHtml::_('batch.item', 'com_content');?>
	<?php endif; ?>
	<?php echo itemTag(true);?>
	
	<button type="submit" onclick="Joomla.submitbutton('article.batch');">
		<?php echo JText::_('JGLOBAL_BATCH_PROCESS'); ?>
	</button>
	<button type="button" onclick="document.id('batch-category-id').value='';document.id('batch-access').value='';document.id('batch-language-id').value=''">
		<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>
	</button>
</fieldset>
