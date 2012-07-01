<?php /**  * @copyright	Copyright (C) 2011 FreeJoomlaTemplates.us - All Rights Reserved. **/
defined( '_JEXEC' ) or die( 'Restricted access' ); define( 'YOURBASEPATH', dirname(__FILE__) );
$jquery			= $this->params->get('jquery');
$logo			= $this->params->get('logo');
$logotype		= $this->params->get('logotype');
$sitedesc		= $this->params->get('sitedesc');
$app			= JFactory::getApplication();
$doc			= JFactory::getDocument();
$templateparams	= $app->getTemplate(true)->params; ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
<jdoc:include type="head" />
<link href='http://fonts.googleapis.com/css?family=Ledger' rel='stylesheet' type='text/css'>
<?php require(YOURBASEPATH . DS . "functions.php"); ?>
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/styles.css" type="text/css" />
<?php if ($jquery == 'yes' ) : ?><script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/jquery-1.7.2.min.js"></script><?php endif; ?>
<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/jquery.photos.js"></script> 
<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/jquery.focus.js"></script>
</head>
<body spellcheck="false">
<div id="header">
    <div id="user">
		<div class="clearfix" id="user_body">
			<ul class="column clearfix">
            	<li><a href="#">首 页</a></li>
                <li><a href="#">团 购</a></li>
                <li><a href="#">抢 购</a></li>
                <li><a href="#">商 城</a></li>
                <li><a href="#">百MALL</a></li>
                <li class="this"><a href="#">效果图</a></li>
                <li><a href="#">客户端</a></li>
            </ul>
            <ul class="user_inf clearfix">
            	<li class="welcome">
                	<span>您好，欢迎来到红美商城</span>
                    <a href="#">[登录]</a>
                    <a href="#">[免费注册]</a>
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
        	
<div id="main"> 
			<?php if ($this->countModules('slideshow')) : ?> 
                <div id="slide-w"><div id="slide-i">
                    <jdoc:include type="modules" name="slideshow"  style="none"/>           
                </div></div>
            <?php endif; ?>        
	<div id="wrapper">
 		<div id="main-content">  
  		<div id="message">
		    <jdoc:include type="message" />
		</div>
					<?php if ($this->countModules('user1 or user2 or user3')) : ?>
                     <div id="mods1" class="spacer<?php echo $mainmod1_width; ?>">
                                <jdoc:include type="modules" name="user1" style="jaw" />
                                <jdoc:include type="modules" name="user2" style="jaw" />
                                <jdoc:include type="modules" name="user3" style="jaw" />
                                <div class="clr"></div>
                    </div>
                    <?php endif; ?>        
        <div class="full">                        
                    <div id="comp_<?php echo $compwidth ?>">
                                <div id="comp-i">
                                    <?php if ($this->countModules('breadcrumbs')) : ?>
                                    <div id="breadcrumbs">
                                    	<jdoc:include type="modules" name="breadcrumbs"  style="none"/>
                                    </div>
                                    <?php endif; ?>
                                    <?php include "html/template.php"; ?>
                                    <jdoc:include type="component" />
                                    <div class="clr"></div>
                                </div>
                    </div>
                    <?php if ($this->countModules('left')) : ?>
                    <div id="leftbar-w">
                            <div id="sidebar">
                                <jdoc:include type="modules" name="left" style="jaw" />
                            </div>
                    </div>
                    <?php endif; ?>
		<div class="clr"></div>
        </div>
                    <div id="mods2" class="spacer">
                    	<div class="module" style="float: left;width: 500px;">
                    		<jdoc:include type="modules" name="user4" style="jaw" />
                    		<jdoc:include type="modules" name="user5" style="jaw" />
                    	</div>
                        <div class="module" style="float: right;width: 500px;">
                            <jdoc:include type="modules" name="user6" style="jaw" />
                        </div>
                        <div class="clr"></div>
                    </div>
        </div>        
  </div>  
</div>
</body>
</html>