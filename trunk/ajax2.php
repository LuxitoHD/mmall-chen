<?php
	define('_JEXEC', 1);
	define('DS', DIRECTORY_SEPARATOR);
	
	if (file_exists(dirname(__FILE__) . '/defines.php')) {
		include_once dirname(__FILE__) . '/defines.php';
	}
	
	if (!defined('_JDEFINES')) {
		define('JPATH_BASE', dirname(__FILE__));
		require_once JPATH_BASE.'/includes/defines.php';
	}
	
	require_once JPATH_BASE.'/includes/framework.php';
	
	
	$para = JRequest::getVar('para');
	$id = JRequest::getVar('id');
	$id = (int)$id;
	if($para == "good"){
		//喜欢操作
		echo goodsAction($id);
	}elseif($para == "bad"){
		//不喜欢操作
		echo badsAction($id);
	}
//----------------------------	
	/*
	 * 喜欢人数自动加一操作
	 */
	function goodsAction($id = 0){
		
		$db = JFactory::getDbo();
	    $query_c = "update #__phocagallery set goods = goods +1 where id = ".$id;
			
		$db->setQuery($query_c);
		if($db->Query()){
			return 'succ';//成功 喜欢人数自动加1
		}else{
			return "fail";
		}
	}
	/*
	 * 不喜欢人数自动加一操作
	 */
	function badsAction($id = 0){
		
		$db = JFactory::getDbo();
	    $query_c = "update #__phocagallery set bads = bads +1 where id = ".$id;
			
		$db->setQuery($query_c);
		if($db->Query()){
			return 'succ';//成功 不喜欢人数自动加1
		}else{
			return "fail";
		}
	}
	
?>