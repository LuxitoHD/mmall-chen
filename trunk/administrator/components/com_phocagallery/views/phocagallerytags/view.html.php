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
jimport( 'joomla.application.component.view' );
 
class phocagalleryCpViewPhocaGalleryTags extends JView
{
	protected $items;
	protected $pagination;
	protected $state;
	
	function display($tpl = null) {
		
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');

		JHTML::stylesheet('administrator/components/com_phocagallery/assets/phocagallery.css' );
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		$this->processImages();
		$this->addToolbar();
		parent::display($tpl);
		
	}
	
	function addToolbar() {
	
		require_once JPATH_COMPONENT.'/helpers/phocagallerytags.php';
	
		$state	= $this->get('State');
		$canDo	= PhocaGalleryTagsHelper::getActions($state->get('filter.tag_id'));
	
		JToolBarHelper::title( JText::_( 'COM_PHOCAGALLERY_TAGS' ), 'tags.png' );
	
		if ($canDo->get('core.create')) {
			JToolBarHelper::addNew('phocagallerytag.add','JTOOLBAR_NEW');
		}
	
		if ($canDo->get('core.edit')) {
			JToolBarHelper::editList('phocagallerytag.edit','JTOOLBAR_EDIT');
		}
		if ($canDo->get('core.edit.state')) {

			JToolBarHelper::divider();
			JToolBarHelper::custom('phocagallerytags.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
			JToolBarHelper::custom('phocagallerytags.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
		}
	
		if ($canDo->get('core.delete')) {
			JToolBarHelper::deleteList( 'COM_PHOCAGALLERY_WARNING_DELETE_ITEMS', 'phocagallerytags.delete', 'COM_PHOCAGALLERY_DELETE');
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
						$refreshUrlThumb = 'index.php?option=com_phocagallery&view=phocagallerytags';
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
						$refresh_url 	= 'index.php?option=com_phocagallery&view=phocagallerytags';
						$fileThumb 		= PhocaGalleryFileThumbnail::getThumbnailName($value->filename, 'small');
						
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