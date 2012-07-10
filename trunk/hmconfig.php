<?php
class HMConfig {
	public $img_server_count=1;
	public $img_server1='e:\pics1';
	public $img_server2='e:\pics2';
	public $img_server3='e:\pics3';
	
	public $img_provider_count=1;
	public $img_provider1='http:////localhost:82/';
	public $img_provider2='http:////localhost:83/';
	public $img_provider3='http:////localhost:84/';
	
	public $js_provider_count=1;
	public $js_provider1='http:////localhost/mmall/templates/fjt007_j25/';
	public $js_provider2='http:////localhost:83/';
	public $js_provider3='http:////localhost:84/';
	
	public $css_provider_count=1;
	public $css_provider1='http:////localhost/mmall/templates/fjt007_j25/';
	public $css_provider2='http:////localhost:83/';
	public $css_provider3='http:////localhost:84/';
	
	public $tg_url = 'http://27.115.86.10:3007/api/tg_getinfos.php?id1=';
	public $sg_url = 'http://27.115.86.10:3008/api/sg_getinfo.php?id=';
	public $shop_url = 'http://27.115.86.10:3008/api/shop_getinfo.php?id=';
	
	public function getJsProvider(){
		$cur = rand(1, $this->js_provider_count);
		$prop = 'js_provider'.$cur;
		return $this->$prop;
	}
	
	public function getCssProvider(){
		$cur = rand(1, $this->css_provider_count);
		$prop = 'css_provider'.$cur;
		return $this->$prop;
	}
	
}