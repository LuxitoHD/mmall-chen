<?php /**  * @copyright	Copyright (C) 2011 FreeJoomlaTemplates.us - All Rights Reserved. **/
defined( '_JEXEC' ) or die( 'Restricted access' ); define( 'YOURBASEPATH', dirname(__FILE__) );
$jquery			= $this->params->get('jquery');
$logo			= $this->params->get('logo');
$logotype		= $this->params->get('logotype');
$sitedesc		= $this->params->get('sitedesc');
$app			= JFactory::getApplication();
$doc			= JFactory::getDocument();
$templateparams	= $app->getTemplate(true)->params; 
$config = new HMConfig();?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
	<head>
		<jdoc:include type="head" />
		<?php require(YOURBASEPATH . DS . "functions.php"); ?>
		<link rel="stylesheet" href="<?php echo $config->getCssProvider();?>/css/styles.css?20120320" type="text/css" />
		<link rel="stylesheet" href="<?php echo $config->getCssProvider();?>/css/base.css?20120320" type="text/css" />
		<link rel="stylesheet" href="<?php echo $config->getCssProvider();?>/css/global.css?20120320" type="text/css" />
		<link rel="stylesheet" href="<?php echo $config->getCssProvider();?>/css/info.css?20120320" type="text/css" />
		<link rel="stylesheet" href="<?php echo $config->getCssProvider();?>/css/layout.css?20120320" type="text/css" />
		<link rel="stylesheet" href="<?php echo $config->getCssProvider();?>/css/reset.css?20120320" type="text/css" />
		<?php if ($jquery == 'yes' ){
		$document			= &JFactory::getDocument();
		$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/jss/jquery-1.7.2.min.js');
		} ?>
		<script type="text/javascript" src="<?php echo $config->getJsProvider();?>/js/jquery.photos.js"></script> 
		<script type="text/javascript" src="<?php echo $config->getJsProvider();?>/js/jquery.focus.js"></script>
	</head>
	<body spellcheck="false">
		<div id="header">
		    <div id="user">
				<div class="clearfix" id="user_body">
					<ul class="column clearfix">
		            	<li><a target="_blank" href="http://www.mmall.com">首 页</a></li>
		                <li><a target="_blank" href="http://tg.mmall.com/">团 购</a></li>
		                <li><a target="_blank" href="http://q.mmall.com">抢 购</a></li>
		                <li class="this"><a href="http://zixun.mmall.com">效果图</a></li>
		            </ul>
		            <ul class="user_inf clearfix">
		            	<li class="welcome">
		                	<span>您好，欢迎来到红美商城</span>
		                    <a href="javascript:location='http://www.mmall.com/passport.php?act=login&back_act=' + encodeURIComponent(location)">[登录]</a>
		                    <a href="javascript:location='http://www.mmall.com/passport.php?act=register&back_act='+encodeURIComponent(location)">[免费注册]</a>
		                </li>
		                <li class="line">|</li>
		                <li id="myRedStar" class="myRedStar">
		                	<a class="drop" href="#">我的红美</a>
		                    <div id="myRSlist" class="list" style="display: none;">
		                    	<span class="blank"></span>
		                        <div class="list_body">
		                            <a href="#">我的订单</a>
		                            <a href="#">我的购物车</a>
		                            <a href="#">我的收藏</a>
		                            <a href="#">我的余额</a>
		                        </div>
		                    </div>
		                </li>
		                <li class="line">|</li>
		                <li class="help">
		                	<span>帮助中心</span>
		                    <b>4000-213-213</b>
		               	</li>
		            </ul>
				</div>
			</div>
			<script type="text/javascript" defer async>
				void function(window, $){
					$(function(){
						$("#myRedStar").hover(
							function(){
								$("#myRSlist").show();
							},
							function(){
								$("#myRSlist").hide();
							}
						);
//						$("#this_city").hover(function(){
//						$(this).find("b").addClass("hover");
//						$("#city").show();
//						},function(){
//						$(this).find("b").removeClass("hover");
//						$("#city").hide();
//						});
//						$("#search_text").focus(function(){
//						var value = $(this).val();
//						if(value == this.defaultValue){
//						$(this).val("").css({"color":"#333"})
//						}
//						});
//						$("#search_text").blur(function(){
//						var value = $(this).val();
//						if(value == ""){
//						$(this).val(this.defaultValue).css({"color":"#999"})
//						}
//						});
					})
				}(this,jQuery);
			</script> 
			<div class="clearfix" id="logo_search">
		        <div class="logo">
		            <a href="#"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/logo.png"></a>
		        </div>
		
				<div class="sampleRoom"></div>
		        
				<div class="search">
		        	<div class="search_body clearfix">
		            
		                <div class="key_word">
		                	<b>商品</b>
		                    <ul>
		                    	<li><a class="drop" href="javascript:;">商品</a></li>
		                        <li><a href="javascript:;">店铺</a></li>
		                    </ul>
		                </div>
		                
		                <div class="text"><input type="text" id="search_text" value="搜索关键词"></div>
		                <div class="btn"><input type="button"></div>
		            </div>
		            
		            <div class="hot_link">
		            	<a href="#">柜类</a>
		                <a href="#">沙发</a>
		                <a href="#">床</a>
		                <a href="#">桌几</a>
		                <a href="#">家居秀</a>
		                <a href="#">家具</a>
		                <a href="#">收纳</a>
		                <a href="#">水杯</a>
		            </div>
		            
				</div><!--search's end-->
				<div style="clear: both;"></div>
			</div>
		    <?php if ($sitedesc !== '' ) : ?>
		    	<div class="sitedescription"><?php echo htmlspecialchars($templateparams->get('sitedesc'));?></div>
		    <?php endif; ?> 
		    <?php if ($this->countModules('top')) : ?>
		        <div id="top">
		            <jdoc:include type="modules" name="top" style="none" />
		        </div>
		    <?php endif; ?>
		    <?php if ($this->countModules('menu')) : ?>
		       	<div id="nav">
		       		<div id="nav_body">         
		           		<jdoc:include type="modules" name="menu" style="none" />               
		           	</div>
		        </div>
		    <?php endif; ?>                  
		</div>

		<?php include "html/template.php"; ?>
		<jdoc:include type="component" />
		<div class="clr"></div>

		<?php if(JRequest::getVar('view') == "categories"){  ?>
		<div class="sectionWrap" style="width:1000px;margin:0 auto;margin-bottom:30px">
			<div class="module" style="float: left;width: 500px;">
				<jdoc:include type="modules" name="user4" style="jaw" />
				<jdoc:include type="modules" name="user5" style="jaw" />
			</div>
			<div class="module" style="float: right;width: 500px;">
				<jdoc:include type="modules" name="user6" style="jaw" />
			</div>
			<div class="clr"></div>
		</div>
		<?php }  ?> 
		
		<div id="footer">
			<div class="footer_body">
		
		        <div class="sevice clearfix">
		            <dl>
		                <dt>购物指南</dt>
		                <dd><a href="#">购物流程</a></dd>
		                <dd><a href="#">积分说明</a></dd>
		                <dd><a href="#">会员权益</a></dd>
		                <dd><a href="#">联系客服</a></dd>
		                <dd><a href="#">常见问题</a></dd>
		            </dl>
		            
		            <dl>
		                <dt>支付帮助</dt>
		                <dd><a href="#">网银支付</a></dd>
		                <dd><a href="#">发票制度</a></dd>
		            </dl>
		            
		            <dl>
		                <dt>特色服务</dt>
		                <dd><a href="#">潮品</a></dd>
		                <dd><a href="#">装分享</a></dd>
		                <dd><a href="#">装修风水</a></dd>
		                <dd><a href="#">装修效果图</a></dd>
		                <dd><a href="#">装修百宝箱</a></dd>
		                <dd><a href="#">客户端下载</a></dd>
		            </dl>
		            
		            <dl class="logo">
		            	<dt></dt>
		                <dd></dd>
		            </dl>
		            
		            <dl>
		                <dt>物流配送</dt>
		                <dd><a href="#">配送范围</a></dd>
		                <dd><a href="#">配送方式</a></dd>
		                <dd><a href="#">配送预约</a></dd>
		                <dd><a href="#">订单查询</a></dd>
		            </dl>
		            
		            <dl>
		                <dt>售后服务</dt>
		                <dd><a href="#">服务承诺</a></dd>
		                <dd><a href="#">先行赔付</a></dd>
		                <dd><a href="#">安装维修</a></dd>
		                <dd><a href="#">退换货政策</a></dd>
		                <dd><a href="#">退换货流程</a></dd>
		                <dd><a href="#">退换货申请</a></dd>
		            </dl>
		            
		            <dl>
		                <dt>商家支持</dt>
		                <dd><a href="#">商家入驻</a></dd>
		                <dd><a href="#">商家中心</a></dd>
		                <dd><a href="#">商家成长</a></dd>
		                <dd><a href="#">红美规则</a></dd>
		            </dl>
		            
		        </div><!--sevice's end-->
		        
		        <div class="promise"></div><!--promise's end-->
		        
		        <div class="other_link clearfix">
		            <span class="link"><a href="#">关于我们</a></span>
		            <span class="line">|</span>
		            <span class="link"><a href="#">人才招聘</a></span>
		            <span class="line">|</span>
		            <span class="link"><a href="#">商务合作</a></span>
		            <span class="line">|</span>
		            <span class="link"><a href="#">移动终端</a></span>
		            <span class="line">|</span>
		            <span class="link"><a href="#">友情链接</a></span>
		        </div>
		        
		        <div class="web_icp">
		            ICP证: 沪ICP备12018818号&nbsp;&nbsp;上海市公安局宝山分局备案编号：3101130646&nbsp;&nbsp;Copyright&copy;2012 红美商城 版权所有
		        </div>
		        <div class="ext">
		        	<span><a href="#"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/imgs/20120529/f_beian.jpg"></a></span>
		            <span><a href="#"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/imgs/20120529/f_kexin.jpg"></a></span>
		            <span><a href="#"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/imgs/20120529/f_110.jpg"></a></span>
		            <span><a href="#"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/imgs/20120529/f_chengxin.jpg"></a></span>
		        </div><!--ext's end-->
		    </div><!--footer_body's end-->
		</div>
	</body>
	<script type="text/javascript">
		void function(windows,$){
			var script=document.createElement("script");
			script.async=true;
			script.defer="defer";
			script.src=location.protocol+"//"+"hm.baidu.com/h.js?7e64e848c50d35307a0b07e25ee799d5";
			document.body.appendChild(script);
		}(this,jQuery)
	</script>
</html>