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
		//ϲ������
		echo goodsAction($id,$config);
	}elseif($para == "bad"){
		//��ϲ������
		echo badsAction($id,$config);
	}elseif($para == "love"){
		echo lovesAction($id,$config);
	}
//----------------------------	
	/*
	 * ϲ�������Զ���һ����
	 */
	function goodsAction($id = 0,$config){
		sleep($config->sleep);
		$db = JFactory::getDbo();
	    $query_c = "update #__content set goods = goods +1 where id = ".$id;
			
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
	 * ��ϲ�������Զ���һ����
	 */
	function badsAction($id = 0,$config){
		sleep($config->sleep);
		$db = JFactory::getDbo();
	    $query_c = "update #__content set bads = bads +1 where id = ".$id;
			
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
	 * �������Զ���һ����
	 */
	function lovesAction($id = 0,$config){
		sleep($config->sleep);
		$db = JFactory::getDbo();
	    $query_c = "update #__content set loves = loves +1 where id = ".$id;
			
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