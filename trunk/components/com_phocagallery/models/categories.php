<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Component
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();
jimport('joomla.application.component.model');
jimport('joomla.application.component.modellist');
require_once JPATH_SITE . '/components/com_content/models/articles.php';

class PhocagalleryModelCategories extends JModel
{
	var $_data 				= null;
	var $_data1 			= null;
	var $_tagData			= null;
	var $_tagData1			= null;
	var $_tagData2			= null;
	var $_total 			= null;
	var $_context 			= 'com_phocagallery.categories';
	private $_ordering		= null;

	function __construct() {
		
		parent::__construct();
		$app 			= JFactory::getApplication();
		$config 			= JFactory::getConfig();		
		$paramsC 			= JComponentHelper::getParams('com_phocagallery') ;
		$default_pagination	= $paramsC->get( 'default_pagination_categories', '0' );
		$category_ordering	= $paramsC->get( 'category_ordering', 1 );
		$context			= $this->_context.'.';
	
		// Get the pagination request variables
		$this->setState('limit', $app->getUserStateFromRequest($context .'limit', 'limit', $default_pagination, 'int'));
		$this->setState('limitstart', JRequest::getVar('limitstart', 0, '', 'int'));
		// In case limit has been changed, adjust limitstart accordingly
		$this->setState('limitstart', ($this->getState('limit') != 0 ? (floor($this->getState('limitstart') / $this->getState('limit')) * $this->getState('limit')) : 0));
		
		$this->setState('filter.language',$app->getLanguageFilter());
		
		$this->setState('catordering', $app->getUserStateFromRequest($context .'catordering', 'catordering', $category_ordering, 'int'));
		// Get the filter request variables
		//$this->setState('filter_order', JRequest::getCmd('filter_order', 'ordering'));
		//$this->setState('filter_order_dir', JRequest::getCmd('filter_order_Dir', 'ASC'));
	}

	function getData() {
		$app	= JFactory::getApplication();
		if (empty($this->_data)) {
			$query = $this->_buildQuery();
			$this->_data = $this->_getList( $query );// We need all data because of tree

			// Order Categories to tree
			$text = ''; // test is tree name e.g. Category >> Subcategory
			$tree = array();
			
			$this->_data = $this->_categoryTree($this->_data, $tree, 1, $text, -1);
			return $this->_data;
		}
	}
	
	function getData1() {
		$app	= JFactory::getApplication();
		if (empty($this->_data)) {
			$query = $this->_buildQuery();
			$this->_data = $this->_getList( $query );// We need all data because of tree

			// Order Categories to tree
			$text = ''; // test is tree name e.g. Category >> Subcategory
			$tree = array();
			
			$this->_data1 = $this->_categoryTree($this->_data, $tree, 2, $text, -1);
			return $this->_data1;
		}
	}
	
	function getTagData(){
		if(empty($this->$_tagData)){
			$query = $this->_buildTagQuery(0);
			$this->_tagData = $this->_getList($query);
			return $this->_tagData;
		}
	}
	
	function getTagData1(){
		if(empty($this->$_tagData1)){
			$query = $this->_buildTagQuery(1);
			$this->_tagData1 = $this->_getList($query);
			return $this->_tagData1;
		}
	}
	
	function getTagData2(){
		if(empty($this->$_tagData2)){
			$query = $this->_buildTagQuery(2);
			$this->_tagData2 = $this->_getList($query);
			return $this->_tagData2;
		}
	}
	
	function getItems()
	{
		//$params = $this->getState()->get('params');
		//$limit = $this->getState('list.limit');
		$limit = 5;

		if ($this->_articles === null ) {
			$model = JModel::getInstance('Articles', 'ContentModel', array('ignore_request' => true));
			$model->setState('params', JFactory::getApplication()->getParams());
			$model->setState('filter.category_id', 78);
			$model->setState('filter.published', 1);
			$model->setState('filter.access', $this->getState('filter.access'));
			$model->setState('filter.language', $this->getState('filter.language'));
			$model->setState('list.ordering', 'a.id');
			$model->setState('list.start', 0);
			$model->setState('list.limit', 5);
			$model->setState('list.direction', 'DESC');
			$model->setState('list.filter', $this->getState('list.filter'));
			// filter.subcategories indicates whether to include articles from subcategories in the list or blog
			$model->setState('filter.subcategories', true);
			$model->setState('filter.max_category_levels', $this->getState('filter.max_category_levels'));
			$model->setState('list.links', $this->getState('list.links'));

			if ($limit >= 0) {
				$this->_articles = $model->getItems();

				if ($this->_articles === false) {
					$this->setError($model->getError());
				}
			}
			else {
				$this->_articles=array();
			}

			//$this->_pagination = $model->getPagination();
		}

		return $this->_articles;
	}
	
	function getImages()
	{
		static $list;

		// Only process the list once per request
		if (is_array($list)) {
			return $list;
		}

		// Get current path from request
		$current = 'phocagallery/homeimg';

		// If undefined, set to empty
		if ($current == 'undefined') {
			$current = '';
		}

		// Initialise variables.
		if (strlen($current) > 0) {
			$basePath = JPATH_ROOT.'/images'.'/'.$current;
		}
		else {
			$basePath = JPATH_ROOT.'/images/';
		}

		$mediaBase = str_replace(DS, '/', JPATH_ROOT.'/images'.'/');
		
		$images		= array ();
		$folders	= array ();
		$docs		= array ();

		$fileList = false;
		$folderList = false;
		if (file_exists($basePath))
		{
			// Get the list of files and folders from the given folder
			$fileList	= JFolder::files($basePath);
			$folderList = JFolder::folders($basePath);
		}

		// Iterate over the files if they exist
		if ($fileList !== false) {
			foreach ($fileList as $file)
			{
				if (is_file($basePath.'/'.$file) && substr($file, 0, 1) != '.' && strtolower($file) !== 'index.html') {
					$tmp = new JObject();
					$tmp->name = $file;
					$tmp->title = $file;
					$tmp->path = str_replace(DS, '/', JPath::clean($basePath . '/' . $file));
					$tmp->path_relative = str_replace($mediaBase, '', $tmp->path);
					$tmp->size = filesize($tmp->path);

					$ext = strtolower(JFile::getExt($file));
					switch ($ext)
					{
						// Image
						case 'jpg':
						case 'png':
						case 'gif':
						case 'xcf':
						case 'odg':
						case 'bmp':
						case 'jpeg':
						case 'ico':
							$info = @getimagesize($tmp->path);
							$tmp->width		= @$info[0];
							$tmp->height	= @$info[1];
							$tmp->type		= @$info[2];
							$tmp->mime		= @$info['mime'];

							if (($info[0] > 60) || ($info[1] > 60)) {
								$dimensions = $this->imageResize($info[0], $info[1], 60);
								$tmp->width_60 = $dimensions[0];
								$tmp->height_60 = $dimensions[1];
							}
							else {
								$tmp->width_60 = $tmp->width;
								$tmp->height_60 = $tmp->height;
							}

							if (($info[0] > 16) || ($info[1] > 16)) {
								$dimensions = $this->imageResize($info[0], $info[1], 16);
								$tmp->width_16 = $dimensions[0];
								$tmp->height_16 = $dimensions[1];
							}
							else {
								$tmp->width_16 = $tmp->width;
								$tmp->height_16 = $tmp->height;
							}

							$images[] = $tmp;
							break;

						// Non-image document
						default:
							$tmp->icon_32 = "media/mime-icon-32/".$ext.".png";
							$tmp->icon_16 = "media/mime-icon-16/".$ext.".png";
							$docs[] = $tmp;
							break;
					}
				}
			}
		}

		// Iterate over the folders if they exist
		if ($folderList !== false) {
			foreach ($folderList as $folder)
			{
				$tmp = new JObject();
				$tmp->name = basename($folder);
				$tmp->path = str_replace(DS, '/', JPath::clean($basePath . '/' . $folder));
				$tmp->path_relative = str_replace($mediaBase, '', $tmp->path);
				$count = MediaHelper::countFiles($tmp->path);
				$tmp->files = $count[0];
				$tmp->folders = $count[1];

				$folders[] = $tmp;
			}
		}

		$list = array('folders' => $folders, 'docs' => $docs, 'images' => $images);

		return $images;
	}

	/*
	* Is called after setTotal from the view
	*/
	function getTotal() {
		return $this->_total;
	}
	
	function setTotal($total) {
		$this->_total = (int)$total;
	}

	/*
	 * Is called after setTotal from the view
	 */
	function getPagination() {
		if (empty($this->_pagination)) {
			jimport('joomla.html.pagination');
			$this->_pagination = new PhocaGalleryPaginationCategories( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}
		return $this->_pagination;
	}
	
	function getOrdering() {
		if(empty($this->_ordering)) {
			$this->_ordering = PhocaGalleryOrdering::renderOrderingFront($this->getState('catordering'), 2);
		}
		return $this->_ordering;
	}
	
	function _buildTagQuery($tag_cat){
		$query ='SELECT * FROM #__phocagallery_tags t where t.published=1 and t.tag_cat = '.$tag_cat;
		return $query;
	}
	
	function _buildQuery() {
		
		$app = JFactory::getApplication();
		
		$user	= &JFactory::getUser();
		$gid	= $user->get('aid', 0);
		
		// Filter by language
		$whereLang = '';
		if ($this->getState('filter.language')) {
			$whereLang =  ' AND cc.language IN ('.$this->_db->Quote(JFactory::getLanguage()->getTag()).','.$this->_db->Quote('*').')';
		}
		
		// Params
		$params	= &$app->getParams();
		$display_subcategories	= $params->get( 'display_subcategories', 1 );
		//$show_empty_categories= $params->get( 'display_empty_categories', 0 );
		//$hide_categories 		= $params->get( 'hide_categories', '' );
		$catOrdering		= PhocaGalleryOrdering::getOrderingString($this->getState('catordering'), 2);
		
		// Display or hide subcategories in CATEGORIES VIEW
		$hideSubCatSql = '';
		if ((int)$display_subcategories != 1) {
			$hideSubCatSql = ' AND cc.parent_id = 0';
		}
		
		// Get all categories which should be hidden
		/*$hideCatArray	= explode( ',', trim( $hide_categories ) );
		$hideCatSql		= '';
		if (is_array($hideCatArray)) {
			foreach ($hideCatArray as $value) {
				$hideCatSql .= ' AND cc.id != '. (int) trim($value) .' ';
			}
		}*/
		
		//Display or hide empty categories
		/*	$emptyCat = '';
		if ($show_empty_categories != 1) {
			$emptyCat = ' AND a.published = 1';
		}*/
		phocagalleryimport('phocagallery.ordering.ordering');
		//$categoryOrdering = PhocaGalleryOrdering::getOrderingString($category_ordering, 2);
		
		$query = 'SELECT cc.*, a.catid, COUNT(a.id) AS numlinks, u.username AS username, r.count AS ratingcount, r.average AS ratingaverage, uc.avatar AS avatar, uc.approved AS avatarapproved, uc.published AS avatarpublished, a.filename, a.exts, a.extm, a.extw, a.exth,'
		. ' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(\':\', cc.id, cc.alias) ELSE cc.id END as slug'
		. ' FROM #__phocagallery_categories AS cc'
		//. ' LEFT JOIN #__phocagallery AS a ON a.catid = cc.id'
		. ' LEFT JOIN #__phocagallery AS a ON a.catid = cc.id and a.published = 1'
		. ' LEFT JOIN #__phocagallery_user AS uc ON uc.userid = cc.owner_id'
		. ' LEFT JOIN #__users AS u ON u.id = cc.owner_id'
		. ' LEFT JOIN #__phocagallery_votes_statistics AS r ON r.catid = cc.id'
		. ' WHERE cc.published = 1'
		. ' AND cc.approved = 1'
		//. ' AND (a.published = 1 OR a.id is null)'
		//. $emptyCat - need to be set in tree
		. $whereLang
		. $hideSubCatSql
		//. $hideCatSql - need to be set in tree
		. ' GROUP BY cc.id'
		//. ' ORDER BY cc.'.$categoryOrdering;
		.$catOrdering['output'];
	
		return $query;
	}
	
	/*
	 * Create category tree
	 */
	function _categoryTree( $data, $tree, $id = 0, $text='', $currentId) {		

		foreach ($data as $key) {	
			$show_text =  $text . $key->title;
			
			static $iCT = 0;// All displayed items
	
			if ($key->parent_id == $id && $currentId != $id && $currentId != $key->id ) {	

				$tree[$iCT] 					= new JObject();
				$tree[$iCT]->id 				= $key->id;
				$tree[$iCT]->title 				= $show_text;
				$tree[$iCT]->title_self 		= $key->title;
				$tree[$iCT]->parent_id			= $key->parent_id;
				$tree[$iCT]->name				= $key->name;
				$tree[$iCT]->alias				= $key->alias;
				$tree[$iCT]->image				= $key->image;
				$tree[$iCT]->section			= $key->section;
				$tree[$iCT]->image_position		= $key->image_position;
				$tree[$iCT]->description		= $key->description;
				$tree[$iCT]->published			= $key->published;
				$tree[$iCT]->editor				= $key->editor;
				$tree[$iCT]->ordering			= $key->ordering;
				$tree[$iCT]->access				= $key->access;
				$tree[$iCT]->count				= $key->count;
				$tree[$iCT]->params				= $key->params;
				$tree[$iCT]->catid				= $key->catid;
				$tree[$iCT]->numlinks			= $key->numlinks;
				$tree[$iCT]->slug				= $key->slug;
				$tree[$iCT]->hits				= $key->hits;
				$tree[$iCT]->username			= $key->username;
				$tree[$iCT]->ratingaverage		= $key->ratingaverage;
				$tree[$iCT]->ratingcount		= $key->ratingcount;
				$tree[$iCT]->accessuserid		= $key->accessuserid;
				$tree[$iCT]->uploaduserid		= $key->uploaduserid;
				$tree[$iCT]->deleteuserid		= $key->deleteuserid;
				$tree[$iCT]->userfolder			= $key->userfolder;
				$tree[$iCT]->latitude			= $key->latitude;
				$tree[$iCT]->longitude			= $key->longitude;
				$tree[$iCT]->zoom				= $key->zoom;
				$tree[$iCT]->geotitle			= $key->geotitle;
				$tree[$iCT]->avatar				= $key->avatar;
				$tree[$iCT]->avatarapproved		= $key->avatarapproved;
				$tree[$iCT]->avatarpublished	= $key->avatarpublished;
				$tree[$iCT]->link				= '';
				$tree[$iCT]->filename			= '';// Will be added in View (after items will be reduced)
				$tree[$iCT]->extid				= $key->extid;// Picasa Album or Facebook Album
				$tree[$iCT]->extfbcatid			= $key->extfbcatid;
				// info about one image (not using recursive function)
				$tree[$iCT]->filename			= $key->filename;
				$tree[$iCT]->extm				= $key->extm;
				$tree[$iCT]->exts				= $key->exts;
				$tree[$iCT]->extw				= $key->extw;
				$tree[$iCT]->exth				= $key->exth;
				
				$tree[$iCT]->linkthumbnailpath	= '';
				$iCT++;
				
				$tree = $this->_categoryTree($data, $tree, $key->id, $show_text . " &raquo; ", $currentId );	
			}	
		}
		return($tree);
	}
	
	function imageResize($width, $height, $target)
	{
		//takes the larger size of the width and height and applies the
		//formula accordingly...this is so this script will work
		//dynamically with any size image
		if ($width > $height) {
			$percentage = ($target / $width);
		} else {
			$percentage = ($target / $height);
		}

		//gets the new value and applies the percentage, then rounds the value
		$width = round($width * $percentage);
		$height = round($height * $percentage);

		return array($width, $height);
	}
}
?>