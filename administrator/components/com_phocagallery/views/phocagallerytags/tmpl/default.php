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
 
defined('_JEXEC') or die;
JHtml::_('behavior.tooltip');
$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$canOrder	= $user->authorise('core.edit.state', 'com_phocagallery');
$saveOrder	= 'a.ordering';
?>

<form action="<?php echo JRoute::_('index.php?option=com_phocagallery&view=phocagallerytags'); ?>" method="post" name="adminForm" id="adminForm">
	<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->state->get('filter.search'); ?>" title="<?php echo JText::_('COM_PHOCAGALLERY_SEARCH_IN_TITLE'); ?>" />
			<button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</div>
		<div class="filter-select fltrt">
			
			<select name="filter_published" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions', array('archived' => 0, 'trash' => 0)), 'value', 'text', $this->state->get('filter.state'), true);?>
			</select>
			
			<?php /*
			<select name="filter_language" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_LANGUAGE');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('contentlanguage.existing', true, true), 'value', 'text', $this->state->get('filter.language'));?>
			</select> */ ?>

		</div>
	</fieldset>
	<div class="clr"> </div>
	
<table class="adminlist">
<thead>
	<tr>
		<th width="1%">
			<input type="checkbox" name="toggle" value="" onclick="checkAll(this)" />
		</th>
		<th class="image" width="1%" align="center"><?php echo JText::_( 'COM_PHOCAGALLERY_IMAGE' ); ?></th>
		<th width="40%" align="center">
			<?php echo JHtml::_('grid.sort', 'COM_PHOCAGALLERY_TITLE', 'a.title', $listDirn, $listOrder); ?>
		</th>
		
		<th width="5%">
			<?php echo JHtml::_('grid.sort', 'COM_PHOCAGALLERY_TAG_IS_CY_TITLE', 'a.is_cy', $listDirn, $listOrder); ?>
		</th>
		
		<th width="5%">
			<?php echo JHtml::_('grid.sort', 'COM_PHOCAGALLERY_TAG_CAT_TITLE', 'a.tag_cat', $listDirn, $listOrder); ?>
		</th>

		
		<th width="5%">
			<?php echo JHtml::_('grid.sort', 'COM_PHOCAGALLERY_PUBLISHED', 'a.published', $listDirn, $listOrder); ?>
		</th>
		

		<th width="13%">
					<?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ORDERING', 'a.ordering', $listDirn, $listOrder);
					if ($canOrder && $saveOrder) {
						echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'phocagallerytags.saveorder');
					} ?>
					</th>
		<?php /*
		<th width="5%">
			<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_LANGUAGE', 'a.language', $listDirn, $listOrder); ?>
		</th> */ ?>
		<th width="1%" nowrap="nowrap">
			<?php echo JHtml::_('grid.sort', '点击数', 'a.hits', $listDirn, $listOrder); ?>
		</th>
		<th width="1%" nowrap="nowrap">
			<?php echo JHtml::_('grid.sort', 'COM_PHOCAGALLERY_ID', 'a.id', $listDirn, $listOrder); ?>
		</th>
		
	</tr>
</thead>

<tbody>
<?php foreach ($this->items as $i => $item) {
$ordering	= ($listOrder == 'a.ordering');
$linkEdit	= JRoute::_( 'index.php?option=com_phocagallery&task=phocagallerytag.edit&id='.(int) $item->id );

$canCheckin	= $user->authorise('core.manage',		'com_checkin') || $item->checked_out==$user->get('id') || $item->checked_out==0;
$canChange	= $user->authorise('core.edit.state',	'com_phocagallery') && $canCheckin;
$canCreate	= $user->authorise('core.create',		'com_phocagallery');
?>
<tr class="row<?php echo $i % 2; ?>">
	<td class="center">
		<?php echo JHtml::_('grid.id', $i, $item->id); ?>
	</td>
	<td>
		<div class="phocagallery-box-file">
			<center>
				<div class="phocagallery-box-file-first">
					<div class="phocagallery-box-file-second">
						<div class="phocagallery-box-file-third">
							<center>
								<?php 
									if (isset ($item->fileoriginalexist) && $item->fileoriginalexist == 1) {
										
										$imageRes			= PhocaGalleryImage::getRealImageSize($item->filename, 'small');
										$correctImageRes 	= PhocaGalleryImage::correctSizeWithRate($imageRes['w'], $imageRes['h'], 50, 50);
										$imgLink			= PhocaGalleryFileThumbnail::getThumbnailName($item->filename, 'large');
										
									
										echo '<a class="'. $this->button->modalname.'" title="'. $this->button->text.'" href="'. $imgLink->rel.'" rel="'. $this->button->options.'" >'
										//. JHTML::_( 'image', $item->linkthumbnailpath.'?imagesid='.md5(uniqid(time())), '', array('width' => $correctImageRes['width'], 'height' => $correctImageRes['height']))
										. '<img src="'.$item->linkthumbnailpath.'?imagesid='.md5(uniqid(time())).'" width="'.$correctImageRes['width'].'" height="'.$correctImageRes['height'].'" alt="'.JText::_('COM_PHOCAGALLERY_ENLARGE_IMAGE').'" />'
										.'</a>';
									}
								?>
							</center>
						</div>
					</div>
				</div>
			</center>
		</div>
	</td>
	
	<td>
	<?php if ($item->checked_out) {
		echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'phocagallerytags.', $canCheckin); 
	} 
	if ($canCreate || $canEdit) {
		echo '<a href="'. JRoute::_($linkEdit).'">'. $this->escape($item->title).'</a>';
	} else {
		echo $this->escape($item->title);
	}  ?>
	</td>
	<td class="center">
		<?php echo $item->is_cy;?>
	</td>
	<td class="center">
		<?php 
			if($item->tag_cat==0) 
				echo '风格';
			else if($item->tag_cat==1)
				echo '空间';
			else if($item->tag_cat==2)
				echo '装客';
		?>
	</td>
	
	<td class="center"><?php echo JHtml::_('jgrid.published', $item->published, $i, 'phocagallerytags.', $canChange); ?></td>
	
<?php 
$cntx = 'phocagallerytags';
echo '<td class="order">';
if ($canChange) {
	if ($saveOrder) {
		if ($listDirn == 'asc') {
			echo '<span>'. $this->pagination->orderUpIcon($i, true, $cntx.'.orderup', 'JLIB_HTML_MOVE_UP', $ordering).'</span>';
			echo '<span>'.$this->pagination->orderDownIcon($i, $this->pagination->total, true, $cntx.'.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering).'</span>';
		} else if ($listDirn == 'desc') {
			echo '<span>'. $this->pagination->orderUpIcon($i, true, $cntx.'.orderdown', 'JLIB_HTML_MOVE_UP', $ordering).'</span>';
			echo '<span>'.$this->pagination->orderDownIcon($i, $this->pagination->total, true, $cntx.'.orderup', 'JLIB_HTML_MOVE_DOWN', $ordering).'</span>';
		}
	}
	$disabled = $saveOrder ?  '' : 'disabled="disabled"';
	echo '<input type="text" name="order[]" size="5" value="'.$item->ordering.'" '.$disabled.' class="text-area-order" />';
} else {
	echo $item->ordering;
}
echo '</td>';
/*

	<td class="center">
	<?php
	if ($item->language=='*') {
		echo JText::_('JALL');
	} else {
		echo $item->language_title ? $this->escape($item->language_title) : JText::_('JUNDEFINED');
	}
	?>
</td> */ ?>
	<td class="center"><?php echo (int) $item->hits; ?></td>
	<td class="center"><?php echo (int) $item->id; ?></td>
</tr>
<?php } ?>
</tbody>
			
<tfoot>
	<tr>
		<td colspan="11">
			<?php echo $this->pagination->getListFooter(); ?>
		</td>
	</tr>
</tfoot>
</table>

<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
<?php echo JHtml::_('form.token'); ?>
</form>