<?php
defined('_JEXEC') or die('Restricted access');
echo "\n\n";

foreach ($this->tagData1 as $i => $item){
	if($i==6)
		break;
	echo '<div class="pg-imgbg-box">';
	echo '<div class="pg-imgbg">';
	echo '<h3><a href="'.$this->tagData1[$i]->link.'">'.$this->tagData1[$i]->title.'</a></h3>';
	echo '<a class="items-list" href="'.$this->tagData1[$i]->link.'">';

	echo JHtml::_( 'image', $this->tagData1[$i]->linkthumbnailpath, str_replace('&raquo;','-',$this->tagData1[$i]->title),array('style' => ''));
	
	echo '</a>';
	echo '<p class="follow-num">有112234人关注</p><div class="other"><a class="btn-link" title="去看看" href="'.$this->tagData1[$i]->link.'">去看看</a></div>';
	echo '</div>';
	echo '</div>';
}
echo "\n";
?>