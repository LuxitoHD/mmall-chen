<?php defined('_JEXEC') or die('Restricted access');
$document			= &JFactory::getDocument();
//js
$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/jss/jquery-1.6.min.js');
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

$img_large = $this->item->fileThumbnail_large;
$img_small = $this->item->fileThumbnail_small;
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


<div id="content">
  <div class="section_con"> 
    <div class="crumbs clearfix">
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

    <h2 class="photos_title">名家之作 2012卫生间装修效果大全</h2>
    <div class="photos_tips">支持键盘&lt;&nbsp;&gt;键翻阅</div>
    <div class="photosWrap">
		<div class="picView" id="picView"> 
			<a href="#" class="prev" id="prev" hidefocus="true" title="上一张">上一张</a>
			<div id="view" class="view"><a href="#"><img  width='930' height='558' src="" alt="" title="" /></a> </div>
			<a href="#" class="next" id="next" hidefocus="true" title="下一张">下一张</a>
		</div>
		<div class="clearfix">
			<div class="autoPlayWrap">
				<a href="#" title="上一张" hidefocus="true" class="prev2" id="prev2">上一张</a>
				<a href="#" title="" hidefocus="true" class="autoPlay" id="autoPlay">自动播放</a>
				<a href="#" title="" hidefocus="true" class="autoPlay" id="stopPlay" style="display:none;">停止播放</a>
				<a href="#" title="下一张" hidefocus="true" class="next2" id="next2">下一张</a>
			</div>
			<div class="tagsWrap">
				<strong>标签：</strong>
				<span class="txt-data">客厅</span>
				<span class="txt-data">欧式</span>
				<span class="txt-data">品质舒适族</span>
				<span class="txt-data">简洁储物架</span>
			</div>
			<div class="share">
				<a href="#" title="" class="ico_love">1023</a>
				<a href="#" title="" class="ico_like">502</a>
				<a href="#" title="" class="ico_hate">21</a>
				<a href="#" title="" class="ico_share">分享</a>
			</div>
      </div>
      <div class="picsWrap" id="pics_wrap">
			<a href="#" class="scrollL" id="scrollL" hidefocus="true" title="上一张">上一张</a>
			<div class="picsList" id="picsList">
				<ul>
				
					<script type="text/javascript">
						var curNum_t = 0;
						//前台js变量取得小缩略图的路径
						var img_small_js = "<?php echo $this->item->fileThumbnail_small;?>";
						
						var tian = [<?php echo $this->item->slideshowfiles ;?>];
						for(var i=0;i<tian.length;i++){
							if(img_small_js == tian[i][1]){
								curNum_t = i; //取得当前图片的位置
							}
							//document.write("<li><a href='"+tian[i][3]+"'><img src='"+tian[i][0]+"'></href></li>");
							document.write("<li><img width='100' height='74'  src='"+tian[i][1]+"' alt='' title='' data_source='"+tian[i][0]+"' /></li>");
						}
						//tian  重复添加
						for(var i=0;i<tian.length;i++){
							//document.write("<li><a href='"+tian[i][3]+"'><img src='"+tian[i][0]+"'></href></li>");
							document.write("<li><img width='100' height='74' src='"+tian[i][1]+"' alt='' title='' data_source='"+tian[i][0]+"' /></li>");
						}
					</script>
					<!-- 	
					<li><img width="10" height="10" src="images/info/room_pic_0.jpg" alt="" title="" data_source="images/info/news_pic.jpg" /></li>
					<li><img src="images/info/room_pic_1.jpg" alt="" title="" data_source="images/info/news_pic_1.jpg" /></li>
					<li><img src="images/info/room_pic_2.jpg" alt="" title="" data_source="images/info/news_pic_2.jpg" /></li>
					<li><img src="images/info/room_pic_3.jpg" alt="" title="" data_source="images/info/news_pic_3.jpg" /></li>
					<li><img src="images/info/room_pic_4.jpg" alt="" title="" data_source="images/info/news_pic.jpg" /></li>
					<li><img src="images/info/room_pic_5.jpg" alt="" title="" data_source="images/info/news_pic_1.jpg" /></li>
					<li><img src="images/info/room_pic_6.jpg" alt="" title="" data_source="images/info/news_pic_2.jpg" /></li>
					<li><img src="images/info/room_pic_0.jpg" alt="" title="" data_source="images/info/news_pic_3.jpg" /></li>
					<li><img src="images/info/room_pic_1.jpg" alt="" title="" data_source="images/info/news_pic.jpg" /></li>
					<li><img src="images/info/room_pic_2.jpg" alt="" title="" data_source="images/info/news_pic_1.jpg" /></li>
					<li><img src="images/info/room_pic_3.jpg" alt="" title="" data_source="images/info/news_pic_2.jpg" /></li>
					<li><img src="images/info/room_pic_4.jpg" alt="" title="" data_source="images/info/news_pic_3.jpg" /></li>
					<li><img src="images/info/room_pic_5.jpg" alt="" title="" data_source="images/info/news_pic.jpg" /></li>
					<li><img src="images/info/room_pic_6.jpg" alt="" title="" data_source="images/info/news_pic_1.jpg" /></li>
					<li><img src="images/info/room_pic_0.jpg" alt="" title="" data_source="images/info/news_pic_2.jpg" /></li>
					<li><img src="images/info/room_pic_1.jpg" alt="" title="" data_source="images/info/news_pic_3.jpg" /></li>
					<li><img src="images/info/room_pic_2.jpg" alt="" title="" data_source="images/info/news_pic.jpg" /></li>
					<li><img src="images/info/room_pic_3.jpg" alt="" title="" data_source="images/info/news_pic_1.jpg" /></li>
					<li><img src="images/info/room_pic_4.jpg" alt="" title="" data_source="images/info/news_pic_2.jpg" /></li>
					<li><img src="images/info/room_pic_5.jpg" alt="" title="" data_source="images/info/news_pic_3.jpg" /></li>
					<li><img src="images/info/room_pic_6.jpg" alt="" title="" data_source="images/info/news_pic_1.jpg" /></li>
				 -->
				</ul>
			 </div>
			<a href="#" class="scrollR" id="scrollR" hidefocus="true" title="下一张">下一张</a> </div>
	</div>
</div>
<script type="text/javascript">
	void function(window, $){
		$("#picsList li").photos({
			 phosWrap:"#pics_wrap", //总容器
			 phosView:"#picView .view img", //大图片容器
			 itemsBox:"#picsList ul", //小图片容器
			 items:"#picsList  li", //小图片选择器
			 prev:"#prev", //上一条按钮
			 next:"#next", //下一条按钮
			 prev2:"#prev2", //上一条按钮2
			 next2:"#next2", //下一条按钮2
			 scrollL:"#scrollL", //小图片左滚动按钮
			 scrollR:"#scrollR", //小图片右滚动按钮
			 curClass:"cur", //标识当前样式
			 autoPlay:true, //是否自动播放,默认不播放
			 eventType:"click", //鼠标事件设置
			 eventSpeed:"normal", //动画速度，设0则无动画
			 eventTime:2000, //轮播间隔时间，设0则不自动轮播
			 scrollDirection:0, //动画滚动方向
			 curNum: parseInt(location.hash.replace("#pic_", '')) || curNum_t,//标识默认停在第几个
			 scrollNub:7, //每次滚动数量
			 defaultNum:3
		});
	}(this, jQuery);
</script> 

<div id="phocaGallerySlideshowC" style="display:none"></div>

<div class="section_con mt20">
    <div class="aboutPro">
      <h2>关联商品</h2>
      <div class="aboutProList">
        <ul>
          <li>
            <div class="picWrap"><a href="#" title="" class="pic"><img src="images/info/img_0.jpg" alt="" title=""></a></div>
            <h3><a href="#" title="">【吉屋】布艺沙发巾</a></h3>
            <p class="price"><span class="webtxt"><i class="rmb">&yen;</i><i class="txt-data">95.00</i></span></p>
          </li>
          <li>
            <div class="picWrap"><a href="#" title="" class="pic"><img src="images/info/img_1.jpg" alt="" title=""></a></div>
            <h3><a href="#" title="">【吉屋】布艺沙发巾</a></h3>
            <p class="price"><span class="webtxt"><i class="rmb">&yen;</i><i class="txt-data">95.00</i></span></p>
          </li>
          <li>
            <div class="picWrap"><a href="#" title="" class="pic"><img src="images/info/img_2.jpg" alt="" title=""></a></div>
            <h3><a href="#" title="">【吉屋】布艺沙发巾</a></h3>
            <p class="price"><span class="webtxt"><i class="rmb">&yen;</i><i class="txt-data">95.00</i></span></p>
          </li>
          <li>
            <div class="picWrap"><a href="#" title="" class="pic"><img src="images/info/img_3.jpg" alt="" title=""></a></div>
            <h3><a href="#" title="">【吉屋】布艺沙发巾</a></h3>
            <p class="price"><span class="webtxt"><i class="rmb">&yen;</i><i class="txt-data">95.00</i></span></p>
          </li>
          <li>
            <div class="picWrap"><a href="#" title="" class="pic"><img src="images/info/img_4.jpg" alt="" title=""></a></div>
            <h3><a href="#" title="">【吉屋】布艺沙发巾</a></h3>
            <p class="price"><span class="webtxt"><i class="rmb">&yen;</i><i class="txt-data">95.00</i></span></p>
          </li>
        </ul>
      </div>
    </div>
    <div class="uMayLike">
      <h2>猜你喜欢</h2>
      <div class="uMayLikeList">
        <ul>
          <li>
            <div class="picWrap"><a href="#" title="" class="pic"><img src="images/info/img_5.jpg" alt="" title=""></a></div>
            <h3><a href="#" title="">【吉屋】布艺沙发巾</a></h3>
            <p class="price"><span class="webtxt"><i class="rmb">&yen;</i><i class="txt-data">95.00</i></span></p>
          </li>
          <li>
            <div class="picWrap"><a href="#" title="" class="pic"><img src="images/info/img_6.jpg" alt="" title=""></a></div>
            <h3><a href="#" title="">【吉屋】布艺沙发巾</a></h3>
            <p class="price"><span class="webtxt"><i class="rmb">&yen;</i><i class="txt-data">95.00</i></span></p>
          </li>
          <li>
            <div class="picWrap"><a href="#" title="" class="pic"><img src="images/info/img_7.jpg" alt="" title=""></a></div>
            <h3><a href="#" title="">【吉屋】布艺沙发巾</a></h3>
            <p class="price"><span class="webtxt"><i class="rmb">&yen;</i><i class="txt-data">95.00</i></span></p>
          </li>
          <li>
            <div class="picWrap"><a href="#" title="" class="pic"><img src="images/info/img_8.jpg" alt="" title=""></a></div>
            <h3><a href="#" title="">【吉屋】布艺沙发巾</a></h3>
            <p class="price"><span class="webtxt"><i class="rmb">&yen;</i><i class="txt-data">95.00</i></span></p>
          </li>
          <li>
            <div class="picWrap"><a href="#" title="" class="pic"><img src="images/info/img_9.jpg" alt="" title=""></a></div>
            <h3><a href="#" title="">【吉屋】布艺沙发巾</a></h3>
            <p class="price"><span class="webtxt"><i class="rmb">&yen;</i><i class="txt-data">95.00</i></span></p>
          </li>
        </ul>
      </div>
    </div>
  </div>
   
</div>


