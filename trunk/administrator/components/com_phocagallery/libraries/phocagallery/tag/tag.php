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

class PhocaGalleryTag
{
	public function getTags($imgId, $select = 0) {
	
		$db =& JFactory::getDBO();
		
		if ($select == 1) {
			$query = 'SELECT r.tagid';
		} else {
			$query = 'SELECT a.*';
		}
		$query .= ' FROM #__phocagallery_tags AS a'
				//.' LEFT JOIN #__phocagallery AS f ON f.id = r.imgid'
				.' LEFT JOIN #__phocagallery_tags_ref AS r ON a.id = r.tagid'
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
	
	public function getTags1($imgId, $select = 0) {
	
		$db =& JFactory::getDBO();
		
		if ($select == 1) {
			$query = 'SELECT r.tagid';
		} else {
			$query = 'SELECT a.*';
		}
		$query .= ' FROM #__phocagallery_tags AS a'
				//.' LEFT JOIN #__phocagallery AS f ON f.id = r.imgid'
				.' LEFT JOIN #__phocagallery_tags_products_ref AS r ON a.id = r.tagid'
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
	
	public function storeTags($tagsArray, $imgId) {
	
	
		if ((int)$imgId > 0) {
			$db =& JFactory::getDBO();
			$query = ' DELETE '
					.' FROM #__phocagallery_tags_ref'
					. ' WHERE imgid = '. (int)$imgId;
			$db->setQuery($query);
			if (!$db->query()) {
				$this->setError('Database Error - Deleting Image Id Tags');
				return false;
			}
			
			if (!empty($tagsArray)) {
				
				$values 		= array();
				$valuesString 	= '';
				
				foreach($tagsArray as $k => $v) {
					$values[] = ' ('.(int)$imgId.', '.(int)$v.')';
				}
				
				if (!empty($values)) {
					$valuesString = implode($values, ',');
				
					$query = ' INSERT INTO #__phocagallery_tags_ref (imgid, tagid)'
								.' VALUES '.(string)$valuesString;

					$db->setQuery($query);
					if (!$db->query()) {
						$this->setError('Database Error - Insert Image Id Tags');
						return false;
					}
					
				}
			}
		}
	
	}
	
	public function storeProductTags($tagsArray, $imgId) {
	
	
		if ((int)$imgId > 0) {
			$db =& JFactory::getDBO();
			$query = ' DELETE '
					.' FROM #__phocagallery_tags_products_ref'
					. ' WHERE imgid = '. (int)$imgId;
			$db->setQuery($query);
			if (!$db->query()) {
				$this->setError('Database Error - Deleting Image Id Tags');
				return false;
			}
			
			if (!empty($tagsArray)) {
				
				$values 		= array();
				$valuesString 	= '';
				
				foreach($tagsArray as $k => $v) {
					$values[] = ' ('.(int)$imgId.', '.(int)$v.')';
				}
				
				if (!empty($values)) {
					$valuesString = implode($values, ',');
				
					$query = ' INSERT INTO #__phocagallery_tags_products_ref (imgid, tagid)'
								.' VALUES '.(string)$valuesString;

					$db->setQuery($query);
					if (!$db->query()) {
						$this->setError('Database Error - Insert Image Id Tags');
						return false;
					}
					
				}
			}
		}
	
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
	
	public function displayTags($imgId, $popupLink = 0) {
	
		$o 		= '';
		$db 	= JFactory::getDBO();
		$params = JComponentHelper::getParams('com_phocagallery') ;
				
		$query = 'SELECT a.id, a.title, a.link_ext, a.link_cat'
		.' FROM #__phocagallery_tags AS a'
		.' LEFT JOIN #__phocagallery_tags_ref AS r ON r.tagid = a.id'
		.' WHERE r.imgid = '.(int)$imgId;

		$db->setQuery($query);
		$imgObject = $db->loadObjectList();
		
		if (!$db->query()) {
			$this->setError($db->getErrorMsg());
			return false;
		}
		
		/*
		if ($popupLink == 1) {
			$tl	= 0;
		} else  {
			$tl	= $params->get( 'tags_links', 0 );
		}*/
		
		$targetO = '';
		if ($popupLink == 1) {
			$targetO = 'target="_parent"';
		}
		$tl	= $params->get( 'tags_links', 0 );

		foreach ($imgObject as $k => $v) {
			$o .= '<span>';
			if ($tl == 0) {
				$o .= $v->title;
			} else if ($tl == 1) {
				if ($v->link_ext != '') {
					$o .= '<a href="'.$v->link_ext.'" '.$targetO.'>'.$v->title.'</a>';
				} else {
					$o .= $v->title;
				}
			} else if ($tl == 2) {
				
				if ($v->link_cat != '') {
					$query = 'SELECT a.id, a.alias'
					.' FROM #__phocagallery_categories AS a'
					.' WHERE a.id = '.(int)$v->link_cat;

					$db->setQuery($query, 0, 1);
					$category = $db->loadObject();
					
					if (!$db->query()) {
						$this->setError($db->getErrorMsg());
						return false;
					}
					if (isset($category->id) && isset($category->alias)) {
						$link = PhocaGalleryRoute::getCategoryRoute($category->id, $category->alias);
						$o .= '<a href="'.$link.'" '.$targetO.'>'.$v->title.'</a>';
					} else {
						$o .= $v->title;
					}
				} else {
					$o .= $v->title;
				}
			} else if ($tl == 3) {
				$link = PhocaGalleryRoute::getCategoryRouteByTag($v->id);
				$o .= '<a href="'.$link.'" '.$targetO.'>'.$v->title.'</a>';
			}
			
			$o .= '</span> ';
		}

		return $o;
	}

//获得图片tag
	public function displayTags_th($imgId, $popupLink = 0) {
	
		$o 		= '';
		$db 	= JFactory::getDBO();
		//$params = JComponentHelper::getParams('com_phocagallery') ;
				
		$query = 'SELECT a.id, a.title, a.link_ext, a.link_cat'
		.' FROM #__phocagallery_tags AS a'
		.' LEFT JOIN #__phocagallery_tags_ref AS r ON r.tagid = a.id'
		.' WHERE r.imgid = '.(int)$imgId;

		$db->setQuery($query);
		$imgObject = $db->loadObjectList();
		
		if (!$db->query()) {
			$this->setError($db->getErrorMsg());
			return false;
		}
		
		/*
		if ($popupLink == 1) {
			$tl	= 0;
		} else  {
			$tl	= $params->get( 'tags_links', 0 );
		}*/
		$o = "<strong>标签：</strong>";

		foreach ($imgObject as $k => $v) {
			$o .= "<span class='txt-data'>";
			$o .= $v->title;
			$o .= '</span> ';
		}

		return $o;
	}
	
}