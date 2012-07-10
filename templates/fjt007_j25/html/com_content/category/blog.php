<?php
/**
 * @version		$Id: blog.php 20960 2011-03-12 14:14:00Z chdemko $
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers');
$document			= &JFactory::getDocument();

//css
$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/css/base.css');
$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/css/global.css');
$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/css/info.css');
$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/css/layout.css');
$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/css/reset.css');
?>
<div id="content"> 
  <div class="articleWrap"> 
    <div class="listingWrap">
	    <div class="crumbs clearfix"> 
		  <ul> 
		    <li class="base"> 
		      <div class="logo"></div> 
		      <span>您现在的位置：<a href="index.php" title="">首页</a></span> </li> 
		    <li class="arrow">&gt;</li> 
		    <li><a href="<?php echo JRoute::_("index.php?option=com_content&view=category&layout=blog&id=78&Itemid=". JRequest::getVar('Itemid', 0, '', 'int'));?>" title="">装修风水</a></li> 
		    <li class="arrow">&gt;</li> 
		    <li class="terminal"><?php echo $this->category->title;?></li> 
		  </ul> 
		</div> 
 
      <div class="listingCon"> 
        <h2 class="hdTitle">文章列表</h2> 
        <?php //if (count($this->children[$this->category->id]) > 0 && $this->maxLevel != 0) : ?>
        <ul class="cate-nav-list"> 
        <?php //foreach($this->children[$this->category->id] as $id => $child) : ?>
          <!-- <li>
          	  <a href="<?php echo JRoute::_("index.php?option=com_content&view=category&layout=blog&id=".$child->id."&Itemid=". JRequest::getVar('Itemid', 0, '', 'int'));?>" title="">
          		<?php //echo $this->escape($child->title); ?>
          	  </a>
          </li> -->
          <li><a href="<?php echo JRoute::_("index.php?option=com_content&view=category&layout=blog&id=79&Itemid=". JRequest::getVar('Itemid', 0, '', 'int'));?>" title="">旺财运</a></li> 
          <li><a href="<?php echo JRoute::_("index.php?option=com_content&view=category&layout=blog&id=80&Itemid=". JRequest::getVar('Itemid', 0, '', 'int'));?>" title="">旺事业</a></li> 
          <li><a href="<?php echo JRoute::_("index.php?option=com_content&view=category&layout=blog&id=81&Itemid=". JRequest::getVar('Itemid', 0, '', 'int'));?>" title="">旺感情</a></li> 
          <li><a href="<?php echo JRoute::_("index.php?option=com_content&view=category&layout=blog&id=82&Itemid=". JRequest::getVar('Itemid', 0, '', 'int'));?>" title="">旺桃花</a></li>
        <?php //endforeach; ?>
        </ul> 
        <?php //endif;?>
        <div class="chapterTotal">共有<span class="txt-data webtxt"><?php echo $this->pagination->total;?></span>篇文章</div> 
        <div class="listing">
          <?php foreach ($this->intro_items as &$item) : 
          			$this->item = &$item;
          			$images = json_decode($this->item->images);
          			$keyword = $this->item->metakey;
          			
          ?>
          <dl> 
            <dt><a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid)); ?>" title=""><img width="179" height="121" src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="" title=""></a></dt> 
            <dd> 
              <h3><a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid)); ?>" title=""><?php echo $this->escape($this->item->title); ?></a></h3> 
              <p class="info">点击数：<span class="webtxt"><?php echo $this->item->hits; ?>次</span><span class="time"><?php echo substr(JHtml::_('date', $this->item->created), 0,10);?></span></p> 
              <p class="tags" style="margin: 0;margin-top:-32px;"><strong>关键词：</strong><span class="txt-data"><?php echo $keyword;?></span></p> 
              <?php echo $this->item->introtext; ?>
              <div class="other"><a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid)); ?>" title="">阅读全文</a></div> 
            </dd> 
          </dl> 
          <?php endforeach; ?>
         <!--  <dl> 
            <dt><a href="#" title=""><img src="images/info/items_1.jpg" alt="" title=""></a></dt> 
            <dd> 
              <h3><a href="#" title="">厨房色主张 50图诠释橱柜色彩定义</a></h3> 
              <p class="info">点击数：<span class="webtxt">9988次</span><span class="time">2012-6-14</span></p> 
              <p class="tags"><strong>关键词：</strong><span class="txt-data">橱柜设计</span><span class="txt-data">橱柜颜色</span><span class="txt-data">整体橱柜</span><span class="txt-data">橱柜尺寸</span></p> 
              <p class="desc">从浅到深的蓝，各种色调的红，百搭的白......充满梦幻色彩的整体橱柜，让人始终保持清澈，浪漫的感觉，橱柜在这样的空间里，显得纯洁可爱，惹人遐思。50图为您呈现多彩整体橱柜，诠释橱柜色彩定义。</p> 
              <div class="other"><a href="#" title="">阅读全文</a></div> 
            </dd> 
          </dl> 
          <dl> 
            <dt><a href="#" title=""><img src="images/info/items_2.jpg" alt="" title=""></a></dt> 
            <dd> 
              <h3><a href="#" title="">厨房色主张 50图诠释橱柜色彩定义</a></h3> 
              <p class="info">点击数：<span class="webtxt">9988次</span><span class="time">2012-6-14</span></p> 
              <p class="tags"><strong>关键词：</strong><span class="txt-data">橱柜设计</span><span class="txt-data">橱柜颜色</span><span class="txt-data">整体橱柜</span><span class="txt-data">橱柜尺寸</span></p> 
              <p class="desc">从浅到深的蓝，各种色调的红，百搭的白......充满梦幻色彩的整体橱柜，让人始终保持清澈，浪漫的感觉，橱柜在这样的空间里，显得纯洁可爱，惹人遐思。50图为您呈现多彩整体橱柜，诠释橱柜色彩定义。</p> 
              <div class="other"><a href="#" title="">阅读全文</a></div> 
            </dd> 
          </dl> 
          <dl> 
            <dt><a href="#" title=""><img src="images/info/items_3.jpg" alt="" title=""></a></dt> 
            <dd> 
              <h3><a href="#" title="">厨房色主张 50图诠释橱柜色彩定义</a></h3> 
              <p class="info">点击数：<span class="webtxt">9988次</span><span class="time">2012-6-14</span></p> 
              <p class="tags"><strong>关键词：</strong><span class="txt-data">橱柜设计</span><span class="txt-data">橱柜颜色</span><span class="txt-data">整体橱柜</span><span class="txt-data">橱柜尺寸</span></p> 
              <p class="desc">从浅到深的蓝，各种色调的红，百搭的白......充满梦幻色彩的整体橱柜，让人始终保持清澈，浪漫的感觉，橱柜在这样的空间里，显得纯洁可爱，惹人遐思。50图为您呈现多彩整体橱柜，诠释橱柜色彩定义。</p> 
              <div class="other"><a href="#" title="">阅读全文</a></div> 
            </dd> 
          </dl> 
          <dl> 
            <dt><a href="#" title=""><img src="images/info/items_4.jpg" alt="" title=""></a></dt> 
            <dd> 
              <h3><a href="#" title="">厨房色主张 50图诠释橱柜色彩定义</a></h3> 
              <p class="info">点击数：<span class="webtxt">9988次</span><span class="time">2012-6-14</span></p> 
              <p class="tags"><strong>关键词：</strong><span class="txt-data">橱柜设计</span><span class="txt-data">橱柜颜色</span><span class="txt-data">整体橱柜</span><span class="txt-data">橱柜尺寸</span></p> 
              <p class="desc">从浅到深的蓝，各种色调的红，百搭的白......充满梦幻色彩的整体橱柜，让人始终保持清澈，浪漫的感觉，橱柜在这样的空间里，显得纯洁可爱，惹人遐思。50图为您呈现多彩整体橱柜，诠释橱柜色彩定义。</p> 
              <div class="other"><a href="#" title="">阅读全文</a></div> 
            </dd> 
          </dl>  -->
        </div> 
        
        <?php /*if (($this->params->def('show_pagination', 1) == 1  || ($this->params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1)) : ?>
			<div id="pagination">
							<?php  if ($this->params->def('show_pagination_results', 1)) : ?>
							<p class="counter">
									<?php echo $this->pagination->getPagesCounter(); ?>
							</p>
	
					<?php endif; ?>
					<?php echo $this->pagination->getPagesLinks(); ?>
			</div>
		<?php  endif;*/ ?>
        <div class="paginationWrap">
		        <div class="pageList clearfix"> 
		       		 <?php echo $this->pagination->getPagesLinks(); ?>
		        
					  <!-- <ul class="pageList_body clearfix"> 
					    <li class="first"><a href="#">首页</a></li> 
					    <li class="prev"><a href="#">上一页</a></li> 
					    <li><a href="#">1</a></li> 
					    <li><a href="#">2</a></li> 
					    <li><a class="this" href="#">3</a></li> 
					    <li><a href="#">4</a></li> 
					    <li><a href="#">5</a></li> 
					    <li><a class="dot" href="###">...</a></li> 
					    <li class="next"><a href="javascript:;">下一页</a></li> 
					    <li class="last"><a href="javascript:;">尾页</a></li> 
					    <li class="page-nub">共<span>40</span>页，到第
					      <input type="text" name="" id="" /> 
					      页
					      <button type="submit">确定</button> 
					    </li> 
					  </ul>  -->
					  
					  
				</div>

		</div> 
      </div> 
    </div> 
      <div class="chapterIntro"> 
        <h2>相关文章推荐</h2> 
        <div class="list"> 
        
        	<?php 
        	$featuredArticle = $this->featuredArticle;
        	$length = count($featuredArticle);
        	
        	//取得三个图片
        	$img_tou = array();
        	$coutou = 0;
        	foreach ($featuredArticle as $item_t){
        		if($coutou == 3){
        	 		break;
        	 	}
        	 	$images_mi = json_decode($item_t->images);
        	 	$imgSour = htmlspecialchars($images_mi->image_intro);
        	 	if(strlen($imgSour)>3){
        	 		$img_tou[$coutou]["imgs"] = $imgSour;
        	 		$img_tou[$coutou]["id"] = $item_t->id;
        	 		$img_tou[$coutou]["title"] = $item_t->title;
        	 		$coutou++;
        	 	}
        	}

        	$featuredArticle_1 = array();
			$featuredArticle_2 = array();
			$featuredArticle_3 = array();
        	if($length<7){
				$featuredArticle_1 = $featuredArticle;
			}else if($length>6 && $length< 13){
				$featuredArticle_1 = array_slice($featuredArticle, 0,6);
				$featuredArticle_2 = array_slice($featuredArticle, 6,6);
			}else{
				$featuredArticle_1 = array_slice($featuredArticle, 0,6);
				$featuredArticle_2 = array_slice($featuredArticle, 6,6);
				$featuredArticle_3 = array_slice($featuredArticle, 12,6);
			}
			
        	?>
        
          <ul class="items-list"> 
            <li class="except"><a href="<?php echo JRoute::_("index.php?option=com_content&view=article&&layout=blog&id=".$img_tou[0]["id"]."&Itemid=". JRequest::getVar('Itemid', 0, '', 'int'));?>" title="<?php echo $img_tou[0]["title"];?>"><img width="200" height="135"  src="<?php echo $img_tou[0]["imgs"];?>" alt="" title=""></a></li> 
         <?php foreach ($featuredArticle_1 as $mei) : ?>
            <li><a href="<?php echo JRoute::_("index.php?option=com_content&view=article&&layout=blog&id=".$mei->id."&Itemid=". JRequest::getVar('Itemid', 0, '', 'int'));?>" title=""><?php echo $mei->title;?></a></li>
         <?php endforeach; ?>
          </ul> 
          <ul class="items-list"> 
            <li class="except"><a href="<?php echo JRoute::_("index.php?option=com_content&view=article&&layout=blog&id=".$img_tou[1]["id"]."&Itemid=". JRequest::getVar('Itemid', 0, '', 'int'));?>" title="<?php echo $img_tou[1]["title"];?>"><img width="200" height="135"  src="<?php echo $img_tou[1]["imgs"];?>" alt="" title=""></a></li> 
         <?php foreach ($featuredArticle_2 as $mei) : ?>
            <li><a href="<?php echo JRoute::_("index.php?option=com_content&view=article&&layout=blog&id=".$mei->id."&Itemid=". JRequest::getVar('Itemid', 0, '', 'int'));?>" title=""><?php echo $mei->title;?></a></li>
         <?php endforeach; ?>
          </ul> 
          <ul class="items-list"> 
            <li class="except"><a href="<?php echo JRoute::_("index.php?option=com_content&view=article&&layout=blog&id=".$img_tou[2]["id"]."&Itemid=". JRequest::getVar('Itemid', 0, '', 'int'));?>" title="<?php echo $img_tou[2]["title"];?>"><img width="200" height="135" src="<?php echo $img_tou[2]["imgs"];?>" alt="" title=""></a></li> 
         <?php foreach ($featuredArticle_3 as $mei) : ?>
            <li><a href="<?php echo JRoute::_("index.php?option=com_content&view=article&&layout=blog&id=".$mei->id."&Itemid=". JRequest::getVar('Itemid', 0, '', 'int'));?>" title=""><?php echo $mei->title;?></a></li>
         <?php endforeach; ?>
          </ul> 
        </div> 
      </div> 
  </div> 
  <div class="asideWrap"> 
    <div class="bord"> 
      <div class="introInfor"> 
<h2>关联商品</h2> 

<?php 
			
        	$product = $this->product;
        	if(isset($product)){
	        	foreach ($product as $item){      		
	?>
				  <dl>
				    <dt><a href="<?php echo $item->url;?>" title=""><img src="<?php echo $item->filename; ?>" alt="" title="" width="<?php echo $item->pic_width; ?>" height="<?php echo $item->pic_height; ?>"></a></dt>
				    <dd>
				      <h3><a href="<?php echo $item->url;?>" title=""><?php echo $item->title;?></a></h3>
				      <p class="price"><span class="webtxt"><i class="rmb">&yen;</i><i class="txt-data"><?php echo $item->price;?></i></span></p>
				    </dd>
				  </dl>
	<?php		
	        	}
        	}
?> 


<!-- 
  <dl> 
    <dt><a href="#" title=""><img src="images/info/other_0.jpg" alt="" title=""></a></dt> 
    <dd> 
      <h3><a href="#" title="">【吉屋】布艺沙发巾</a></h3> 
      <p class="price"><span class="webtxt"><i class="rmb">&yen;</i><i class="txt-data">95.00</i></span></p> 
    </dd> 
  </dl> 
  <dl> 
    <dt><a href="#" title=""><img src="images/info/other_1.jpg" alt="" title=""></a></dt> 
    <dd> 
      <h3><a href="#" title="">【吉屋】布艺沙发巾</a></h3> 
      <p class="price"><span class="webtxt"><i class="rmb">&yen;</i><i class="txt-data">95.00</i></span></p> 
    </dd> 
  </dl> 
  <dl> 
    <dt><a href="#" title=""><img src="images/info/other_2.jpg" alt="" title=""></a></dt> 
    <dd> 
      <h3><a href="#" title="">【吉屋】布艺沙发巾</a></h3> 
      <p class="price"><span class="webtxt"><i class="rmb">&yen;</i><i class="txt-data">95.00</i></span></p> 
    </dd> 
  </dl> 
  <dl> 
    <dt><a href="#" title=""><img src="images/info/other_3.jpg" alt="" title=""></a></dt> 
    <dd> 
      <h3><a href="#" title="">【吉屋】布艺沙发巾</a></h3> 
      <p class="price"><span class="webtxt"><i class="rmb">&yen;</i><i class="txt-data">95.00</i></span></p> 
    </dd> 
  </dl> 
  
   -->
</div> 
 
    </div> 
  </div> 
</div> 
