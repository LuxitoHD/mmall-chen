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
jimport( 'joomla.filesystem.folder' ); 
jimport( 'joomla.filesystem.file' );
phocagalleryimport('phocagallery.path.path');
phocagalleryimport('phocagallery.file.file');
require_once JPATH_SITE.DS.'hmconfig.php';

class PhocaGalleryFileThumbnail
{
	public $file;
	/*
	 *Get thumbnailname
	 */
	function getThumbnailName($filename, $size) {
		$config 	= new HMConfig();
		$cur = rand(0, $config->img_provider_count-1);
		$path		= &PhocaGalleryPath::getPath();		
		$title 		= PhocaGalleryFile::getTitleFromFile($filename , 1);

		$thumbName	= new JObject();
		
		$fileNameThumb ='';
		switch ($size) {
			case 'large':{
				$fileNameThumb 	= 'phoca_thumb_l_'. $title;
				break;
			}
			case 'medium':{
				$fileNameThumb 	= 'phoca_thumb_m_'. $title;
				break;
			}
			
			Default:
			case 'small':{
				$fileNameThumb 	= 'phoca_thumb_s_'. $title;
				break;
			}
		}
		$thumbName->abs	= JPath::clean(str_replace($title, 'thumbs'. DS . $fileNameThumb, $path->img_server_abs[$cur] . $filename));
		$thumbName->rel	= str_replace ($title, 'thumbs/' . $fileNameThumb, $path->img_provider[$cur] . $filename);
		$thumbName->rel = str_replace('//', '/', $thumbName->rel);

		return $thumbName;
	}
	
	function getHomeThumbnailName($filename, $size) {
		$config 	= new HMConfig();
		$cur = rand(0, $config->img_provider_count-1);
		$path		= &PhocaGalleryPath::getPath();		
		$title 		= PhocaGalleryFile::getTitleFromFile($filename , 1);

		$thumbName	= new JObject();
		
		$fileNameThumb ='';
		switch ($size) {
			case 'large':{
				$fileNameThumb 	= 'phoca_thumb_l_'. $title;
				break;
			}
			case 'medium':{
				$fileNameThumb 	= 'phoca_thumb_m_'. $title;
				break;
			}
			Default:
			case 'small':{
				$fileNameThumb 	= 'phoca_thumb_s_'. $title;
				break;
			}
		}
		$thumbName->abs	= JPath::clean(str_replace($title, 'thumbs'. DS . $fileNameThumb, $path->image_abs . $filename));
		$thumbName->rel	= str_replace ($title, 'thumbs/' . $fileNameThumb, $path->image_rel . $filename);
		$thumbName->rel = str_replace('//', '/', $thumbName->rel);

		return $thumbName;
	}
	
	function deleteFileThumbnail ($filename, $small=0, $medium=0, $large=0) {					
		
		if ($small == 1) {
			$fileNameThumbS = PhocaGalleryFileThumbnail::getThumbnailName ($filename, 'small');
			if (JFile::exists($fileNameThumbS->abs)) {
				JFile::delete($fileNameThumbS->abs);
			}
		}
		
		if ($medium == 1) {
			$fileNameThumbM = PhocaGalleryFileThumbnail::getThumbnailName ($filename, 'medium');
			if (JFile::exists($fileNameThumbM->abs)) {
				JFile::delete($fileNameThumbM->abs);
			}
		}
		
		if ($large == 1) {
			$fileNameThumbL = PhocaGalleryFileThumbnail::getThumbnailName ($filename, 'large');
			if (JFile::exists($fileNameThumbL->abs)) {
				JFile::delete($fileNameThumbL->abs);
			}
		}
		return true;
	}
	
	/*
	 * Main Thumbnail creating function
	 *
	 * file 		= abc.jpg
	 * fileNo	= folder/abc.jpg
	 * if small, medium, large = 1, create small, medium, large thumbnail
	 */
	function getOrCreateThumbnail($fileNo, $refreshUrl, $small = 0, $medium = 0, $large = 0, $frontUpload = 0) {
		$config = new HMConfig();
		$config->img_server1;
		if ($frontUpload) {
			$returnFrontMessage = '';
		}
		
		$onlyThumbnailInfo = 0;
		if ($small == 0 && $medium == 0 && $large == 0) {
			$onlyThumbnailInfo = 1;
		}
		
		$path 									= PhocaGalleryPath::getPath();
		$origPathServer 						= str_replace(DS, '/', $path->image_abs);
		$this->file['name']							= PhocaGalleryFile::getTitleFromFile($fileNo, 1);
		$this->file['name_no']						= ltrim($fileNo, '/');
		$this->file['name_original_abs']				= PhocaGalleryFile::getFileOriginal($fileNo);
		$this->file['name_original_rel']				= PhocaGalleryFile::getFileOriginal($fileNo, 1);
		$this->file['path_without_file_name_original']= str_replace($this->file['name'], '', $this->file['name_original_abs']);
		$this->file['path_without_file_name_thumb']	= str_replace($this->file['name'], '', $this->file['name_original_abs'] . 'thumbs' . DS);
		
		foreach($path->img_server_abs as $key=>$item){
			$this->file['name_original_abs1'][$key]				= JPath::clean($item . $fileNo) ;
			$this->file['path_without_file_name_original1'][$key]= str_replace($this->file['name'], '', $this->file['name_original_abs1'][$key]);
			$this->file['path_without_file_name_thumb1'][$key]	= str_replace($this->file['name'], '', $this->file['name_original_abs1'][$key] . 'thumbs' . DS);
		}
//		$origPathServer1						= str_replace(DS, '/', $path->server1_image_abs);
//		$this->file['name_original_abs1']				= JPath::clean($path->server1_image_abs . $fileNo) ;//PhocaGalleryFile::getFileOriginal($fileNo);
//		$this->file['name_original_rel1']				= str_replace('//', '/', $path->server1_image_rel . $fileNo);//PhocaGalleryFile::getFileOriginal($fileNo, 1);
//		$this->file['path_without_file_name_original1']= str_replace($this->file['name'], '', $this->file['name_original_abs1']);
		
		
//		$origPathServer2						= str_replace(DS, '/', $path->server2_image_abs);
//		$this->file['name_original_abs2']				= JPath::clean($path->server2_image_abs . $fileNo);
//		$this->file['name_original_rel2']				= str_replace('//', '/', $path->server2_image_rel . $fileNo);
//		$this->file['path_without_file_name_original2']= str_replace($this->file['name'], '', $this->file['name_original_abs2']);
//		$this->file['path_without_file_name_thumb2']	= str_replace($this->file['name'], '', $this->file['name_original_abs2'] . 'thumbs' . DS);
		
		
		$ext = strtolower(JFile::getExt($this->file['name']));
		switch ($ext) {
			case 'jpg':
			case 'png':
			case 'gif':
			case 'jpeg':

			//Get File thumbnails name

			$thumbNameS 					= PhocaGalleryFileThumbnail::getHomeThumbnailName($fileNo, 'small');
			$this->file['thumb_name_s_no_abs'] 	= $thumbNameS->abs;
			$this->file['thumb_name_s_no_rel'] 	= $thumbNameS->rel;
			
			$thumbNameM						= PhocaGalleryFileThumbnail::getHomeThumbnailName($fileNo, 'medium');
			$this->file['thumb_name_m_no_abs'] 	= $thumbNameM->abs;
			$this->file['thumb_name_m_no_rel'] 	= $thumbNameM->rel;
			
			$thumbNameL						= PhocaGalleryFileThumbnail::getHomeThumbnailName($fileNo, 'large');
			$this->file['thumb_name_l_no_abs'] 	= $thumbNameL->abs;
			$this->file['thumb_name_l_no_rel'] 	= $thumbNameL->rel;


			// Don't create thumbnails from watermarks...			
			$dontCreateThumb	= PhocaGalleryFileThumbnail::dontCreateThumb($this->file['name']);
			if ($dontCreateThumb == 1) {
				$onlyThumbnailInfo = 1; // WE USE $onlyThumbnailInfo FOR NOT CREATE A THUMBNAIL CLAUSE
			}
			
			// We want only information from the pictures OR
			if ( $onlyThumbnailInfo == 0 ) {

				$thumbInfo = $fileNo;	
				//Create thumbnail folder if not exists
				$errorMsg = 'ErrorCreatingFolder';
				$creatingFolder = PhocaGalleryFileThumbnail::createThumbnailFolder($this->file['path_without_file_name_original'], $this->file['path_without_file_name_thumb'], $errorMsg );
				foreach($path->img_server_abs as $key=>$item){
					$creatingFolder1 = PhocaGalleryFileThumbnail::createThumbnailFolder($this->file['path_without_file_name_original1'][$key], $this->file['path_without_file_name_thumb1'][$key], $errorMsg );
				}
				
//				$creatingFolder2 = PhocaGalleryFileThumbnail::createThumbnailFolder($this->file['path_without_file_name_original2'], $this->file['path_without_file_name_thumb2'], $errorMsg );
					
				switch ($errorMsg) {
					case 'Success':
					//case 'ThumbnailExists':
					case 'DisabledThumbCreation':
					//case 'OnlyInformation':
					break;
					
					Default:
					
						// BACKEND OR FRONTEND
						if ($frontUpload !=1) {
							PhocaGalleryRenderProcess::getProcessPage( $this->file['name'], $thumbInfo, $refreshUrl, $errorMsg, $frontUpload);
							exit;
						} else {
							$returnFrontMessage = $errorMsg;
						}
						
					break;	
				}
				
				// Folder must exist
				if (JFolder::exists($this->file['path_without_file_name_thumb'])) {				
					
					$errorMsgS = $errorMsgM = $errorMsgL = '';
					//Small thumbnail
					if ($small == 1) {
						PhocaGalleryFileThumbnail::createFileThumbnail($this->file['name_original_abs'], $thumbNameS->abs, 'small', $frontUpload, $errorMsgS);
					} else {
						$errorMsgS = 'ThumbnailExists';// in case we only need medium or large, because of if clause bellow
					}
					
					//Medium thumbnail
					if ($medium == 1) {
						PhocaGalleryFileThumbnail::createFileThumbnail($this->file['name_original_abs'], $thumbNameM->abs, 'medium', $frontUpload, $errorMsgM);
					} else {
						$errorMsgM = 'ThumbnailExists'; // in case we only need small or large, because of if clause bellow
					}
					
					//Large thumbnail
					if ($large == 1) {
						PhocaGalleryFileThumbnail::createFileThumbnail($this->file['name_original_abs'], $thumbNameL->abs, 'large', $frontUpload, $errorMsgL);
					} else {
						$errorMsgL = 'ThumbnailExists'; // in case we only need small or medium, because of if clause bellow
					}
					
					// Error messages for all 3 thumbnails (if the message contains error string, we got error
					// Other strings can be:
					// - ThumbnailExists  - do not display error message nor success page
					// - OnlyInformation - do not display error message nor success page
					// - DisabledThumbCreation - do not display error message nor success page
					
					$creatingSError = $creatingMError = $creatingLError = false;
					$creatingSError = preg_match("/Error/i", $errorMsgS);
					$creatingMError = preg_match("/Error/i", $errorMsgM);
					$creatingLError = preg_match("/Error/i", $errorMsgL);
					
					// BACKEND OR FRONTEND
					if ($frontUpload != 1) {
					
						// There is an error while creating thumbnail in m or in s or in l
						if ($creatingSError || $creatingMError || $creatingLError) {
							// if all or two errors appear, we only display the last error message	
							// because the errors in this case is the same
							if ($errorMsgS != '') {
								$creatingError = $errorMsgS;
							}
							if ($errorMsgM != '') {
								$creatingError = $errorMsgM;
							}
							if ($errorMsgL != '') {
								$creatingError = $errorMsgL;
							}
						
							PhocaGalleryRenderProcess::getProcessPage( $this->file['name'], $thumbInfo, $refreshUrl, $creatingError);exit;
						} else if ($errorMsgS == '' && $errorMsgM == '' && $errorMsgL == '') {
							PhocaGalleryRenderProcess::getProcessPage( $this->file['name'], $thumbInfo, $refreshUrl);exit;
						} else if ($errorMsgS == '' && $errorMsgM == '' && $errorMsgL == 'ThumbnailExists') {
							PhocaGalleryRenderProcess::getProcessPage( $this->file['name'], $thumbInfo, $refreshUrl);exit;
						} else if ($errorMsgS == '' && $errorMsgM == 'ThumbnailExists' && $errorMsgL == 'ThumbnailExists') {
							PhocaGalleryRenderProcess::getProcessPage( $this->file['name'], $thumbInfo, $refreshUrl);exit;
						} else if ($errorMsgS == '' && $errorMsgM == 'ThumbnailExists' && $errorMsgL == '') {
							PhocaGalleryRenderProcess::getProcessPage( $this->file['name'], $thumbInfo, $refreshUrl);exit;
						} else if ($errorMsgS == 'ThumbnailExists' && $errorMsgM == 'ThumbnailExists' && $errorMsgL == '') {
							PhocaGalleryRenderProcess::getProcessPage( $this->file['name'], $thumbInfo, $refreshUrl);exit;
						} else if ($errorMsgS == 'ThumbnailExists' && $errorMsgM == '' && $errorMsgL == '') {
							PhocaGalleryRenderProcess::getProcessPage( $this->file['name'], $thumbInfo, $refreshUrl);exit;
						} else if ($errorMsgS == 'ThumbnailExists' && $errorMsgM == '' && $errorMsgL == 'ThumbnailExists') {
							PhocaGalleryRenderProcess::getProcessPage( $this->file['name'], $thumbInfo, $refreshUrl);exit;
						}
					} else {
						// There is an error while creating thumbnail in m or in s or in l
						if ($creatingSError || $creatingMError || $creatingLError) {
							// if all or two errors appear, we only display the last error message	
							// because the errors in this case is the same
							if ($errorMsgS != '') {
								$creatingError = $errorMsgS;
							}
							if ($errorMsgM != '') {
								$creatingError = $errorMsgM;
							}
							if ($errorMsgL != '') {
								$creatingError = $errorMsgL;
							}							// because the errors in this case is the same
						
							$returnFrontMessage = $creatingError;
						} else if ($errorMsgS == '' && $errorMsgM == '' && $errorMsgL == '') {
							$returnFrontMessage = 'Success';
						} else if ($errorMsgS == '' && $errorMsgM == '' && $errorMsgL == 'ThumbnailExists') {
							$returnFrontMessage = 'Success';
						} else if ($errorMsgS == '' && $errorMsgM == 'ThumbnailExists' && $errorMsgL == 'ThumbnailExists') {
							$returnFrontMessage = 'Success';
						} else if ($errorMsgS == '' && $errorMsgM == 'ThumbnailExists' && $errorMsgL == '') {
							$returnFrontMessage = 'Success';
						} else if ($errorMsgS == 'ThumbnailExists' && $errorMsgM == 'ThumbnailExists' && $errorMsgL == '') {
							$returnFrontMessage = 'Success';
						} else if ($errorMsgS == 'ThumbnailExists' && $errorMsgM == '' && $errorMsgL == '') {
							$returnFrontMessage = 'Success';
						} else if ($errorMsgS == 'ThumbnailExists' && $errorMsgM == '' && $errorMsgL == 'ThumbnailExists') {
							$returnFrontMessage = 'Success';
						}
					}
					
					if ($frontUpload == 1) {
						return $returnFrontMessage;
					}
				}
			}
			break;
		}
		return $this->file;
	}
	
	function xCopy($source, $destination, $child){
		if(!is_dir($source)){
			echo("Error:the $source is not a direction!");
 			return 0;   
		}   
 
 		if(!is_dir($destination)){   
			mkdir($destination,0777);   
		}   

		$handle=dir($source);   
		while($entry=$handle->read()) {   
			if(($entry!=".")&&($entry!="..")){   
				if(is_dir($source."/".$entry)){   
					if($child)   
						xCopy($source."/".$entry,$destination."/".$entry,$child);   
				}   
				else{   
					copy($source."/".$entry,$destination."/".$entry);   
				}
			}   
		}   
		return 1;   
	}  
	
	function dontCreateThumb ($filename) {
		$dontCreateThumb		= false;
		$dontCreateThumbArray	= array ('watermark-large.png', 'watermark-medium.png');
		foreach ($dontCreateThumbArray as $key => $value) {
			if (strtolower($filename) == strtolower($value)) {
				return true;
			}
		}
		return false;
	}
	
	function createThumbnailFolder($folderOriginal, $folderThumbnail, &$errorMsg) {	
		
		$paramsC = JComponentHelper::getParams('com_phocagallery');
		$enable_thumb_creation = $paramsC->get( 'enable_thumb_creation', 1 );
		$folder_permissions = $paramsC->get( 'folder_permissions', 0755 );
		//$folder_permissions = octdec((int)$folder_permissions);
		
		// disable or enable the thumbnail creation
		if ($enable_thumb_creation == 1) {
			if(!JFolder::exists($folderOriginal)){
				JFolder::create($folderOriginal, 0777 );
			}
			if (JFolder::exists($folderOriginal)) {
				if (strlen($folderThumbnail) > 0) {
					$folderThumbnail = JPath::clean($folderThumbnail);				
					if (!JFolder::exists($folderThumbnail) && !JFile::exists($folderThumbnail)) {
						switch((int)$folder_permissions) {
							case 777:
								JFolder::create($folderThumbnail, 0777 );
							break;
							case 705:
								JFolder::create($folderThumbnail, 0705 );
							break;
							case 666:
								JFolder::create($folderThumbnail, 0666 );
							break;
							case 644:
								JFolder::create($folderThumbnail, 0644 );
							break;				
							case 755:
							Default:
								JFolder::create($folderThumbnail, 0755 );
							break;
						}
						
						//JFolder::create($folderThumbnail, $folder_permissions );
						if (isset($folderThumbnail)) {
							$data = "<html>\n<body bgcolor=\"#FFFFFF\">\n</body>\n</html>";
							JFile::write($folderThumbnail.DS."index.html", $data);
						}
						// folder was not created
						if (!JFolder::exists($folderThumbnail)) {
							$errorMsg = 'ErrorCreatingFolder';
							return false;	
						}
					}
				}
			}
			$errorMsg = 'Success';
			
			return true;
		} else {
			$errorMsg = 'DisabledThumbCreation';
			return false; // User have disabled the thumbanil creation e.g. because of error
		}
	}
	
	function createFileThumbnail($fileOriginal, $fileThumbnail, $size, $frontUpload=0, &$errorMsg) {	
		
		$paramsC 					= JComponentHelper::getParams('com_phocagallery');
		$enable_thumb_creation 		= $paramsC->get( 'enable_thumb_creation', 1);
		$watermarkParams['create']	= $paramsC->get( 'create_watermark', 0 );// Watermark
		$watermarkParams['x'] 		= $paramsC->get( 'watermark_position_x', 'center' );
		$watermarkParams['y']		= $paramsC->get( 'watermark_position_y', 'middle' );
		$crop_thumbnail				= $paramsC->get( 'crop_thumbnail', 5);// Crop or not
		$crop 						= null;
		
		switch ($size) {	
			case 'small':
				if ($crop_thumbnail == 3 || $crop_thumbnail == 5 || $crop_thumbnail == 6 || $crop_thumbnail == 7 ) {
					$crop = 1;
				}
			break;
			
			case 'medium':
				if ($crop_thumbnail == 2 || $crop_thumbnail == 4 || $crop_thumbnail == 5 || $crop_thumbnail == 7 ) {
					$crop = 1;
				}
			break;
			
			case 'large':
			Default:
				if ($crop_thumbnail == 1 || $crop_thumbnail == 4 || $crop_thumbnail == 6 || $crop_thumbnail == 7 ) {
					$crop = 1;
				}
			break;
		}		
		
		// disable or enable the thumbnail creation
		if ($enable_thumb_creation == 1) {	
			$fileResize	= PhocaGalleryFileThumbnail::getThumbnailResize($size);

			if (JFile::exists($fileOriginal)) {
				//file doesn't exist, create thumbnail
				if (!JFile::exists($fileThumbnail)) {
					$errorMsg = 'Error4';
					//Don't do thumbnail if the file is smaller (width, height) than the possible thumbnail
					list($width, $height) = GetImageSize($fileOriginal);
					//larger
					phocagalleryimport('phocagallery.image.imagemagic');
					$fileName 			= PhocaGalleryFile::getTitleFromFile($fileThumbnail, 1);
					$fileOriginalName 			= PhocaGalleryFile::getTitleFromFile($fileOriginal, 1);
					if ($width > $fileResize['width'] || $height > $fileResize['height']) {
						//tian_ff 
						 $fileResize['height'] = (int)($fileResize['width']*$height/$width);
						$imageMagic = PhocaGalleryImageMagic::imageMagic($fileOriginal, $fileThumbnail, $fileResize['width'] , $fileResize['height'], $crop, null, $watermarkParams, $frontUpload, $errorMsg);
						$path		= &PhocaGalleryPath::getPath();
						foreach($path->img_server_abs as $key=>$item){
							copy($fileOriginal,$this->file['path_without_file_name_original1'][$key].$fileOriginalName);
							copy($fileThumbnail,$this->file['path_without_file_name_thumb1'][$key].$fileName);
						}
						
//						copy($fileThumbnail,$this->file['path_without_file_name_thumb2'].$fileName);
					} else {
						$imageMagic = PhocaGalleryImageMagic::imageMagic($fileOriginal, $fileThumbnail, $width , $height, $crop, null, $watermarkParams, $frontUpload, $errorMsg);
						$path		= &PhocaGalleryPath::getPath();
						foreach($path->img_server_abs as $key=>$item){
							copy($fileOriginal,$this->file['path_without_file_name_original1'][$key].$fileOriginalName);
							copy($fileThumbnail,$this->file['path_without_file_name_thumb1'][$key].$fileName);
						}
					}
					if ($imageMagic) {
						return true;
					} else {
						return false;// error Msg will be taken from imageMagic
					}
				} else {
					$errorMsg = 'ThumbnailExists';//thumbnail exists
					return false;
				}	
			} else {
				$errorMsg = 'ErrorFileOriginalNotExists';
				return false;
			}
			$errorMsg = 'Error3';
			return false;
		} else {
			$errorMsg = 'DisabledThumbCreation'; // User have disabled the thumbanil creation e.g. because of error
			return false;
		}
	}
	
	function getThumbnailResize($size = 'all') {	
		
		// Get width and height from Default settings
		$params 			= JComponentHelper::getParams('com_phocagallery') ;
		$large_image_width 	= $params->get( 'large_image_width', 640 );
		$large_image_height = $params->get( 'large_image_height', 480 );
		$medium_image_width = $params->get( 'medium_image_width', 100 );
		$medium_image_height= $params->get( 'medium_image_height', 100 );
		$small_image_width 	= $params->get( 'small_image_width', 50 );
		$small_image_height = $params->get( 'small_image_height', 50 );
		
		switch ($size) {			
			case 'large':
			$fileResize['width']	=	$large_image_width;
			$fileResize['height']	=	$large_image_height;
			break;
			
			case 'medium':
			$fileResize['width']	=	$medium_image_width;
			$fileResize['height']	=	$medium_image_height;
			break;
			
			case 'small':
			$fileResize['width']	=	$small_image_width;
			$fileResize['height']	=	$small_image_height;
			break;
			
			Default:
			case 'all':
			$fileResize['smallwidth']	=	$small_width;
			$fileResize['smallheight']	=	$small_height;
			$fileResize['mediumwidth']	=	$medium_width;
			$fileResize['mediumheight']	=	$medium_height;
			$fileResize['largewidth']	=	$large_width;
			$fileResize['largeheight']	=	$large_height;
			break;			
		}
		return $fileResize;
	}
}
?>