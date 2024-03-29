<?php
/**
 * @version		$Id: default.php 21518 2011-06-10 21:38:12Z chdemko $
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');


$document			= &JFactory::getDocument();
$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/jss/jquery-1.7.2.min.js');
//css
/*
$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/css/base.css');
$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/css/global.css');
$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/css/info.css');
$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/css/layout.css');
$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/css/reset.css');
*/
// Create shortcuts to some parameters.
$params		= $this->item->params;
//$canEdit	= $this->item->params->get('access-edit');
$user		= JFactory::getUser();
?>


 <script type="text/javascript">
     
		//joomla 友好链接下修改	
		function test_good(id) {
    	    jQuery.ajax({
    	        type: 'POST',
    	        url:  '<? echo JURI::base(true); ?>/ajax4.php',
    	        data: {id:id,para:"good"},
    	        beforeSend:function(){
        	        $("#gid"+id).hide();
        	        $("#loading_g"+id).show();
        	    },
    			complete:function(){
        			$("#loading_g"+id).hide()
        			 $("#gid"+id).show();
        		},
    	        success: function(data) {
        	        if(data == "succ"){
        	        	$("#gid"+id).text(parseInt($("#gid"+id).text())+1);
        	        }else{
        	        	alert("失败");
        	        }
    	        }
    	    })
    	}  
		function test_bad(id) {
    	    jQuery.ajax({
    	        type: 'POST',
    	        url:  '<? echo JURI::base(true); ?>/ajax4.php',
    	        data: {id:id,para:"bad"},
    	        beforeSend:function(){
        	        $("#bid"+id).hide();
        	        $("#loading_b"+id).show();
        	    },
    			complete:function(){
        			$("#loading_b"+id).hide()
        			 $("#bid"+id).show();
        		},
    	        success: function(data) {
        	        if(data == "succ"){
        	        	$("#bid"+id).text(parseInt($("#bid"+id).text())+1);
        	        }else{
        	        	alert("失败");
        	        }
    	        }
    	    })
    	} 

		function test_love(id) {
    	    jQuery.ajax({
    	        type: 'POST',
    	        url:  '<? echo JURI::base(true); ?>/ajax4.php',
    	        data: {id:id,para:"love"},
    	        beforeSend:function(){
        	        $("#lid"+id).hide();
        	        $("#loading_l"+id).show();
        	    },
    			complete:function(){
        			$("#loading_l"+id).hide()
        			 $("#lid"+id).show();
        		},
    	        success: function(data) {
        	        if(data == "succ"){
        	        	$("#lid"+id).text(parseInt($("#lid"+id).text())+1);
        	        }else{
						alert("失败");
        	        }
    	        }
    	    })
    	} 
</script>     
<?php
$title = $this->escape($this->item->category_title);

?>

<div id="content">
  <div class="articleWrap">
    <div class="waterDetailWrap"><div class="crumbs clearfix">
  <ul>
    <li class="base">
      <div class="logo"></div>
      <span>您现在的位置：<a href="index.php" title="">首页</a></span> </li>
     <li class="arrow">&gt;</li>
    <li><a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catslug)); ?>" title=""><?php echo $title; ?></a></li>
    <li class="arrow">&gt;</li>
    <li><?php echo $this->escape($this->item->title); ?></li>
  </ul>
</div>

      <div class="waterDetail">
        <h1><?php echo $this->escape($this->item->title); ?></h1>
        <div class="source">
			<a href="#" title=""  style="display:none">http://www.mall.com</a>
			<span class="time">上传时间：<?php echo substr(JHtml::_('date', $this->item->created),0,10);?></span>
			<span class="author">作者：<?php $author = $this->item->created_by_alias ? $this->item->created_by_alias : $this->item->author;echo  $author;?></span>
			<span class="from" style="display:none">来源：和家网</span>
		</div>
        <div class="clearfix">
          <div class="tags">
			<strong>关键词：</strong>
			<span class="txt-data"><?php $keyword = $this->item->metakey;echo $keyword; ?></span>
		  </div>
          <div class="share">
          			<a  href="javascript:void(0)" title="" class="ico_love"  id="lid<?php echo $this->item->id;?>"><?php echo $this->item->hits;?></a>
					<span id="loading_l<?php echo $this->item->id;?>" style="display:none;"><img src="images/info/loader.gif"></span>
					<a href="javascript:void(0)" onclick="test_good(<?php echo $this->item->id; ?>)" title="" class="ico_like"   id="gid<?php echo $this->item->id;?>"><?php echo $this->item->goods;?></a>
					<span id="loading_g<?php echo $this->item->id;?>" style="display:none;"><img src="images/info/loader.gif"></span>
					<a href="javascript:void(0)" onclick="test_bad(<?php echo $this->item->id; ?>)" title="" class="ico_hate"   id="bid<?php echo $this->item->id;?>"><?php echo $this->item->bads;?></a>
					<span id="loading_b<?php echo $this->item->id;?>" style="display:none;"><img src="images/info/loader.gif"></span>
					<!--<a href="#" title="" class="ico_share" >分享</a>-->
            <div class="ico_share" style="background:none">
				<div class="bshare-custom"><a title="分享到QQ空间" class="bshare-qzone" href="javascript:void(0);"></a><a title="分享到新浪微博" class="bshare-sinaminiblog" href="javascript:void(0);"></a><a title="分享到人人网" class="bshare-renren" href="javascript:void(0);"></a><a title="分享到腾讯微博" class="bshare-qqmb" href="javascript:void(0);"></a><a title="分享到豆瓣" class="bshare-douban" href="javascript:void(0);"></a><a title="更多平台" class="bshare-more bshare-more-icon more-style-addthis"></a></div><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=c22ee2c1-3776-4e8e-b3ba-40031a7c216f&amp;pophcol=2&amp;lang=zh"></script><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>
                    <script type="text/javascript">
						void function(window, $){
							$(function(){
								bShare.addEntry({
									title: "{红美风水百科标题}",
									summary: "转自【红美风水百科" + location.protocol + "//" + location.host+ "】{红美风水百科标题}"
								})
							});
						}(this, jQuery)
                    </script> 
			</div>
          </div>
        </div>
		<?php
			$images = json_decode($this->item->images);
			
		?>
        <div class="summary"><strong>导语：</strong><?php echo $this->item->introtext; ?></div>
          <div class="pic"><img width="424" height="335" src="<?php echo htmlspecialchars($images->image_fulltext); ?>" alt="" title=""></div>
          <!--<p class="desc"><strong>摘要：</strong>从浅到深的蓝，各种色调的红，百搭的白......充满梦幻色彩的整体橱柜，让人始终保持清澈，浪漫的感
          觉，橱柜在这样的空间里，显得纯洁可爱，惹人遐思。50图为您呈现多彩整体橱柜，诠释橱柜色彩定义。</p>
          <p class="desc"><strong>摘要：</strong>从浅到深的蓝，各种色调的红，百搭的白......充满梦幻色彩的整体橱柜，让人始终保持清澈，浪漫的感
          觉，橱柜在这样的空间里，显得纯洁可爱，惹人遐思。50图为您呈现多彩整体橱柜，诠释橱柜色彩定义。</p>
          <p class="desc"><strong>摘要：</strong>从浅到深的蓝，各种色调的红，百搭的白......充满梦幻色彩的整体橱柜，让人始终保持清澈，浪漫的感
          觉，橱柜在这样的空间里，显得纯洁可爱，惹人遐思。50图为您呈现多彩整体橱柜，诠释橱柜色彩定义。</p>
          -->
		  <?php echo $this->item->fulltext; ?>
		 <!--
        <div class="paginationWrap">
			<div class="pageList clearfix">
			  <ul class="pageList_body clearfix">
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
			  </ul>
			</div>
		</div>-->
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