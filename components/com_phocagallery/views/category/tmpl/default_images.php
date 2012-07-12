<?php defined('_JEXEC') or die('Restricted access');
// - - - - - - - - - - 
// Images
// - - - - - - - - - -
$document			= &JFactory::getDocument();
//js
$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/jss/jquery-1.7.2.min.js');
$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/jss/jquery.cookie.js');
$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/jss/jquery.easing.1.3.js');
$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/jss/jquery.focus.js');
$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/jss/jquery.infinitescroll.min.js');
$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/jss/jquery.lazyload.min.js');
$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/jss/jquery.masonry.min.js');
$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/jss/jquery.photos.js');
$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/jss/underscore-1.3.1.min.js');
//css
$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/css/base.css');
$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/css/global.css');
$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/css/info.css');
$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/css/layout.css');
$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/css/reset.css');
$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/css/jqwater.css');

?>
<script type="text/javascript" async="async" defer="defer">
	void function(window,$){
		try{
			$(function(){
				$(document.body).attr("spellcheck","false");

				//lazyload
				$("img.lazyload").lazyload({effect:"fadeIn"});
			});

			//设置公共变量 begin
			window.config = {
				
			};
			//设置公共变量 end
		}
		catch(e){

		}
	}(this,jQuery);
</script>
<script type="text/javascript" async="async" defer="defer">
	void function(window, $){
		
	}(this, jQuery)
</script>

 <script type="text/javascript">
     
		//joomla 友好链接下修改	
		function test_good(id) {
    	    jQuery.ajax({
    	        type: 'POST',
    	        url:  '<? echo JURI::base(true); ?>/ajax2.php',
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
    	        url:  '<? echo JURI::base(true); ?>/ajax2.php',
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
    	        url:  '<? echo JURI::base(true); ?>/ajax2.php',
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
  <h2 class="infolist-title"><?php echo $this->tagname;?></h2>
  <div class="articleWrap">
    <div class="infolist">
      <div id="js_container" class="itemsBox">
      
      
      
<?php
if (!empty($this->items)) {
	foreach($this->items as $key => $value) {
	
		if ($this->checkRights == 1) {
			// USER RIGHT - Access of categories (if file is included in some not accessed category) - - - - -
			// ACCESS is handled in SQL query, ACCESS USER ID is handled here (specific users)
			$rightDisplay	= 0;
			if (isset($value->catid) && isset($value->cataccessuserid) && isset($value->cataccess)) {
				$rightDisplay = PhocaGalleryAccess::getUserRight('accessuserid', $value->cataccessuserid, $value->cataccess, $this->tmpl['user']->authorisedLevels(), $this->tmpl['user']->get('id', 0), 0);
			}
			// - - - - - - - - - - - - - - - - - - - - - -
		} else {
			$rightDisplay = 1;
		}
		
		// Display back button to categories list
		if ($value->item_type == 'categorieslist'){
			$rightDisplay = 1;
		}
		
		if ($rightDisplay == 1) {
?>
			
			<div class="items">
				<div class="pic"><a href="<?php echo $value->link;?>" title="<?php echo $value->title;?>"><img src="<?php echo $value->linkthumbnailpath;?>" alt="" title=""></a></div>
				<p class="desc"><a href="<?php echo $value->link;?>" title="<?php echo $value->title;?>"><?php echo $value->description;?></a></p>
				

				
				<div class="share">
					<a  href="javascript:void(0)"  title="" class="ico_love"  id="lid<?php echo $value->id;?>"><?php echo $value->hits;?></a>
					<span id="loading_l<?php echo $value->id;?>" style="display:none;"><img src="images/info/loader.gif"></span>
					<a href="javascript:void(0)" onclick="test_good(<?php echo $value->id; ?>)" title="" class="ico_like"   id="gid<?php echo $value->id;?>"><?php echo $value->goods;?></a>
					<span id="loading_g<?php echo $value->id;?>" style="display:none;"><img src="images/info/loader.gif"></span>
					<a href="javascript:void(0)" onclick="test_bad(<?php echo $value->id; ?>)" title="" class="ico_hate"   id="bid<?php echo $value->id;?>"><?php echo $value->bads;?></a>
					<span id="loading_b<?php echo $value->id;?>" style="display:none;"><img src="images/info/loader.gif"></span>
					<!--<a href="#" title="" class="ico_share" >分享</a>-->
				</div>

        	</div>
			
<?php			
		}
	}
}
?>
      
      </div>
       
      <div id="page-nav"> <a href="../pages/2.html"></a> </div>
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

    <div class="knowledgeWrap">
      <h2>装修小百科</h2>
      <div class="knowledgeCon">
        <h3>
        <?php 
        	require_once JPATH_SITE . '/components/com_content/helpers/route.php';
        	$link = JRoute::_(ContentHelperRoute::getArticleRoute($this->xbk->id, $item->catid));
        	echo '<a title="" href="'.$link.'">'.$this->xbk->title.'</a>';
        ?></h3>
        <p class="desc"><?php echo $this->xbk->introtext;?></p>
        <div class="pic">
        	<?php 
        		$images = json_decode($this->xbk->images);
        		if($images->image_intro!=null){
        			echo '<img style="width:168px;" src="'.$images->image_intro.'" alt="'.$this->xbk->title.'" title="'.$this->xbk->title.'">';
        		}
        	?>
        	
        </div>
        <div class="other"><a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($this->xbk->catid)); ?>" title="">更多&gt;&gt;</a></div>
      </div>
    </div>
    <div class="appWrap">
      <h2>热门应用</h2>
      <div class="appList">
        <dl>
          <dt><a title="" href="http://tools.mmall.com/calc.html#calc_tuliao.html"><img title="" alt="" src="images/info/appimg_0.jpg"></a></dt>
          <dd>
            <h3><a title="" href="http://tools.mmall.com/calc.html#calc_tuliao.html">涂料计算器</a></h3>
            <p class="desc">按照房屋信息和涂料覆盖率，算出所需涂料</p>
          </dd>
        </dl>
        <dl>
          <dt><a title="" href="http://tools.mmall.com/calc.html#calc_diban.html"><img title="" alt="" src="images/info/appimg_1.jpg"></a></dt>
          <dd>
            <h3><a title="" href="http://tools.mmall.com/calc.html#calc_diban.html">地板计算器</a></h3>
            <p class="desc">根据照房屋信息及地板规格，算出所需地板数量</p>
          </dd>
        </dl>
        <dl>
          <dt><a title="" href="http://tools.mmall.com/calc.html#calc_bizhi.html"><img title="" alt="" src="images/info/appimg_2.jpg"></a></dt>
          <dd>
            <h3><a title="" href="http://tools.mmall.com/calc.html#calc_bizhi.html">壁纸计算器</a></h3>
            <p class="desc">按照房屋信息及壁纸规格，算出所需壁纸卷数</p>
          </dd>
        </dl>
        <dl>
          <dt><a title="" href="http://tools.mmall.com/calc.html#calc_dizhuan.html"><img title="" alt="" src="images/info/appimg_3.jpg"></a></dt>
          <dd>
            <h3><a title="" href="http://tools.mmall.com/calc.html#calc_dizhuan.html">地砖计算器</a></h3>
            <p class="desc">根据照房屋信息及地砖规格，算出所需地砖数量</p>
          </dd>
        </dl>
        <dl>
          <dt><a title="" href="http://tools.mmall.com/calc.html#calc_chuanlian.html"><img title="" alt="" src="images/info/appimg_4.jpg"></a></dt>
          <dd>
            <h3><a title="" href="http://tools.mmall.com/calc.html#calc_chuanlian.html">窗帘计算器</a></h3>
            <p class="desc">根据窗户和布料的信息，计算出所需布料</p>
          </dd>
        </dl>
        <dl>
          <dt><a title="" href="http://tools.mmall.com/calc.html#cal_qiangzhuan.html"><img title="" alt="" src="images/info/appimg_5.jpg"></a></dt>
          <dd>
            <h3><a title="" href="http://tools.mmall.com/calc.html#cal_qiangzhuan.html">墙砖计算器</a></h3>
            <p class="desc">根据照房屋信息及墙砖规格，算出所需墙砖数</p>
          </dd>
        </dl>
      </div>
    </div>
  </div>
</div>

<script>
  $(function(){
    var $container = $('#js_container');
    
    $container.imagesLoaded(function(){
      $container.masonry({
        itemSelector: '.items',
        columnWidth: 270
      });
    });
    
    $container.infinitescroll({
      navSelector  : '#page-nav',    // selector for the paged navigation 
      nextSelector : '#page-nav a',  // selector for the NEXT link (to page 2)
      itemSelector : '.items',     // selector for all items you'll retrieve
      loading: {
          finishedMsg: 'No more pages to load.',
          img: '/imgs/jquery.plugins/jqwater/loader.gif'
        }
      },
      // trigger Masonry as a callback
      function( newElements ) {
        // hide new items while they are loading
        var $newElems = $( newElements ).css({ opacity: 0 });
        // ensure that images load before adding to masonry layout
        $newElems.imagesLoaded(function(){
          // show elems now they're ready
          $newElems.animate({ opacity: 1 });
          $container.masonry( 'appended', $newElems, true ); 
        });
      }
    );
    
  });
</script>
