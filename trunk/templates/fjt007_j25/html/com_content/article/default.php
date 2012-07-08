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
$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/css/base.css');
$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/css/global.css');
$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/css/info.css');
$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/css/layout.css');
$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/css/reset.css');

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
    	        url:  '<? echo JURI::base(true); ?>/ajax3.php',
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
    	        url:  '<? echo JURI::base(true); ?>/ajax3.php',
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
    	        url:  '<? echo JURI::base(true); ?>/ajax3.php',
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


<div id="content">
  <div class="articleWrap">
    <div class="waterDetailWrap"><div class="crumbs clearfix">
  <ul>
    <li class="base">
      <div class="logo"></div>
      <span>您现在的位置：<a href="#" title="">首页</a></span> </li>
    <li class="arrow">&gt;</li>
    <li><a href="#" title="">用户中心</a></li>
    <li class="arrow">&gt;</li>
    <li class="terminal">我的报名</li>
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
          			<a  href="javascript:void(0)" onclick="test_love(<?php echo $this->item->id; ?>)" title="" class="ico_love"  id="lid<?php echo $this->item->id;?>"><?php echo $this->item->loves;?></a>
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
        <h2>相关文章推荐 <?php echo $this->item->featuredArticle; ?> </h2>
        <div class="list">
          <ul class="items-list">
            <li class="except"><a href="#" title=""><img src="images/info/about_0.jpg" alt="" title=""></a></li>
            <li><a href="#" title="">美国30万人感染致命疾病</a></li>
            <li><a href="#" title="">美国30万人感染致命疾病</a></li>
            <li><a href="#" title="">美国30万人感染致命疾病</a></li>
            <li><a href="#" title="">美国30万人感染致命疾病</a></li>
            <li><a href="#" title="">美国30万人感染致命疾病</a></li>
            <li><a href="#" title="">美国30万人感染致命疾病</a></li>
          </ul>
          <ul class="items-list">
            <li class="except"><a href="#" title=""><img src="images/info/about_1.jpg" alt="" title=""></a></li>
            <li><a href="#" title="">美国30万人感染致命疾病</a></li>
            <li><a href="#" title="">美国30万人感染致命疾病</a></li>
            <li><a href="#" title="">美国30万人感染致命疾病</a></li>
            <li><a href="#" title="">美国30万人感染致命疾病</a></li>
            <li><a href="#" title="">美国30万人感染致命疾病</a></li>
            <li><a href="#" title="">美国30万人感染致命疾病</a></li>
          </ul>
          <ul class="items-list">
            <li class="except"><a href="#" title=""><img src="images/info/about_2.jpg" alt="" title=""></a></li>
            <li><a href="#" title="">美国30万人感染致命疾病</a></li>
            <li><a href="#" title="">美国30万人感染致命疾病</a></li>
            <li><a href="#" title="">美国30万人感染致命疾病</a></li>
            <li><a href="#" title="">美国30万人感染致命疾病</a></li>
            <li><a href="#" title="">美国30万人感染致命疾病</a></li>
            <li><a href="#" title="">美国30万人感染致命疾病</a></li>
          </ul>
        </div>
      </div>
  </div>
  <div class="asideWrap">
      <div class="introInfor">
<h2>关联商品</h2>
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
</div>
 
  </div>
</div>