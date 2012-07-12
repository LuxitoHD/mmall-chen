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
	require_once JPATH_BASE.'/hmconfig.php';
	$config = new HMConfig();
	
	/*$para = JRequest::getVar('para');
	$id = JRequest::getVar('id');
	*/
$id = $_POST['id'];
$para = $_POST['para'];

	$id = (int)$id;
	if($para == "good"){
		//喜欢操作
		echo goodsAction($id,$config);
	}elseif($para == "bad"){
		//不喜欢操作
		echo badsAction($id,$config);
	}elseif($para == "love"){
		echo lovesAction($id,$config);
	}
//----------------------------	
	/*
	 * 喜欢人数自动加一操作
	 */
	function goodsAction($id = 0,$config){
		sleep($config->sleep);
		$db = JFactory::getDbo();
	    $query_c = "update #__phocagallery set goods = goods +1 where id = ".$id;
			
		$db->setQuery($query_c);
		if($db->Query()){
			/*$query_s = "select goods from #__phocagallery where id = ".$id;
			$db->setQuery($query_s);
			$goods_counts = $db->loadResult();
			
			return $goods_counts;*/
			return "succ";
		}else{
			return "fail";
		}
	}
	/*
	 * 不喜欢人数自动加一操作
	 */
	function badsAction($id = 0,$config){
		sleep($config->sleep);
		$db = JFactory::getDbo();
	    $query_c = "update #__phocagallery set bads = bads +1 where id = ".$id;
			
		$db->setQuery($query_c);
		if($db->Query()){
			/*$query_s = "select bads from #__phocagallery where id = ".$id;
			$db->setQuery($query_s);
			$bads_counts = $db->loadResult();
			return $bads_counts;*/
			return "succ";
		}else{
			return "fail";
		}
	}

	/*
	 * 爱人数自动加一操作
	 */
	function lovesAction($id = 0,$config){
		sleep($config->sleep);
		$db = JFactory::getDbo();
	    $query_c = "update #__phocagallery set loves = loves +1 where id = ".$id;
			
		$db->setQuery($query_c);
		if($db->Query()){
			/*$query_s = "select loves from #__phocagallery where id = ".$id;
			$db->setQuery($query_s);
			$loves_counts = $db->loadResult();
			return $loves_counts;
			*/
			return "succ";
		}else{
			return "fail";
		}
	}
	
?>