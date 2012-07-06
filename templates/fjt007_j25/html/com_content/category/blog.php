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
		      <span>�����ڵ�λ�ã�<a href="#" title="">��ҳ</a></span> </li> 
		    <li class="arrow">&gt;</li> 
		    <li><a href="#" title="">�û�����</a></li> 
		    <li class="arrow">&gt;</li> 
		    <li class="terminal">�ҵı���</li> 
		  </ul> 
		</div> 
 
      <div class="listingCon"> 
        <h2 class="hdTitle">�����б�</h2> 
        <?php if (count($this->children[$this->category->id]) > 0 && $this->maxLevel != 0) : ?>
        <ul class="cate-nav-list"> 
        <?php foreach($this->children[$this->category->id] as $id => $child) : ?>
          <li>
          	  <a href="<?php echo JRoute::_("index.php?option=com_content&view=category&layout=blog&id=".$child->id."&Itemid=". JRequest::getVar('Itemid', 0, '', 'int'));?>" title="">
          		<?php echo $this->escape($child->title); ?>
          	  </a>
          </li> 
          <!-- <li><a href="#" title="">����ҵ</a></li> 
          <li><a href="#" title="">������</a></li> 
          <li><a href="#" title="">���һ�</a></li> -->
        <?php endforeach; ?>
        </ul> 
        <?php endif;?>
        <div class="chapterTotal">����<span class="txt-data webtxt"><?php echo $child->getNumItems(true); ?></span>ƪ����</div> 
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
              <p class="info">�������<span class="webtxt"><?php echo $this->item->hits; ?>��</span><span class="time"><?php echo substr(JHtml::_('date', $this->item->created), 0,10);?></span></p> 
              <p class="tags" style="margin: 0;margin-top:-32px;"><strong>�ؼ��ʣ�</strong><span class="txt-data"><?php echo $keyword;?></span></p> 
              <?php echo $this->item->introtext; ?>
              <div class="other"><a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid)); ?>" title="">�Ķ�ȫ��</a></div> 
            </dd> 
          </dl> 
          <?php endforeach; ?>
         <!--  <dl> 
            <dt><a href="#" title=""><img src="images/info/items_1.jpg" alt="" title=""></a></dt> 
            <dd> 
              <h3><a href="#" title="">����ɫ���� 50ͼڹ�ͳ���ɫ�ʶ���</a></h3> 
              <p class="info">�������<span class="webtxt">9988��</span><span class="time">2012-6-14</span></p> 
              <p class="tags"><strong>�ؼ��ʣ�</strong><span class="txt-data">�������</span><span class="txt-data">������ɫ</span><span class="txt-data">�������</span><span class="txt-data">����ߴ�</span></p> 
              <p class="desc">��ǳ�������������ɫ���ĺ죬�ٴ�İ�......�����λ�ɫ�ʵ������������ʼ�ձ����峺�������ĸо��������������Ŀռ���Եô���ɰ���������˼��50ͼΪ�����ֶ���������ڹ�ͳ���ɫ�ʶ��塣</p> 
              <div class="other"><a href="#" title="">�Ķ�ȫ��</a></div> 
            </dd> 
          </dl> 
          <dl> 
            <dt><a href="#" title=""><img src="images/info/items_2.jpg" alt="" title=""></a></dt> 
            <dd> 
              <h3><a href="#" title="">����ɫ���� 50ͼڹ�ͳ���ɫ�ʶ���</a></h3> 
              <p class="info">�������<span class="webtxt">9988��</span><span class="time">2012-6-14</span></p> 
              <p class="tags"><strong>�ؼ��ʣ�</strong><span class="txt-data">�������</span><span class="txt-data">������ɫ</span><span class="txt-data">�������</span><span class="txt-data">����ߴ�</span></p> 
              <p class="desc">��ǳ�������������ɫ���ĺ죬�ٴ�İ�......�����λ�ɫ�ʵ������������ʼ�ձ����峺�������ĸо��������������Ŀռ���Եô���ɰ���������˼��50ͼΪ�����ֶ���������ڹ�ͳ���ɫ�ʶ��塣</p> 
              <div class="other"><a href="#" title="">�Ķ�ȫ��</a></div> 
            </dd> 
          </dl> 
          <dl> 
            <dt><a href="#" title=""><img src="images/info/items_3.jpg" alt="" title=""></a></dt> 
            <dd> 
              <h3><a href="#" title="">����ɫ���� 50ͼڹ�ͳ���ɫ�ʶ���</a></h3> 
              <p class="info">�������<span class="webtxt">9988��</span><span class="time">2012-6-14</span></p> 
              <p class="tags"><strong>�ؼ��ʣ�</strong><span class="txt-data">�������</span><span class="txt-data">������ɫ</span><span class="txt-data">�������</span><span class="txt-data">����ߴ�</span></p> 
              <p class="desc">��ǳ�������������ɫ���ĺ죬�ٴ�İ�......�����λ�ɫ�ʵ������������ʼ�ձ����峺�������ĸо��������������Ŀռ���Եô���ɰ���������˼��50ͼΪ�����ֶ���������ڹ�ͳ���ɫ�ʶ��塣</p> 
              <div class="other"><a href="#" title="">�Ķ�ȫ��</a></div> 
            </dd> 
          </dl> 
          <dl> 
            <dt><a href="#" title=""><img src="images/info/items_4.jpg" alt="" title=""></a></dt> 
            <dd> 
              <h3><a href="#" title="">����ɫ���� 50ͼڹ�ͳ���ɫ�ʶ���</a></h3> 
              <p class="info">�������<span class="webtxt">9988��</span><span class="time">2012-6-14</span></p> 
              <p class="tags"><strong>�ؼ��ʣ�</strong><span class="txt-data">�������</span><span class="txt-data">������ɫ</span><span class="txt-data">�������</span><span class="txt-data">����ߴ�</span></p> 
              <p class="desc">��ǳ�������������ɫ���ĺ죬�ٴ�İ�......�����λ�ɫ�ʵ������������ʼ�ձ����峺�������ĸо��������������Ŀռ���Եô���ɰ���������˼��50ͼΪ�����ֶ���������ڹ�ͳ���ɫ�ʶ��塣</p> 
              <div class="other"><a href="#" title="">�Ķ�ȫ��</a></div> 
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
					    <li class="first"><a href="#">��ҳ</a></li> 
					    <li class="prev"><a href="#">��һҳ</a></li> 
					    <li><a href="#">1</a></li> 
					    <li><a href="#">2</a></li> 
					    <li><a class="this" href="#">3</a></li> 
					    <li><a href="#">4</a></li> 
					    <li><a href="#">5</a></li> 
					    <li><a class="dot" href="###">...</a></li> 
					    <li class="next"><a href="javascript:;">��һҳ</a></li> 
					    <li class="last"><a href="javascript:;">βҳ</a></li> 
					    <li class="page-nub">��<span>40</span>ҳ������
					      <input type="text" name="" id="" /> 
					      ҳ
					      <button type="submit">ȷ��</button> 
					    </li> 
					  </ul>  -->
					  
					  
				</div>

		</div> 
      </div> 
    </div> 
      <div class="chapterIntro"> 
        <h2>��������Ƽ�h2> 
        <div class="list"> 
          <ul class="items-list"> 
            <li class="except"><a href="#" title=""><img src="images/info/about_0.jpg" alt="" title=""></a></li> 
            <li><a href="#" title="">����30���˸�Ⱦ��������</a></li> 
            <li><a href="#" title="">����30���˸�Ⱦ��������</a></li> 
            <li><a href="#" title="">����30���˸�Ⱦ��������</a></li> 
            <li><a href="#" title="">����30���˸�Ⱦ��������</a></li> 
            <li><a href="#" title="">����30���˸�Ⱦ��������</a></li> 
            <li><a href="#" title="">����30���˸�Ⱦ��������</a></li> 
          </ul> 
          <ul class="items-list"> 
            <li class="except"><a href="#" title=""><img src="images/info/about_1.jpg" alt="" title=""></a></li> 
            <li><a href="#" title="">����30���˸�Ⱦ��������</a></li> 
            <li><a href="#" title="">����30���˸�Ⱦ��������</a></li> 
            <li><a href="#" title="">����30���˸�Ⱦ��������</a></li> 
            <li><a href="#" title="">����30���˸�Ⱦ��������</a></li> 
            <li><a href="#" title="">����30���˸�Ⱦ��������</a></li> 
            <li><a href="#" title="">����30���˸�Ⱦ��������</a></li> 
          </ul> 
          <ul class="items-list"> 
            <li class="except"><a href="#" title=""><img src="images/info/about_2.jpg" alt="" title=""></a></li> 
            <li><a href="#" title="">����30���˸�Ⱦ��������</a></li> 
            <li><a href="#" title="">����30���˸�Ⱦ��������</a></li> 
            <li><a href="#" title="">����30���˸�Ⱦ��������</a></li> 
            <li><a href="#" title="">����30���˸�Ⱦ��������</a></li> 
            <li><a href="#" title="">����30���˸�Ⱦ��������</a></li> 
            <li><a href="#" title="">����30���˸�Ⱦ��������</a></li> 
          </ul> 
        </div> 
      </div> 
  </div> 
  <div class="asideWrap"> 
    <div class="bord"> 
      <div class="introInfor"> 
<h2>������Ʒ</h2> 
  <dl> 
    <dt><a href="#" title=""><img src="images/info/other_0.jpg" alt="" title=""></a></dt> 
    <dd> 
      <h3><a href="#" title="">�����ݡ�����ɳ����</a></h3> 
      <p class="price"><span class="webtxt"><i class="rmb">&yen;</i><i class="txt-data">95.00</i></span></p> 
    </dd> 
  </dl> 
  <dl> 
    <dt><a href="#" title=""><img src="images/info/other_1.jpg" alt="" title=""></a></dt> 
    <dd> 
      <h3><a href="#" title="">�����ݡ�����ɳ����</a></h3> 
      <p class="price"><span class="webtxt"><i class="rmb">&yen;</i><i class="txt-data">95.00</i></span></p> 
    </dd> 
  </dl> 
  <dl> 
    <dt><a href="#" title=""><img src="images/info/other_2.jpg" alt="" title=""></a></dt> 
    <dd> 
      <h3><a href="#" title="">�����ݡ�����ɳ����</a></h3> 
      <p class="price"><span class="webtxt"><i class="rmb">&yen;</i><i class="txt-data">95.00</i></span></p> 
    </dd> 
  </dl> 
  <dl> 
    <dt><a href="#" title=""><img src="images/info/other_3.jpg" alt="" title=""></a></dt> 
    <dd> 
      <h3><a href="#" title="">�����ݡ�����ɳ����</a></h3> 
      <p class="price"><span class="webtxt"><i class="rmb">&yen;</i><i class="txt-data">95.00</i></span></p> 
    </dd> 
  </dl> 
</div> 
 
    </div> 
  </div> 
</div> 
