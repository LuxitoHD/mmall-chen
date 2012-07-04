<?php
defined('_JEXEC') or die('Restricted access');
echo "\n\n";

foreach ($this->tagData as $i => $item){
	if($i==6)
		break;
	echo '<div class="pg-imgbg-box">';
	echo '<div class="pg-imgbg">';
	echo '<h3><a href="'.$this->tagData[$i]->link.'">'.$this->tagData[$i]->title.'</a></h3>';
	echo '<a class="items-list" href="'.$this->tagData[$i]->link.'">';

	echo JHtml::_( 'image', $this->tagData[$i]->linkthumbnailpath, str_replace('&raquo;','-',$this->tagData[$i]->title),array('style' => ''));
	
	echo '</a>';
	echo '<p class="follow-num">有'.$item->hits.'人关注</p><div class="other"><a class="btn-link" title="去看看" href="'.$this->tagData[$i]->link.'">去看看</a></div>';
	echo '</div>';
	echo '</div>';
}
echo "\n";
?>