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
JHtml::_('behavior.formvalidation');
?>
<script type="text/javascript">
	
</script>


<form action="<?php JRoute::_('index.php?option=com_phocagallery'); ?>" method="post" name="adminForm" id="phocagalleryimg-form" class="form-validate">
	<div class="width-60 fltlft">
		
		<fieldset class="adminform">
			<legend><?php echo empty($this->item->id) ? JText::_('COM_PHOCAGALLERY_NEW_PRODUCT') : JText::sprintf('COM_PHOCAGALLERY_EDIT_IMAGE', $this->item->id); ?></legend>
			
			
<?php 		
// - - - - - - - - - -
// Image

//$fileOriginal = PhocaGalleryFile::getFileOriginal($this->item->filename);
//if (!JFile::exists($fileOriginal)) {
//	$this->item->fileoriginalexist = 0;
//} else {
//	$fileThumb 		= PhocaGalleryFileThumbnail::getOrCreateThumbnail($this->item->filename, '', 0, 0, 0);
//	$this->item->linkthumbnailpath 	= $fileThumb['thumb_name_s_no_rel'];
//	$this->item->fileoriginalexist = 1;	
//}
//
//echo '<div style="float:right;margin:5px;">';
//// PICASA
//if (isset($this->item->extid) && $this->item->extid !='') {									
//	
//	$resW				= explode(',', $this->item->extw);
//	$resH				= explode(',', $this->item->exth);
//	$correctImageRes 	= PhocaGalleryImage::correctSizeWithRate($resW[2], $resH[2], 50, 50);
//	$imgLink			= $this->item->extl;
//	
//	echo '<img src="'.$this->item->exts.'" width="'.$correctImageRes['width'].'" height="'.$correctImageRes['height'].'" alt="" />';
//	
//} else if (isset ($this->item->fileoriginalexist) && $this->item->fileoriginalexist == 1) {
//	
//	$imageRes			= PhocaGalleryImage::getRealImageSize($this->item->filename, 'small');
//	$correctImageRes 	= PhocaGalleryImage::correctSizeWithRate($imageRes['w'], $imageRes['h'], 50, 50);
//	$imgLink			= PhocaGalleryFileThumbnail::getThumbnailName($this->item->filename, 'large');
//	
//
//	echo '<img src="'.JURI::root().$this->item->linkthumbnailpath.'?imagesid='.md5(uniqid(time())).'" width="'.$correctImageRes['width'].'" height="'.$correctImageRes['height'].'" alt="'.JText::_('COM_PHOCAGALLERY_ENLARGE_IMAGE').'" />'
//	.'</a>';
//} else {
//	
//}
//echo '</div>';
// - - - - - - - - - -			
?>			
		<ul class="adminformlist">
			<?php
			// Extid is hidden - only for info if this is an external image (the filename field will be not required)
			$formArray = array ('title', 'alias', 'catname','source', 'ordering','productid','productname','price','url',
			'filename', 'pic_width', 'pic_height');
			$config = new HMConfig();
			foreach ($formArray as $value) {
				echo '<li>'.$this->form->getLabel($value) . $this->form->getInput($value);
				if($value=='source'){?>
					<div style="float:left;"><input type="button" value="获取商品" onclick="getProduct();"/></div>
					<script type="text/javascript">
						function getProduct(){
							var b = $('#jform_source').val();
							if(!isNaN(b)){
								var url = '';
								if($('#jform_catname').val()=='团购'){
									url = '<?php echo $config->tg_url?>'+$('#jform_source').val();
								}else if($('#jform_catname').val()=='闪购'){
									url='<?php echo $config->sg_url?>'+$('#jform_source').val();
								}else{
									url='<?php echo $config->shop_url?>'+$('#jform_source').val();
								}
								var a ='../ajax3.php?url='+url;
								$.ajax({
									type:'get',
									url:a,
									dataType:'xml',
									success:function(data){
										var result = $(data).find('product').find('result').text();
										if(result==0){
											alert('返回数据错误，请查检'+url);
										}else{
											$('#jform_filename').val($(data).find('product').find('pic').text());
//											$('#jform_productid').val($(data).find('product').find('id').text());
											$('#jform_productname').val($(data).find('product').find('name').text());
											$('#jform_price').val($(data).find('product').find('price').text());
											$('#jform_url').val($(data).find('product').find('url').text());
											$('#jform_pic_width').val($(data).find('product').find('pic_width').text());
											$('#jform_pic_height').val($(data).find('product').find('pic_height').text());
										}
									},error:function(data){
										alert('返回数据错误，请查检'+url);
									}
								});
							}else{
								alert('商品编号必须为数字');
							}
						}
					</script>
					<?php 
				}
				echo '</li>' . "\n";
			} ?>
		</ul>
		
		<?php echo $this->form->getInput('extid');?>
		
		<div class="clr"></div>
		
			<?php echo $this->form->getLabel('description'); ?>
			<div class="clr"></div>
			<?php echo $this->form->getInput('description'); ?>
		
		<div class="clr"></div>
		</fieldset>
	</div>

<div class="width-40 fltrt">
	<!-- <div style="text-align:right;margin:5px;"><?php echo $this->tmpl['enablethumbcreationstatus']; ?></div> -->
	<?php echo JHtml::_('sliders.start','phocagallerx-sliders-'.$this->item->id, array('useCookie'=>1)); ?>

	<?php echo JHtml::_('sliders.panel',JText::_('COM_PHOCAGALLERY_GROUP_LABEL_PUBLISHING_DETAILS'), 'publishing-details'); ?>
		<fieldset class="adminform">
		<ul class="adminformlist">
			<?php foreach($this->form->getFieldset('publish') as $field) {
				echo '<li>';
				if (!$field->hidden) {
					echo $field->label;
				}
				echo $field->input;
				echo '</li>';
			} ?>
			</ul>
		</fieldset>
		
		<?php echo $this->loadTemplate('metadata'); ?>
	<?php echo JHtml::_('sliders.end'); ?>
</div>

<div class="clr"></div>

<input type="hidden" name="task" value="" />
<?php echo JHtml::_('form.token'); ?>
</form>

	
