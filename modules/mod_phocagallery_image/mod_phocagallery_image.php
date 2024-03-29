<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @module Phoca - Phoca Module
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz 
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * test utf-8 ä,ü,ö
 */
defined('_JEXEC') or die('Restricted access');// no direct access
if (!JComponentHelper::isEnabled('com_phocagallery', true)) {
	return JError::raiseError(JText::_('Phoca Gallery Error'), JText::_('Phoca Gallery is not installed on your system'));
}
if (! class_exists('PhocaGalleryLoader')) {
    require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_phocagallery'.DS.'libraries'.DS.'loader.php');
}
phocagalleryimport('phocagallery.path.path');
phocagalleryimport('phocagallery.path.route');
phocagalleryimport('phocagallery.library.library');
phocagalleryimport('phocagallery.text.text');
phocagalleryimport('phocagallery.access.access');
phocagalleryimport('phocagallery.file.file');
phocagalleryimport('phocagallery.file.filethumbnail');
phocagalleryimport('phocagallery.image.image');
phocagalleryimport('phocagallery.image.imagefront');
phocagalleryimport('phocagallery.render.renderfront');
phocagalleryimport('phocagallery.ordering.ordering');
phocagalleryimport('phocagallery.picasa.picasa');

$user 				= &JFactory::getUser();
$db 				= &JFactory::getDBO();
//$menu 				= &JSite::getMenu();
//if ($app->isSite()) {
//	$menu = &JSite::getMenu();
//}
$document			= &JFactory::getDocument();
$library 			= &PhocaGalleryLibrary::getLibrary();
$path 				= PhocaGalleryPath::getPath();

// LIBRARY
$libraries['pg-css-ie-mri'] 			= $library->getLibrary('pg-css-ie-mri');
$libraries['pg-css-ie-hover']			= $library->getLibrary('pg-css-ie-hover');
$libraries['pg-group-shadowbox']		= $library->getLibrary('pg-group-shadowbox');
$libraries['pg-group-highslide']		= $library->getLibrary('pg-group-highslide');
$libraries['pg-group-jak-mod']				= $library->getLibrary('pg-group-jak-mod');

// CSS
$document->addStyleSheet(JURI::base(true).'/modules/mod_phocagallery_image/css/phocagallery_module_image.css');
if ( $libraries['pg-css-ie-mri']->value == 0 ) {
	$document->addCustomTag("<!--[if lt IE 8]>\n<link rel=\"stylesheet\" href=\"".JURI::base(true)."/modules/mod_phocagallery_image/css/phocagallery_moduleieall_image.css\" type=\"text/css\" />\n<![endif]-->");
	$library->setLibrary('pg-css-ie-mri', 1);
}

// PARAMS - direct from Phoca Gallery Global configuration
$component			=	'com_phocagallery';
$paramsC			= JComponentHelper::getParams($component) ;

// PARAMS
$tmpl['formaticon'] 		= $paramsC->get( 'icon_format', 'png' );
$limit_start 				= $params->get( 'limit_start', 0 );
$limit_count 				= $params->get( 'limit_count', 1 );
$category_id 				= $params->get( 'category_id', array() );
$display_description_detail = $params->get( 'display_description_detail', 0 );
$description_detail_height 	= $params->get( 'description_detail_height', 16 );
$display_categories         = $params->get( 'display_categories', '' );
$display_not_categories     = $params->get( 'display_not_categories', '' );
$font_color 				= $params->get( 'font_color', '#135cae' );
$background_color 			= $params->get( 'background_color', '#fcfcfc' );
$background_color_hover 	= $params->get( 'background_color_hover', '#f5f5f5' );
$image_background_color 	= $params->get( 'image_background_color', '#f5f5f5' );
$border_color 				= $params->get( 'border_color','#e8e8e8' );
$border_color_hover 		= $params->get( 'border_color_hover','#135cae' );
$phocagallery_module_width 	= $params->get( 'phocagallery_module_width', '' );
$display_name 				= $params->get( 'display_name', 1 );
$display_icon_detail 		= $params->get( 'display_icon_detail', 1 );
$display_icon_download 		= $params->get( 'display_icon_download', 0 );
$display_rating_img			= $paramsC->get( 'display_rating_img', 0);
$font_size_name 			= $params->get( 'font_size_name', 12 );
$char_length_name 			= $params->get( 'char_length_name', 11 );
$tmpl['detailwindow'] 		= $params->get( 'detail_window', 0 );
$medium_image_width 		= $paramsC->get( 'medium_image_width' , 100 );
$medium_image_height 		= $paramsC->get( 'medium_image_height', 100 );
$small_image_width 			= $paramsC->get( 'small_image_width' , 50 );
$small_image_height 		= $paramsC->get( 'small_image_height', 50 );
$custom_image_width 		= $params->get( 'custom_image_width' , '' );
$custom_image_height 		= $params->get( 'custom_image_height', '' );
$minimum_box_width	 		= $params->get( 'minimum_box_width', '' );
$popup_width 				= $paramsC->get( 'front_modal_box_width', 680 );
$popup_height 				= $paramsC->get( 'front_modal_box_height', 560 );
$image_background_shadow 	= $params->get( 'image_background_shadow', 'none' );
$module_type 				= $params->get( 'module_type', 0 );
$module_link 				= $params->get( 'module_link', 0 );
$padding_mosaic 			= $params->get( 'padding_mosaic', 3 );	
$image_ordering 			= $params->get( 'image_ordering', 9 );
$imageSize					= $params->get( 'image_size', 'small' ); //Additional variable take from parameters for image size override KM 08-05-12

$tmpl['highslidedescription']		= $params->get( 'highslide_description', 0 );
$tmpl['jakslideshowdelay']			= $params->get( 'jak_slideshow_delay', 5);
$tmpl['jakorientation']				= $params->get( 'jak_orientation', 'none');
$tmpl['jakdescription']				= $params->get( 'jak_description', 1);
$tmpl['jakdescriptionheight']		= $params->get( 'jak_description_height', 0);

//Custom image width and size
if ((int)$custom_image_width > 0) {
	$medium_image_width = $custom_image_width;
}
/*
if ((int)$custom_image_height > 0) {
	$medium_image_height = $custom_image_height;
}*/

//Customisation for allowing admins ot override the size of the image used
// Created by Keith Mountifield 08/05/2012
if($imageSize == 'auto'){
	if ($module_type == 1) {
		$imgCatSize	= 'small';
	} else {
		$imgCatSize	= 'medium';
	}
} else {
	$imgCatSize = $imageSize;
}
// If Module link is to category or categories, the detail window method needs to be set to no popup
if ((int)$module_link > 0) {
	$tmpl['detailwindow'] = 7;
}	


// PARAMS - Background shadow

if ( $image_background_shadow != 'none' ) {	
	
	// IE hack
	$shadowPath = $path->image_abs_front . $image_background_shadow.'.'.$tmpl['formaticon'];
	$shadowSize	= @getimagesize($shadowPath);
	if (isset($shadowSize[0]) && isset($shadowSize[0])) {
		$w = (int)$medium_image_width  + 18 - (int)$shadowSize[0];
		$h = (int)$medium_image_height + 18 - (int)$shadowSize[1];
		if ($w != 0) {$w = $w/2;} // plus or minus should be divided, not null
		if ($h != 0) {$h = $h/2;}
	} else {
		$w = $h = 0;
	}
	$imageBgCSS = 'background: url(\''.JURI::base(true).'/components/com_phocagallery/assets/images/'.$image_background_shadow.'.'.$tmpl['formaticon'].'\') 50% 50% no-repeat;';
	
	$imageBgCSSIE = 'background: url(\''.JURI::base(true).'/components/com_phocagallery/assets/images/'.$image_background_shadow.'.'.$tmpl['formaticon'].'\') '.$w.'px '.$h.'px no-repeat;';
	
} else {
	
	$imageBgCSS = 'background: '.$image_background_color .';';
	$imageBgCSSIE = '';
}

if ($module_type == 0) {
	$document->addCustomTag( "\n" ."<style type=\"text/css\">\n"
	." #phocagallery-module-ri .name {color: $font_color ;}\n"
	." #phocagallery-module-ri .phocagallery-box-file {background: $background_color ; border:1px solid $border_color ;}\n"
	." #phocagallery-module-ri .phocagallery-box-file-first { $imageBgCSS }\n"
	." #phocagallery-module-ri .phocagallery-box-file:hover, .phocagallery-box-file.hover {border:1px solid $border_color_hover ; background: $background_color_hover ;}\n"
	." </style>\n"
	.'<!--[if lt IE 8]>' . "\n" 
	. '<style type="text/css">' . "\n"
	." #phocagallery-module-ri .phocagallery-box-file-first { $imageBgCSSIE }\n"
	.' </style>'. "\n" .'<![endif]-->' . "\n");
}





if ( $libraries['pg-css-ie-hover']->value == 0 ) {
	$document->addCustomTag( PhocaGalleryRenderFront::renderIeHover());
	$library->setLibrary('pg-css-ie-hover', 1);
}
//END CSS

// PARAMS
if ($display_description_detail == 1) {
	$popup_height	= $popup_height + $description_detail_height;
}

$category_box_space 	= $params->get( 'category_box_space', 0 );
$detail_buttons 		= $params->get( 'detail_buttons', 1 );
if ($detail_buttons != 1) {
	$popup_height	= $popup_height - 45;
}
$popup_height_rating = $popup_height;
if ($display_rating_img == 1) {
	$popup_height_rating	= $popup_height + 35;
}

// PARAMS
$modal_box_overlay_color 	= $params->get( 'modal_box_overlay_color', '#000000' );
$modal_box_overlay_opacity 	= $params->get( 'modal_box_overlay_opacity', 0.3 );
$modal_box_border_color 	= $params->get( 'modal_box_border_color', '#6b6b6b' );
$modal_box_border_width 	= $params->get( 'modal_box_border_width', '2' );
$highslide_class			= $params->get( 'highslide_class', 'rounded-white');
$highslide_opacity			= $params->get( 'highslide_opacity', 0);
$highslide_outline_type		= $params->get( 'highslide_outline_type', 'rounded-white');
$highslide_fullimg			= $params->get( 'highslide_fullimg', 0);
$highslide_slideshow		= $params->get( 'highslide_slideshow', 1);
$highslide_close_button		= $params->get( 'highslide_close_button', 0);

// Window
// =======================================================
// DIFFERENT METHODS OF DISPLAYING THE DETAIL VIEW
// =======================================================
		
// MODAL - will be displayed in case e.g. highslide or shadowbox too, because in there are more links 
JHTML::_('behavior.modal', 'a.modal-button');

// CSS 
$document->addCustomTag( "<style type=\"text/css\"> \n"  
	." #sbox-window.phocagallery-random-window   {background-color:".$modal_box_border_color.";padding:".$modal_box_border_width."px} \n"
	." #sbox-overlay.phocagallery-random-overlay  {background-color:".$modal_box_overlay_color.";} \n"			
	." </style> \n");
	

// BUTTON (IMAGE - standard, modal, shadowbox)
$button = new JObject();
$button->set('name', 'image');

// BUTTON (ICON - standard, modal, shadowbox)
$button2 = new JObject();
$button2->set('name', 'icon');

// BUTTON OTHER (geotagging, downloadlink, ...)
$buttonOther = new JObject();
$buttonOther->set('name', 'other');

$tmpl ['highslideonclick']	= '';// for using with highslide


// Random Number - because of more modules on the site
$randName	= 'PhocaGalleryRIM' . substr(md5(uniqid(time())), 0, 8);
$randName2	= 'PhocaGalleryRIM2' . substr(md5(uniqid(time())), 0, 8);
		
// -------------------------------------------------------
// STANDARD POPUP
// -------------------------------------------------------

if ($tmpl['detailwindow'] == 1) {
	
	$button->set('methodname', 'js-button');
	$button->set('options', "window.open(this.href,'win2','width=".$popup_width.",height=".$popup_height.",scrollbars=yes,menubar=no,resizable=yes'); return false;");
	$button->set('optionsrating', "window.open(this.href,'win2','width=".$popup_width.",height=".$popup_height_rating.",scrollbars=yes,menubar=no,resizable=yes'); return false;");
			
	$button2->methodname 		= &$button->methodname;
	$button2->options 			= &$button->options;
	$buttonOther->methodname  	= &$button->methodname;
	$buttonOther->options 		= &$button->options;
	$buttonOther->optionsrating = &$button->optionsrating;
	
}

// -------------------------------------------------------
// MODAL BOX
// -------------------------------------------------------

else if ($tmpl['detailwindow'] == 0 || $tmpl['detailwindow'] == 2) { 
	
	// Button
	$button->set('modal', true);
	$button->set('methodname', 'modal-button');
	
	$button2->modal 			= &$button->modal;
	$button2->methodname 		= &$button->methodname;
	$buttonOther->modal 		= &$button->modal;
	$buttonOther->methodname  	= &$button->methodname;
	
	
	if ($tmpl['detailwindow'] == 2) {
				
		$button->set('options', "{handler: 'image', size: {x: 200, y: 150}, overlayOpacity: ".$modal_box_overlay_opacity.", classWindow: 'phocagallery-random-window', classOverlay: 'phocagallery-random-overlay'}");
		$button2->options 		= &$button->options;
		$buttonOther->set('options', "{handler: 'iframe', size: {x: ".$popup_width.", y: ".$popup_height."}, overlayOpacity: ".$modal_box_overlay_opacity.", classWindow: 'phocagallery-random-window', classOverlay: 'phocagallery-random-overlay'}");
		$buttonOther->set('optionsrating', "{handler: 'iframe', size: {x: ".$popup_width.", y: ".$popup_height_rating."}, overlayOpacity: ".$modal_box_overlay_opacity.", classWindow: 'phocagallery-random-window', classOverlay: 'phocagallery-random-overlay'}");
	
	// Modal - Iframe 			
	} else {
	
		$button->set('options', "{handler: 'iframe', size: {x: ".$popup_width.", y: ".$popup_height."}, overlayOpacity: ".$modal_box_overlay_opacity.", classWindow: 'phocagallery-random-window', classOverlay: 'phocagallery-random-overlay'}");
		$buttonOther->set('optionsrating', "{handler: 'iframe', size: {x: ".$popup_width.", y: ".$popup_height_rating."}, overlayOpacity: ".$modal_box_overlay_opacity.", classWindow: 'phocagallery-random-window', classOverlay: 'phocagallery-random-overlay'}");
		
		$button2->options 		= &$button->options;
		$buttonOther->options  	= &$button->options;
	
	}
} 

// -------------------------------------------------------
// SHADOW BOX
// -------------------------------------------------------
else if ($tmpl['detailwindow'] == 3) {


	$sb_slideshow_delay			= $params->get( 'sb_slideshow_delay', 5 );
	$sb_lang					= $paramsC->get( 'sb_lang', 'en' );
	
	$button->set('methodname', 'shadowbox-button-rim');
	$button->set('options', "shadowbox[".$randName."];options={slideshowDelay:".$sb_slideshow_delay."}");
		
	$button2->methodname 		= &$button->methodname;
	$button2->set('options', "shadowbox[".$randName2."];options={slideshowDelay:".$sb_slideshow_delay."}");
	
	$buttonOther->set('modal', true);
	$buttonOther->set('methodname', 'modal-button');
	$buttonOther->set('options', "{handler: 'iframe', size: {x: ".$popup_width.", y: ".$popup_height."}, overlayOpacity: ".$modal_box_overlay_opacity.", classWindow: 'phocagallery-random-window', classOverlay: 'phocagallery-random-overlay'}");
	$buttonOther->set('optionsrating', "{handler: 'iframe', size: {x: ".$popup_width.", y: ".$popup_height_rating."}, overlayOpacity: ".$modal_box_overlay_opacity."}");
	
	$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/shadowbox/shadowbox.js');	
		
	if ( $libraries['pg-group-shadowbox']->value == 0 ) {
		$document->addCustomTag('<script type="text/javascript">
Shadowbox.loadSkin("classic", "'.JURI::base(true).'/components/com_phocagallery/assets/js/shadowbox/src/skin");
Shadowbox.loadLanguage("'.$sb_lang.'", "'.JURI::base(true).'/components/com_phocagallery/assets/js/shadowbox/src/lang");
Shadowbox.loadPlayer(["img"], "'.JURI::base(true).'/components/com_phocagallery/assets/js/shadowbox/src/player");
window.addEvent(\'domready\', function(){
   Shadowbox.init()
});
</script>');
		$library->setLibrary('pg-group-shadowbox', 1);
	}
	
}
		
// -------------------------------------------------------
// HIGHSLIDE JS
// -------------------------------------------------------

else if ($tmpl['detailwindow'] == 4) {
			
	$button->set('methodname', 'highslide');
	$button2->methodname 		= &$button->methodname;
	$buttonOther->methodname 	= &$button->methodname;
	
	$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/highslide/highslide-full.js');
	$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/js/highslide/highslide.css');
	
	if ( $libraries['pg-group-highslide']->value == 0 ) {
		$document->addCustomTag( PhocaGalleryRenderFront::renderHighslideJSAll());
		$document->addCustomTag('<!--[if lt IE 7]><link rel="stylesheet" type="text/css" href="'.JURI::base(true).'/components/com_phocagallery/assets/js/highslide/highslide-ie6.css" /><![endif]-->');
		$library->setLibrary('pg-group-highslide', 1);
	}
	
	$document->addCustomTag( PhocaGalleryRenderFront::renderHighslideJS('ri', $popup_width, $popup_height, $highslide_outline_type, $highslide_opacity));
	$tmpl['highslideonclick'] = 'return hs.htmlExpand(this, phocaZoomRI )';
}		

// -------------------------------------------------------
// HIGHSLIDE JS IMAGE ONLY
// -------------------------------------------------------

else if ($tmpl['detailwindow'] == 5) {
		
	$button->set('methodname', 'highslide');
	$button2->methodname 		= &$button->methodname;
	$buttonOther->methodname 	= &$button->methodname;
	

	$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/highslide/highslide-full.js');
	$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/js/highslide/highslide.css');
	

	if ( $libraries['pg-group-highslide']->value == 0 ) {		
		$document->addCustomTag( PhocaGalleryRenderFront::renderHighslideJSAll());
		$document->addCustomTag('<!--[if lt IE 7]><link rel="stylesheet" type="text/css" href="'.JURI::base(true).'/components/com_phocagallery/assets/js/highslide/highslide-ie6.css" /><![endif]-->');
		$library->setLibrary('pg-group-highslide', 1);
	}
	
	$document->addCustomTag( PhocaGalleryRenderFront::renderHighslideJS('ri', $popup_width, $popup_height, $highslide_slideshow, $highslide_class, $highslide_outline_type, $highslide_opacity, $highslide_close_button));
	$tmpl['highslideonclick2']	= 'return hs.htmlExpand(this, phocaZoomRI )';
	$tmpl['highslideonclick']	= PhocaGalleryRenderFront::renderHighslideJSImage('ri', $highslide_class, $highslide_outline_type, $highslide_opacity, $highslide_fullimg);
	
}

// -------------------------------------------------------
// JAK LIGHTBOX
// -------------------------------------------------------

else if ($tmpl['detailwindow'] == 6) {

	$button->set('methodname', 'jaklightbox');
	$button2->methodname 	= &$button->methodname;

	$buttonOther->set('modal', true);
	$buttonOther->set('methodname', 'modal-button');
	$buttonOther->set('options', "{handler: 'iframe', size: {x: ".$popup_width.", y: ".$popup_height."}, overlayOpacity: ".$modal_box_overlay_opacity."}");
	$buttonOther->set('optionsrating', "{handler: 'iframe', size: {x: ".$popup_width.", y: ".$popup_height_rating."}, overlayOpacity: ".$modal_box_overlay_opacity."}");


	$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/jak/jak_compressed.js');
	$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/jak/lightbox_compressed.js');
	$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/jak/jak_slideshow.js');
	$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/jak/window_compressed.js');
	$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/jak/interpolator_compressed.js');		
	$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/js/jak/lightbox-slideshow.css');
	
	$lHeight 		= 472 + (int)$tmpl['jakdescriptionheight'];
	$lcHeight		= 10 + (int)$tmpl['jakdescriptionheight'];
	$customJakTag	= '';
	if ($tmpl['jakorientation'] == 'horizontal') {
		$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/js/jak/lightbox-horizontal.css');
	} else if ($tmpl['jakorientation'] == 'vertical'){
		$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/js/jak/lightbox-vertical.css');
		$customJakTag .= '.lightBox {height: '.$lHeight.'px;}'
						.'.lightBox .image-browser-caption { height: '.$lcHeight.'px;}';
	} else  {
		$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/js/jak/lightbox-vertical.css');
		$customJakTag .= '.lightBox {height: '.$lHeight.'px;width:800px;}'
					.'.lightBox .image-browser-caption { height: '.$lcHeight.'px;}'
					.'.lightBox .image-browser-thumbs { display:none;}'
					.'.lightBox .image-browser-thumbs div.image-browser-thumb-box { display:none;}';
	}
	
	if ($customJakTag != '') {
		$document->addCustomTag("<style type=\"text/css\">\n". $customJakTag. "\n"."</style>");
	}
	
	if ( $libraries['pg-group-jak-mod']->value == 0 ) {		
		$document->addCustomTag( PhocaGalleryRenderFront::renderJakJs($tmpl['jakslideshowdelay'], $tmpl['jakorientation'], 'optgjaksMod'.$randName));
		$library->setLibrary('pg-group-jak-mod', 1);
	}
	
}

// -------------------------------------------------------
// NO POPUP
// -------------------------------------------------------

else if ($tmpl['detailwindow'] == 7) {

	$button->set('methodname', 'no-popup');
	$button2->methodname 	= &$button->methodname;

	
	$buttonOther->set('modal', true);
	$buttonOther->set('methodname', 'no-popup');
	$buttonOther->set('options', "");
	$buttonOther->set('optionsrating', "");
	
}

// -------------------------------------------------------
// SLIMBOX
// -------------------------------------------------------

else if ($tmpl['detailwindow'] == 8) {

	$button->set('methodname', 'slimbox');
	$button2->methodname 		= &$button->methodname;
	$button2->methodname 		= &$button->methodname;
	$button2->set('options', "lightbox-images");
	
	$buttonOther->set('modal', true);
	$buttonOther->set('methodname', 'modal-button');
	$buttonOther->set('options', "{handler: 'iframe', size: {x: ".$popup_width.", y: ".$popup_height."}, overlayOpacity: ".$modal_box_overlay_opacity."}");
	$buttonOther->set('optionsrating', "{handler: 'iframe', size: {x: ".$popup_width.", y: ".$popup_height_rating."}, overlayOpacity: ".$modal_box_overlay_opacity."}");

	$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/slimbox/slimbox.js');
	$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/js/slimbox/css/slimbox.css');

}

// -------------------------------------------------------
// BOXPLUS (BOXPLUS + BOXPLUS (IMAGE ONLY))
// -------------------------------------------------------
		
else if ($tmpl['detailwindow'] == 9 || $tmpl['detailwindow'] == 10) {
	
	$language = JFactory::getLanguage();
	
	$tmpl['boxplus_theme']				= $paramsC->get( 'boxplus_theme', 'lightsquare');
	$tmpl['boxplus_bautocenter']		= (int)$paramsC->get( 'boxplus_bautocenter', 1);
	$tmpl['boxplus_autofit']			= (int)$paramsC->get( 'boxplus_autofit', 1);
	$tmpl['boxplus_slideshow']			= (int)$paramsC->get( 'boxplus_slideshow', 0);
	$tmpl['boxplus_loop']				= (int)$paramsC->get( 'boxplus_loop', 0);
	$tmpl['boxplus_captions']			= $paramsC->get( 'boxplus_captions', 'bottom');
	$tmpl['boxplus_thumbs']				= $paramsC->get( 'boxplus_thumbs', 'inside');
	$tmpl['boxplus_duration']			= (int)$paramsC->get( 'boxplus_duration', 250);
	$tmpl['boxplus_transition']			= $paramsC->get( 'boxplus_transition', 'linear');
	$tmpl['boxplus_contextmenu']		= (int)$paramsC->get( 'boxplus_contextmenu', 1);

	$button->set('options', 'phocagallerycboxplusri');
	$button->set('methodname', 'phocagallerycboxplusri');
	$button2->set('options', "phocagallerycboxplusiri");
	$button2->set('methodname', 'phocagallerycboxplusiri');
	$buttonOther->set('methodname', 'phocagallerycboxplusori');
	$buttonOther->set('options', "phocagallerycboxplusori");
	$buttonOther->set('optionsrating', "phocagallerycboxplusori");
	
	//if ($crossdomain) {
	//	$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/boxplus/jsonp.mootools.js');
	//}
	$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/boxplus/boxplus.js');
	$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/boxplus/boxplus.lang.js?lang='.$language->getTag());
	
	$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/js/boxplus/css/boxplus.css');
	if ($language->isRTL()) {
		$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/js/boxplus/css/boxplus.rtl.css');
	}
	$document->addCustomTag('<!--[if lt IE 9]><link rel="stylesheet" href="'.JURI::base(true).'/components/com_phocagallery/assets/js/boxplus/css/boxplus.ie8.css" type="text/css" /><![endif]-->');
	$document->addCustomTag('<!--[if lt IE 8]><link rel="stylesheet" href="'.JURI::base(true).'/components/com_phocagallery/assets/js/boxplus/css/boxplus.ie7.css" type="text/css" /><![endif]-->');
	$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/js/boxplus/css/boxplus.'.$tmpl['boxplus_theme'].'.css', 'text/css', null, array('title'=>'boxplus-'.$tmpl['boxplus_theme']));
	
	if (file_exists(JPATH_BASE.DS.'components'.DS.'com_phocagallery'.DS.'assets'.DS.'js'.DS.'boxplus'.DS.'css'.DS.'boxplus.'.$tmpl['boxplus_theme'])) {  // use IE-specific stylesheet only if it exists
		$this->addCustomTag('<!--[if lt IE 9]><link rel="stylesheet" href="'.JURI::base(true).'/components/com_phocagallery/assets/js/boxplus/css/boxplus.'.$tmpl['boxplus_theme'].'.ie8.css" type="text/css" title="boxplus-'.$tmpl['boxplus_theme'].'" /><![endif]-->');
	}
	
	$document->addScriptDeclaration('window.addEvent("domready", function () {');
	
	if ($tmpl['detailwindow'] == 10) {
		// Image
		$document->addScriptDeclaration('new boxplus($$("a.phocagallerycboxplusri"),{"theme":"'.$tmpl['boxplus_theme'].'","autocenter":'.(int)$tmpl['boxplus_bautocenter'].',"autofit":'.(int)$tmpl['boxplus_autofit'].',"slideshow":'.(int)$tmpl['boxplus_slideshow'].',"loop":'.(int)$tmpl['boxplus_loop'].',"captions":"'.$tmpl['boxplus_captions'].'","thumbs":"'.$tmpl['boxplus_thumbs'].'","width":'.(int)$popup_width.',"height":'.(int)$popup_height.',"duration":'.(int)$tmpl['boxplus_duration'].',"transition":"'.$tmpl['boxplus_transition'].'","contextmenu":'.(int)$tmpl['boxplus_contextmenu'].', phocamethod:1});');
		
		// Icon
		$document->addScriptDeclaration('new boxplus($$("a.phocagallerycboxplusiri"),{"theme":"'.$tmpl['boxplus_theme'].'","autocenter":'.(int)$tmpl['boxplus_bautocenter'].',"autofit":'.(int)$tmpl['boxplus_autofit'].',"slideshow":'.(int)$tmpl['boxplus_slideshow'].',"loop":'.(int)$tmpl['boxplus_loop'].',"captions":"'.$tmpl['boxplus_captions'].'","thumbs":"hide","width":'.(int)$popup_width.',"height":'.(int)$popup_height.',"duration":'.(int)$tmpl['boxplus_duration'].',"transition":"'.$tmpl['boxplus_transition'].'","contextmenu":'.(int)$tmpl['boxplus_contextmenu'].', phocamethod:1});');
		
	} else {
		// Image
		$document->addScriptDeclaration('new boxplus($$("a.phocagallerycboxplusri"),{"theme":"'.$tmpl['boxplus_theme'].'","autocenter":'.(int)$tmpl['boxplus_bautocenter'].',"autofit": false,"slideshow": false,"loop":false,"captions":"none","thumbs":"hide","width":'.(int)$popup_width.',"height":'.(int)$popup_height.',"duration":0,"transition":"linear","contextmenu":false, phocamethod:2});');
	
		// Icon
		$document->addScriptDeclaration('new boxplus($$("a.phocagallerycboxplusiri"),{"theme":"'.$tmpl['boxplus_theme'].'","autocenter":'.(int)$tmpl['boxplus_bautocenter'].',"autofit": false,"slideshow": false,"loop":false,"captions":"none","thumbs":"hide","width":'.(int)$popup_width.',"height":'.(int)$popup_height.',"duration":0,"transition":"linear","contextmenu":false, phocamethod:2});');
	}
	
	// Other (Map, Info, Download)
	$document->addScriptDeclaration('new boxplus($$("a.phocagallerycboxplusori"),{"theme":"'.$tmpl['boxplus_theme'].'","autocenter":'.(int)$tmpl['boxplus_bautocenter'].',"autofit": false,"slideshow": false,"loop":false,"captions":"none","thumbs":"hide","width":'.(int)$popup_width.',"height":'.(int)$popup_height.',"duration":0,"transition":"linear","contextmenu":false, phocamethod:2});');
	
	$document->addScriptDeclaration('});');
}

$folderButton = new JObject();
$folderButton->set('name', 'image');
$folderButton->set('options', "");		
// END DETAIL WINDOW	
		
// ACCESS RIGHTS
// All categories where the user has access
$query = 'SELECT cc.title AS text, cc.id AS id, cc.parent_id as parentid, cc.alias as alias, cc.access as access, cc.accessuserid as accessuserid'
		. ' FROM #__phocagallery_categories AS cc'
		. ' WHERE cc.published = 1'
		. ' AND cc.access <= '. $user->get('aid', 0);
if ($display_categories) {
	$query .= ' AND cc.id IN ('. $display_categories . ')' ;
}
if ($display_not_categories) {
	$query .= ' AND cc.id NOT IN ('. $display_not_categories . ')' ;
}
$query .= ' ORDER BY cc.ordering';

$db->setQuery( $query );
$categories = $db->loadObjectList();

//$neededAccessLevels	= PhocaGalleryAccess::getNeededAccessLevels();
//$access				= PhocaGalleryAccess::isAccess($user->authorisedLevels(), $neededAccessLevels);

$unSet = 0;
foreach ($categories as $key => $category) { 
	// USER RIGHT - ACCESS - - - - - -
	$rightDisplay	= 1;
	
	if (isset($categories[$key])){
		$rightDisplay = PhocaGalleryAccess::getUserRight('accessuserid', $categories[$key]->accessuserid, $categories[$key]->access, $user->authorisedLevels(), $user->get('id', 0), 0);
	}
	if ($rightDisplay == 0) {
		unset($categories[$key]);
		$unSet = 1;
	}
	// - - - - - - - - - - - - - - - - 
}
if ($unSet == 1) {
	$categories = array_values($categories);
}	
$allowedCategories = $categories;

// From objects to array only
$allowedCategoriesArray = array();
foreach ($allowedCategories as $key => $value) {
	$allowedCategoriesArray[] = $value->id;
}

// Implode the array
$implodeAllowedCategoriesArray = implode( ',', $allowedCategoriesArray);



// Category ID - If the category is set, the images are taken from this category and the selection above is not accepted
// 1) User has selected categories
if ($category_id != '' && is_array($category_id) && count($category_id)) {
	$implodeAllowedCategoriesArray = implode( ',', $category_id);
}
// 2) User has selected only one catetory
else if ($category_id != '' && !is_array($category_id)) {
	$implodeAllowedCategoriesArray = (int)$category_id;
}
// 3) If no category was selected, all will be used

if ($image_ordering == 9) {
	$imageOrdering = ' ORDER BY RAND()'; 
} else {

	$iOA = PhocaGalleryOrdering::getOrderingString($image_ordering);
	$imageOrdering = $iOA['output'];
}


$image = '';
$query = 'SELECT cc.id AS idcat, a.id AS idimage'
.' FROM #__phocagallery_categories AS cc'
.' LEFT JOIN #__phocagallery AS a ON a.catid = cc.id'
.' WHERE a.published = 1'
.' AND a.approved = 1'
.' AND cc.published = 1';
if ($implodeAllowedCategoriesArray != '') {
	$query .= ' AND cc.id IN ('.$implodeAllowedCategoriesArray.')'; // not images from not accessable categories
}
$query .= $imageOrdering
.' LIMIT ' . $limit_start . ',' . $limit_count ;

$db->setQuery($query);
$images 		= $db->loadObjectList();
$imageArray 	= array();


// QUERIES - all data we need to display the image
if ($images) {

	foreach ($images as $valueImage) {
		$imageArray[] = $valueImage->idimage;
	}
	$imageIds = implode(',', $imageArray);

	$query = 'SELECT cc.id, cc.alias as catalias, a.id, a.catid, a.title, a.alias, a.filename, a.description, a.extm, a.exts,a.extl, a.exto, a.extw, a.exth, a.extid,'
	. ' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(\':\', cc.id, cc.alias) ELSE cc.id END as catslug, '
	. ' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(\':\', a.id, a.alias) ELSE a.id END as slug'
	. ' FROM #__phocagallery_categories AS cc'
	. ' LEFT JOIN #__phocagallery AS a ON a.catid = cc.id'
	. ' WHERE a.id in (' . $imageIds . ')'
	.$imageOrdering;

	$db->setQuery($query);
	$imagesArray = $db->loadObjectList();
	$output	= array();

	// Maximum size of module image is 100 x 100
	jimport( 'joomla.filesystem.file' );
	
	
	
	$i = 0;
	foreach($imagesArray as $valueImages){
		
		$medium_img = PhocaGalleryFileThumbnail::getThumbnailName($valueImages->filename, 'medium');
			
		$medium_img_Link		=  $medium_img->rel;
		
		/*if (JFile::exists($medium_img->abs)) {
			$medium_img_m = $medium_img_Link;//当前缩略大图片
		}*/
		
		$output[$i] = '<li><a href="'.JRoute::_("index.php?option=com_phocagallery&view=detail&catid=".$valueImages->catid."&id=".$valueImages->id."&Itemid=481").'" width="140" height="134" title="" class="pic"><img src="'.$medium_img_Link.'"  

alt="" title=""></a></li>';
		$i++;
	}
	
	// ADD JAK DATA CSS style
		if ( $tmpl['detailwindow'] == 6 ) {
			$document->addCustomTag('<script type="text/javascript">'
			. 'var dataJakJsMod'.$randName.' = ['
			. implode($tmpl['jakdatajs'], ',')
			. ']'
			. '</script>');
		}
	
} else {
	$i = 0;
	$output[$i] = ''; // there is no image to get it as random image
}

require(JModuleHelper::getLayoutPath('mod_phocagallery_image'));
?>