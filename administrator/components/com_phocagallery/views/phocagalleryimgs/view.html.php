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
defined( '_JEXEC' ) or die();
jimport( 'joomla.application.component.view' );
 
class PhocaGalleryCpViewPhocaGalleryImgs extends JView
{

	protected $items;
	protected $items_thumbnail;
	protected $pagination;
	protected $state;
	protected $button;
	protected $tmpl;
	//public $_context 	= 'com_phocagallery.phocagalleryimg';
	
	function display($tpl = null) {
		
		
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');
		
		
		
		
		$this->processImages();
		
		
		JHTML::stylesheet('administrator/components/com_phocagallery/assets/phocagallery.css' );
		$document	= & JFactory::getDocument();
		$document->addCustomTag(PhocaGalleryRenderAdmin::renderIeCssLink(1));
		
		
		$params 	= JComponentHelper::getParams('com_phocagallery');

		
		$this->tmpl['enablethumbcreation']			= $params->get('enable_thumb_creation', 1 );
		$this->tmpl['enablethumbcreationstatus'] 	= PhocaGalleryRenderAdmin::renderThumbnailCreationStatus((int)$this->tmpl['enablethumbcreation']);
		
		
		
		/*$app	= JFactory::getApplication();
		$uri		= JFactory::getURI();
		
		$db		    = JFactory::getDBO();*/

		$this->tmpl['notapproved'] 	= & $this->get( 'NotApprovedImage' );
	
		// Button
		JHTML::_('behavior.modal', 'a.modal_phocagalleryimgs');
		$this->button = new JObject();
		$this->button->set('modal', true);
		$this->button->set('methodname', 'modal-button');
		//$this->button->set('link', $link);
		$this->button->set('text', JText::_('COM_PHOCAGALLERY_DISPLAY_IMAGE_DETAIL'));
		//$this->button->set('name', 'image');
		$this->button->set('modalname', 'modal_phocagalleryimgs');
		$this->button->set('options', "{handler: 'image', size: {x: 200, y: 150}}");

		
		$this->addToolbar();
		parent::display($tpl);
	}
	

	
	protected function addToolbar() {
		
		require_once JPATH_COMPONENT.DS.'helpers'.DS.'phocagalleryimgs.php';

		
		
		$state	= $this->get('State');
		$canDo	= PhocaGalleryImgsHelper::getActions($state->get('filter.image_id'));
		
		JToolBarHelper::title( JText::_('COM_PHOCAGALLERY_IMAGES'), 'image.png' );
		if ($canDo->get('core.create')) {
			JToolBarHelper::addNew( 'phocagalleryimg.add','JTOOLBAR_NEW');
			JToolBarHelper::custom( 'phocagallerym.edit', 'multiple.png', '', 'COM_PHOCAGALLERY_MULTIPLE_ADD' , false);
		}
		if ($canDo->get('core.edit')) {
			JToolBarHelper::editList('phocagalleryimg.edit','JTOOLBAR_EDIT');
		}
		
		if ($canDo->get('core.create')) {			
			$bar = & JToolBar::getInstance('toolbar');
			$bar->appendButton( 'Custom', '<a href="#" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert(\''.JText::_('COM_PHOCAGALLERY_WARNING_RECREATE_MAKE_SELECTION').'\');}else{if(confirm(\''.JText::_('COM_PHOCAGALLERY_WARNING_RECREATE_THUMBNAILS').'\')){submitbutton(\'phocagalleryimg.recreate\');}}" class="toolbar"><span class="icon-32-recreate" title="'.JText::_('COM_PHOCAGALLERY_RECREATE_THUMBS').'" type="Custom"></span>'.JText::_('COM_PHOCAGALLERY_RECREATE').'</a>');
		}
		
		
		if ($canDo->get('core.edit.state')) {

			JToolBarHelper::divider();
			JToolBarHelper::custom('phocagalleryimgs.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
			JToolBarHelper::custom('phocagalleryimgs.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
			JToolBarHelper::custom( 'phocagalleryimgs.approve', 'approve.png', '',  'COM_PHOCAGALLERY_APPROVE' , true);
			JToolBarHelper::custom( 'phocagalleryimgs.disapprove', 'disapprove.png', '',  'COM_PHOCAGALLERY_NOT_APPROVE' , true);
		}

		if ($canDo->get('core.delete')) {
			JToolBarHelper::deleteList( JText::_( 'COM_PHOCAGALLERY_WARNING_DELETE_ITEMS' ), 'phocagalleryimgs.delete', 'COM_PHOCAGALLERY_DELETE');
		}
//		JToolBarHelper::divider();
//		JToolBarHelper::help( 'screen.phocagallery', true );
	}
	
	
	protected function processImages() {
	
		if (!empty($this->items)) {
			
			$params							= &JComponentHelper::getParams( 'com_phocagallery' );
			$pagination_thumbnail_creation 	= $params->get( 'pagination_thumbnail_creation', 0 );
			$clean_thumbnails 				= $params->get( 'clean_thumbnails', 0 );		
		
		
			//Server doesn't have CPU power
			//we do thumbnail for all images - there is no pagination...
			//or we do thumbanil for only listed images
			if (empty($this->items_thumbnail)) {	
				if ($pagination_thumbnail_creation == 1) {
					$this->items_thumbnail 	= $this->items;
				} else {
					$this->items_thumbnail	= $this->get('ItemsThumbnail');
				
				}
			}

			// - - - - - - - - - - - - - - - - - - - -
			// Check if the file stored in database is on the server. If not please refer to user
			// Get filename from every object there is stored in database	
			// file - abc.img, file_no - folder/abc.img
			// Get folder variables from Helper
			$path 				= PhocaGalleryPath::getPath();
			$origPath 			= $path->image_abs;
			$origPathServer 	= str_replace(DS, '/', $path->image_abs);
		
			//-----------------------------------------
			//Do all thumbnails no limit no pagination
			if (!empty($this->items_thumbnail)) {
				foreach ($this->items_thumbnail as $key => $value) {	
					$fileOriginalThumb = PhocaGalleryFile::getFileOriginal($value->filename);
					//Let the user know that the file doesn't exists and delete all thumbnails
					if (JFile::exists($fileOriginalThumb)) {
						$refreshUrlThumb = 'index.php?option=com_phocagallery&view=phocagalleryimgs';
						$fileThumb = PhocaGalleryFileThumbnail::getOrCreateThumbnail( $value->filename, $refreshUrlThumb, 1, 1, 1);	
					}
				}
			}
		
			$this->items_thumbnail = null; // delete data to reduce memory
		
			//Only the the site with limitation or pagination...
			if (!empty($this->items)) {
				foreach ($this->items as $key => $value) {	
					$fileOriginal = PhocaGalleryFile::getFileOriginal($value->filename);
					//Let the user know that the file doesn't exists and delete all thumbnails
					
					if (!JFile::exists($fileOriginal)) {
						$this->items[$key]->filename = JText::_( 'COM_PHOCAGALLERY_IMG_FILE_NOT_EXISTS' );
						$this->items[$key]->fileoriginalexist = 0;
					} else {
						//Create thumbnails small, medium, large
						$refresh_url 	= 'index.php?option=com_phocagallery&view=phocagalleryimgs';
//						$fileThumb 		= PhocaGalleryFileThumbnail::getOrCreateThumbnail($value->filename, $refresh_url, 1, 1, 1);
						$fileThumb 		= PhocaGalleryFileThumbnail::getThumbnailName($value->filename, 'small');
//						$this->items[$key]->linkthumbnailpath 	= $fileThumb['thumb_name_s_no_rel'];
						$this->items[$key]->linkthumbnailpath 	= $fileThumb->rel;
						$this->items[$key]->fileoriginalexist = 1;	
					}
				}
			}
		
			//Clean Thumbs Folder if there are thumbnail files but not original file
			if ($clean_thumbnails == 1) {
				PhocaGalleryFileFolder::cleanThumbsFolder();
			}
		}
	}
}
?>