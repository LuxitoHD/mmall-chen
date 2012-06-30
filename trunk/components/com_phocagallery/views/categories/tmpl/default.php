<?php
defined('_JEXEC') or die('Restricted access'); 

if ($this->tmpl['phocagallerywidth'] != '') {
	$centerPage = '';
	if ($this->tmpl['phocagallerycenter'] == 2 || $this->tmpl['phocagallerycenter'] == 3) {
		$centerPage = 'margin: auto;';
	}
	echo '<div id="phocagallery" style="width:'. $this->tmpl['phocagallerywidth'].'px;'.$centerPage.'" class="pg-categories-view'.$this->params->get( 'pageclass_sfx' ).'">';
} else {
	echo '<div id="phocagallery" class="pg-categories-view'.$this->params->get( 'pageclass_sfx' ).'">';
}

if ( $this->params->get( 'show_page_heading' ) ) { 
	echo '<h1>'. $this->escape($this->params->get('page_heading')) . '</h1>';
}

echo '<div id="pg-icons" class="firstScreen">';
echo '	<div class="aside_wrap">';
echo '		<dl class="item_style">';
echo '        	<dt><span>风格</span></dt>';
echo '        	<dd>';
				foreach ($this->tagData as $i => $item){
					if($i==6)
						break;
					echo '<a title="" href="'.$item->link.'">'.$item->title.'</a>';
				}
echo '			</dd>';
echo '      </dl>';
echo '		<dl class="item_speace">';
echo '        	<dt><span>空间</span></dt>';
echo '        	<dd>';
        		foreach ($this->tagData1 as $i => $item){
					if($i==6)
						break;
					echo '<a title="" href="'.$item->link.'">'.$item->title.'</a>';
				}
echo '			</dd>';
echo '      </dl>';
echo '		<dl class="item_group">';
echo '        	<dt><span>人群</span></dt>';
echo '        	<dd>';
				foreach ($this->tagData2 as $i => $item){
					if($i==6)
						break;
					echo '<a title="" href="'.$item->link.'">'.$item->title.'</a>';
				}
echo '			<dd>';
echo '      </dl>';
require_once JPATH_SITE . '/components/com_content/helpers/route.php';
//JHtml::addIncludePath(JPATH_SITE.'/components/com_content/helpers');
$images = json_decode($this->lead_items->images);
$link = JRoute::_(ContentHelperRoute::getArticleRoute($this->lead_items->slug, $this->lead_items->catid));

	function cut_str($string, $sublen, $start = 0, $code = 'UTF-8') 
     {
     	if($code == 'UTF-8')
     	{
     		$pa ="/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
     		preg_match_all($pa, $string, $t_string); if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen));
     		return join('', array_slice($t_string[0], $start, $sublen));
     	}
     	else
     	{
     		$start = $start*2;
     		$sublen = $sublen*2;
     		$strlen = strlen($string);
     		$tmpstr = ''; for($i=0; $i<$strlen; $i++)
     		{
     			if($i>=$start && $i<($start+$sublen))
     			{
     				if(ord(substr($string, $i, 1))>129)
     				{
     					$tmpstr.= substr($string, $i, 2);
     				}
     				else
     				{
     					$tmpstr.= substr($string, $i, 1);
     				}
     			}
     			if(ord(substr($string, $i, 1))>129) $i++;
     		}
     		if(strlen($tmpstr)<$strlen ) $tmpstr.= "";
     		return $tmpstr;
     	}
     }
echo '		<dl class="pic_text">';
echo '      	<dt><img title="'.$this->lead_items->title.'" alt="'.$this->lead_items->title.'" src="'.$images->image_intro.'"></dt>';
echo '        	<dd>';
echo '         		<h3><a title="" href="'.$link.'">'.$this->lead_items->title.'</a></h3>';
echo '          	<p class="desc">'.cut_str($this->lead_items->introtext,20,0,'UTF-8').'……<a title="查看" href="'.$link.'">[查看]</a></p>';
echo '        	</dd>';
     //  echo $this->lead_items->title;
     
echo '      </dl>';
echo '		<ul class="list">';
//        <li><a title="" href="#">65平超养眼 8万复式婚房(组图)</a></li>
//        <li><a title="" href="#">达人教你 如何制作绳编手链(组图)</a></li>
//        <li><a title="" href="#">65平超养眼 8万复式婚房(组图)</a></li>
//        <li><a title="" href="#">达人教你 如何制作绳编手链(组图)</a></li>
			foreach ($this->items as $i => $item){
				if($i==0){
					continue;
				}
				$link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid));	
				echo '<li><a title="" href="'.$link.'">'.$item->title.'</a></li>';
			}
echo '      </ul>';
echo '	</div>';
echo '</div>';
echo '<div style="clear:both"></div>';

if ($this->tmpl['categories_description'] != '') {
	echo '<div class="phocagallery-cat-desc" >'.$this->tmpl['categories_description'].'</div>';
}

//第一列表
echo '<div class="sectionWrap">';
echo '<h2 class="hdTitle">装客们喜欢的<span>风格</span></h2>
    <ul class="cate-nav-list">';
foreach ($this->tagData as $i => $item){
	echo '<li><a title="" href="'.$item->link.'">'.$item->title.'</a></li>';
}
echo'</ul>';


echo '<form action="'.$this->tmpl['action'].'" method="post" name="adminForm">';
if ($this->tmpl['displayimagecategories'] == 1) {	
	echo $this->loadTemplate('catimg');// TABLE LAYOUT - Categories and Images
} else if ($this->tmpl['displayimagecategories'] == 2){
	echo $this->loadTemplate('catimgdetail');// DETAIL LAYOUT 2 (with columns)
} else if ($this->tmpl['displayimagecategories'] == 3){
	echo $this->loadTemplate('catimgdetailfloat');// DETAIL LAYOUT 3 - FLOAT - Every categoy will float Categories, images and detail information (Float)
} else if ($this->tmpl['displayimagecategories'] == 4){
	echo $this->loadTemplate('catimgdesc');// LAYOUT 4 (with columns) (easy categories, images and description)
} else if ($this->tmpl['displayimagecategories'] == 5){
	echo $this->loadTemplate('custom');// LAYOUT 5 Custom - float
} else {
	echo $this->loadTemplate('noimg');// UL LAYOUT - Categories Without Images
}

if (count($this->categories)) {
	echo '<div class="pg-center"><div class="pagination">';
	if ($this->params->get('show_ordering_categories')) {
		echo '<div class="pg-inline">'
			.JText::_('COM_PHOCAGALLERY_ORDER_FRONT') .'&nbsp;'
			.$this->tmpl['ordering']
			.'</div>';
	}
	if ($this->params->get('show_pagination_limit_categories')) {	
		echo '<div class="pg-inline">'
			.JText::_('COM_PHOCAGALLERY_DISPLAY_NUM') .'&nbsp;'
			.$this->tmpl['pagination']->getLimitBox()
			.'</div>';
	}
	if ($this->params->get('show_pagination_categories')) {
		echo '<div style="margin:0 10px 0 10px;display:inline;" class="sectiontablefooter'.$this->params->get( 'pageclass_sfx' ).'" id="pg-pagination" >'
			.$this->tmpl['pagination']->getPagesLinks()
			.'</div>'
		
			.'<div style="margin:0 10px 0 10px;display:inline;" class="pagecounter">'
			.$this->tmpl['pagination']->getPagesCounter()
			.'</div>';
	}
	echo '</div></div>'. "\n";
}

echo '</form>';
echo '</div>';

//第二列表
echo '<div class="sectionWrap">';
echo '<h2 class="hdTitle">装客们喜欢的<span>空间</span></h2>
    <ul class="cate-nav-list">';
foreach ($this->tagData1 as $i => $item){
	echo '<li><a title="" href="'.$item->link.'">'.$item->title.'</a></li>';
}
echo '</ul>';

echo '<form action="'.$this->tmpl['action'].'" method="post" name="adminForm">';
if ($this->tmpl['displayimagecategories'] == 1) {
	echo $this->loadTemplate('catimg1');// TABLE LAYOUT - Categories and Images
} else if ($this->tmpl['displayimagecategories'] == 2){
	echo $this->loadTemplate('catimgdetail');// DETAIL LAYOUT 2 (with columns)
} else if ($this->tmpl['displayimagecategories'] == 3){
	echo $this->loadTemplate('catimgdetailfloat');// DETAIL LAYOUT 3 - FLOAT - Every categoy will float Categories, images and detail information (Float)
} else if ($this->tmpl['displayimagecategories'] == 4){
	echo $this->loadTemplate('catimgdesc');// LAYOUT 4 (with columns) (easy categories, images and description)
} else if ($this->tmpl['displayimagecategories'] == 5){
	echo $this->loadTemplate('custom');// LAYOUT 5 Custom - float
} else {
	echo $this->loadTemplate('noimg');// UL LAYOUT - Categories Without Images
}


if (count($this->categories)) {
	echo '<div class="pg-center"><div class="pagination">';
	if ($this->params->get('show_ordering_categories')) {
		echo '<div class="pg-inline">'
			.JText::_('COM_PHOCAGALLERY_ORDER_FRONT') .'&nbsp;'
			.$this->tmpl['ordering']
			.'</div>';
	}
	if ($this->params->get('show_pagination_limit_categories')) {	
		echo '<div class="pg-inline">'
			.JText::_('COM_PHOCAGALLERY_DISPLAY_NUM') .'&nbsp;'
			.$this->tmpl['pagination']->getLimitBox()
			.'</div>';
	}
	if ($this->params->get('show_pagination_categories')) {
		echo '<div style="margin:0 10px 0 10px;display:inline;" class="sectiontablefooter'.$this->params->get( 'pageclass_sfx' ).'" id="pg-pagination" >'
			.$this->tmpl['pagination']->getPagesLinks()
			.'</div>'
		
			.'<div style="margin:0 10px 0 10px;display:inline;" class="pagecounter">'
			.$this->tmpl['pagination']->getPagesCounter()
			.'</div>';
	}
	echo '</div></div>'. "\n";
}

echo '</form>';
echo '</div>';


//第三列表
echo '<div class="sectionWrap">';
echo '<h2 class="hdTitle">最活跃的<span>装客</span></h2>
    <ul class="cate-nav-list">';
foreach ($this->tagData2 as $i => $item){
	echo '<li><a title="" href="'.$item->link.'">'.$item->title.'</a></li>';
}
echo '</ul>';

echo '<form action="'.$this->tmpl['action'].'" method="post" name="adminForm">';
if ($this->tmpl['displayimagecategories'] == 1) {	
	echo $this->loadTemplate('catimg2');// TABLE LAYOUT - Categories and Images
} else if ($this->tmpl['displayimagecategories'] == 2){
	echo $this->loadTemplate('catimgdetail');// DETAIL LAYOUT 2 (with columns)
} else if ($this->tmpl['displayimagecategories'] == 3){
	echo $this->loadTemplate('catimgdetailfloat');// DETAIL LAYOUT 3 - FLOAT - Every categoy will float Categories, images and detail information (Float)
} else if ($this->tmpl['displayimagecategories'] == 4){
	echo $this->loadTemplate('catimgdesc');// LAYOUT 4 (with columns) (easy categories, images and description)
} else if ($this->tmpl['displayimagecategories'] == 5){
	echo $this->loadTemplate('custom');// LAYOUT 5 Custom - float
} else {
	echo $this->loadTemplate('noimg');// UL LAYOUT - Categories Without Images
}


if (count($this->categories)) {
	echo '<div class="pg-center"><div class="pagination">';
	if ($this->params->get('show_ordering_categories')) {
		echo '<div class="pg-inline">'
			.JText::_('COM_PHOCAGALLERY_ORDER_FRONT') .'&nbsp;'
			.$this->tmpl['ordering']
			.'</div>';
	}
	if ($this->params->get('show_pagination_limit_categories')) {	
		echo '<div class="pg-inline">'
			.JText::_('COM_PHOCAGALLERY_DISPLAY_NUM') .'&nbsp;'
			.$this->tmpl['pagination']->getLimitBox()
			.'</div>';
	}
	if ($this->params->get('show_pagination_categories')) {
		echo '<div style="margin:0 10px 0 10px;display:inline;" class="sectiontablefooter'.$this->params->get( 'pageclass_sfx' ).'" id="pg-pagination" >'
			.$this->tmpl['pagination']->getPagesLinks()
			.'</div>'
		
			.'<div style="margin:0 10px 0 10px;display:inline;" class="pagecounter">'
			.$this->tmpl['pagination']->getPagesCounter()
			.'</div>';
	}
	echo '</div></div>'. "\n";
}

echo '</form>';
echo '</div>';

echo '</div>';
echo PhocaGalleryUtils::footer();