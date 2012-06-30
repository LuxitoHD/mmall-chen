<?php


// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

require_once (dirname(__FILE__) . DS . 'readmoreext' . DS . 'autolinks.php');
require_once JPATH_SITE . DS . 'components' . DS . 'com_content' . DS . 'helpers' . DS . 'route.php';

class plgContentReadMoreExt extends JPlugin
{

    function plgContentReadMoreExt(&$subject, $params)
    {
        parent::__construct($subject, $params);
    }

    function onContentBeforeDisplay($context, &$article, &$params, $limitstart)
    {
        $app = JFactory::getApplication();
        if ($app->isAdmin()) {
            return;
        }
        $option = JRequest :: getCmd('option');
        $onlyForComContent = $this->params->get('Only_For_Com_Content');
        if ($onlyForComContent && ($option != 'com_content')) {
            return;
        }
        $view = JRequest :: getCmd('view');
        if ($view == 'article') {
            return;
        }

        $ignore = $this->exclude('Exclude_Category_Ids', $article->catid);
        if ($ignore) {
            return;
        }
        $ignore = $this->exclude('Exclude_Article_Ids', $article->id);
        if ($ignore) {
            return;
        }
        $imgTitlePrefix = $this->params->get('ImgTitlePrefix');
        $imgAltPrefix = $this->params->get('ImgAltPrefix');
        $onlyFirstImage = $this->params->get('Only_For_First_Image');

        $autolinks = new AutoLinks($imgTitlePrefix, $imgAltPrefix, $onlyFirstImage);

        $link = "";
        if ($article->params->get('access-view')) {
            $link = JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid));
        } else {
            $menu = JFactory::getApplication()->getMenu();
            $active = $menu->getActive();
            $itemId = $active->id;
            $link1 = JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId);
            $returnURL = JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid));
            $link = new JURI($link1);
            $link->setVar('return', base64_encode($returnURL));
        }
        $article->introtext = $autolinks->handleImgLinks($article->introtext, $article->title, $link);


    }


    function exclude($paramName, $value)
    {
        $excludeIds = $this->params->get($paramName);
        $excludeIdsArray = explode(',', $excludeIds);
        if (empty($excludeIdsArray)) {
            return 0;
        }
        if (!$value) {
            return 0;
        }
        if (in_array($value, $excludeIdsArray, false)) {
            return 1;
        }
        return 0;
    }

}
//end class


