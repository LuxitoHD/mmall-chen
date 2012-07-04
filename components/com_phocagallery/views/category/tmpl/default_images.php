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
					<a  href="javascript:void(0)" onclick="test_love(<?php echo $value->id; ?>)" title="" class="ico_love"  id="lid<?php echo $value->id;?>"><?php echo $value->loves;?></a>
					<a href="javascript:void(0)" onclick="test_good(<?php echo $value->id; ?>)" title="" class="ico_like"   id="gid<?php echo $value->id;?>"><?php echo $value->goods;?></a>
					<a href="javascript:void(0)" onclick="test_bad(<?php echo $value->id; ?>)" title="" class="ico_hate"   id="bid<?php echo $value->id;?>"><?php echo $value->bads;?></a>
					<!--<a href="#" title="" class="ico_share" >分享</a>-->
				</div>

        	</div>
			
<?php			
		}
	}
}
?>
      
      <!-- 
      
        <div class="items">
          <div class="pic"><a href="#" title=""><img src="images/info/news_item_0.jpg" alt="" title=""></a></div>
          <p class="desc"><a href="#" title="">很喜欢这个装修风格，清新的色调，赞～</a></p>
          <div class="share"><a href="#" title="" class="ico_love">1023</a><a href="#" title="" class="ico_like">502</a><a href="#" title="" class="ico_hate">21</a><a a="" href="#" title="" class="ico_share">分享</a></div>
        </div>
        <div class="items">
          <div class="pic"><a href="#" title=""><img src="images/info/news_item_1.jpg" alt="" title=""></a></div>
          <p class="desc"><a href="#" title="">很喜欢这个装修风格，清新的色调，淡淡的简约，蛮有现代气息。</a></p>
          <div class="share"><a href="#" title="" class="ico_love">1023</a><a href="#" title="" class="ico_like">502</a><a href="#" title="" class="ico_hate">21</a><a a="" href="#" title="" class="ico_share">分享</a></div>
        </div>
        <div class="items">
          <div class="pic"><a href="#" title=""><img src="images/info/news_item_2.jpg" alt="" title=""></a></div>
          <p class="desc"><a href="#" title="">很喜欢这个装修风格，清新的色调，淡淡的简约，蛮有现代气息。</a></p>
          <div class="share"><a href="#" title="" class="ico_love">1023</a><a href="#" title="" class="ico_like">502</a><a href="#" title="" class="ico_hate">21</a><a a="" href="#" title="" class="ico_share">分享</a></div>
        </div>
        <div class="items">
          <div class="pic"><a href="#" title=""><img src="images/info/news_item_3.jpg" alt="" title=""></a></div>
          <p class="desc"><a href="#" title="">很喜欢这个装修风格，清新的色调，淡淡的简约，蛮有现代气息。</a></p>
          <div class="share"><a href="#" title="" class="ico_love">1023</a><a href="#" title="" class="ico_like">502</a><a href="#" title="" class="ico_hate">21</a><a a="" href="#" title="" class="ico_share">分享</a></div>
        </div>
        <div class="items">
          <div class="pic"><a href="#" title=""><img src="images/info/news_item_4.jpg" alt="" title=""></a></div>
          <p class="desc"><a href="#" title="">很喜欢这个装修风格，清新的色调，赞～</a></p>
          <div class="share"><a href="#" title="" class="ico_love">1023</a><a href="#" title="" class="ico_like">502</a><a href="#" title="" class="ico_hate">21</a><a a="" href="#" title="" class="ico_share">分享</a></div>
        </div>
        <div class="items">
          <div class="pic"><a href="#" title=""><img src="images/info/news_item_5.jpg" alt="" title=""></a></div>
          <p class="desc"><a href="#" title="">很喜欢这个装修风格，清新的色调，赞～</a></p>
          <div class="share"><a href="#" title="" class="ico_love">1023</a><a href="#" title="" class="ico_like">502</a><a href="#" title="" class="ico_hate">21</a><a a="" href="#" title="" class="ico_share">分享</a></div>
        </div>
        <div class="items">
          <div class="pic"><a href="#" title=""><img src="images/info/news_item_6.jpg" alt="" title=""></a></div>
          <p class="desc"><a href="#" title="">很喜欢这个装修风格，清新的色调，淡淡的简约，蛮有现代气息。</a></p>
          <div class="share"><a href="#" title="" class="ico_love">1023</a><a href="#" title="" class="ico_like">502</a><a href="#" title="" class="ico_hate">21</a><a a="" href="#" title="" class="ico_share">分享</a></div>
        </div>
        <div class="items">
          <div class="pic"><a href="#" title=""><img src="images/info/news_item_7.jpg" alt="" title=""></a></div>
          <p class="desc"><a href="#" title="">很喜欢这个装修风格，清新的色调，淡淡的简约，蛮有现代气息。</a></p>
          <div class="share"><a href="#" title="" class="ico_love">1023</a><a href="#" title="" class="ico_like">502</a><a href="#" title="" class="ico_hate">21</a><a a="" href="#" title="" class="ico_share">分享</a></div>
        </div>
        <div class="items">
          <div class="pic"><a href="#" title=""><img src="images/info/news_item_8.jpg" alt="" title=""></a></div>
          <p class="desc"><a href="#" title="">很喜欢这个装修风格，清新的色调，赞～</a></p>
          <div class="share"><a href="#" title="" class="ico_love">1023</a><a href="#" title="" class="ico_like">502</a><a href="#" title="" class="ico_hate">21</a><a a="" href="#" title="" class="ico_share">分享</a></div>
        </div>
        <div class="items">
          <div class="pic"><a href="#" title=""><img src="images/info/news_item_9.jpg" alt="" title=""></a></div>
          <p class="desc"><a href="#" title="">很喜欢这个装修风格，清新的色调，淡淡的简约，蛮有现代气息。</a></p>
          <div class="share"><a href="#" title="" class="ico_love">1023</a><a href="#" title="" class="ico_like">502</a><a href="#" title="" class="ico_hate">21</a><a a="" href="#" title="" class="ico_share">分享</a></div>
        </div>
        <div class="items">
          <div class="pic"><a href="#" title=""><img src="images/info/news_item_10.jpg" alt="" title=""></a></div>
          <p class="desc"><a href="#" title="">很喜欢这个装修风格，清新的色调，赞～</a></p>
          <div class="share"><a href="#" title="" class="ico_love">1023</a><a href="#" title="" class="ico_like">502</a><a href="#" title="" class="ico_hate">21</a><a a="" href="#" title="" class="ico_share">分享</a></div>
        </div>
        <div class="items">
          <div class="pic"><a href="#" title=""><img src="images/info/news_item_11.jpg" alt="" title=""></a></div>
          <p class="desc"><a href="#" title="">很喜欢这个装修风格，清新的色调，淡淡的简约，蛮有现代气息。</a></p>
          <div class="share"><a href="#" title="" class="ico_love">1023</a><a href="#" title="" class="ico_like">502</a><a href="#" title="" class="ico_hate">21</a><a a="" href="#" title="" class="ico_share">分享</a></div>
        </div>
        <div class="items">
          <div class="pic"><a href="#" title=""><img src="images/info/news_item_12.jpg" alt="" title=""></a></div>
          <p class="desc"><a href="#" title="">很喜欢这个装修风格，清新的色调，赞～</a></p>
          <div class="share"><a href="#" title="" class="ico_love">1023</a><a href="#" title="" class="ico_like">502</a><a href="#" title="" class="ico_hate">21</a><a a="" href="#" title="" class="ico_share">分享</a></div>
        </div>
        <div class="items">
          <div class="pic"><a href="#" title=""><img src="images/info/news_item_13.jpg" alt="" title=""></a></div>
          <p class="desc"><a href="#" title="">很喜欢这个装修风格，清新的色调，赞～</a></p>
          <div class="share"><a href="#" title="" class="ico_love">1023</a><a href="#" title="" class="ico_like">502</a><a href="#" title="" class="ico_hate">21</a><a a="" href="#" title="" class="ico_share">分享</a></div>
        </div>
        <div class="items">
          <div class="pic"><a href="#" title=""><img src="images/info/news_item_14.jpg" alt="" title=""></a></div>
          <p class="desc"><a href="#" title="">很喜欢这个装修风格，清新的色调，淡淡的简约，蛮有现代气息。</a></p>
          <div class="share"><a href="#" title="" class="ico_love">1023</a><a href="#" title="" class="ico_like">502</a><a href="#" title="" class="ico_hate">21</a><a a="" href="#" title="" class="ico_share">分享</a></div>
        </div>
        <div class="items">
          <div class="pic"><a href="#" title=""><img src="images/info/news_item_15.jpg" alt="" title=""></a></div>
          <p class="desc"><a href="#" title="">很喜欢这个装修风格，清新的色调，淡淡的简约，蛮有现代气息。</a></p>
          <div class="share"><a href="#" title="" class="ico_love">1023</a><a href="#" title="" class="ico_like">502</a><a href="#" title="" class="ico_hate">21</a><a a="" href="#" title="" class="ico_share">分享</a></div>
        </div>
        <div class="items">
          <div class="pic"><a href="#" title=""><img src="images/info/news_item_16.jpg" alt="" title=""></a></div>
          <p class="desc"><a href="#" title="">很喜欢这个装修风格，清新的色调，淡淡的简约，蛮有现代气息。</a></p>
          <div class="share"><a href="#" title="" class="ico_love">1023</a><a href="#" title="" class="ico_like">502</a><a href="#" title="" class="ico_hate">21</a><a a="" href="#" title="" class="ico_share">分享</a></div>
        </div>
        <div class="items">
          <div class="pic"><a href="#" title=""><img src="images/info/news_item_16.jpg" alt="" title=""></a></div>
          <p class="desc"><a href="#" title="">很喜欢这个装修风格，清新的色调，赞～</a></p>
          <div class="share"><a href="#" title="" class="ico_love">1023</a><a href="#" title="" class="ico_like">502</a><a href="#" title="" class="ico_hate">21</a><a a="" href="#" title="" class="ico_share">分享</a></div>
        </div>
        -->
      </div>
       
      <div id="page-nav"> <a href="../pages/2.html"></a> </div>
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

    <div class="knowledgeWrap">
      <h2>装修小百科</h2>
      <div class="knowledgeCon">
        <h3>淋浴柱安装要点</h3>
        <p class="desc">淋浴柱安装一定要注意3个高度，我们在装修阶段要确认的是淋浴柱出水口离地的高度，即图上的H3，这个高度要根据淋浴柱的高度来确认。要使淋浴柱安装后，淋浴蓬头不至于顶上铝扣板吊顶，也就是要考虑图上H1的尺寸，另外还要使淋浴蓬头离地的高度可以使家中最高的成员很舒服的站在下面，也就是图上H2和家中最高的身高的关系。所以在改水之前就要把淋浴柱的型号确定了才能准确确定H3的高度。</p>
        <div class="pic"><img src="images/info/img01.jpg" alt="" title=""></div>
        <div class="other"><a href="#" title="">更多&gt;&gt;</a></div>
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
