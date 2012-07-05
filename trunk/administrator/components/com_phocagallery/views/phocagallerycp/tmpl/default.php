<?php defined('_JEXEC') or die('Restricted access');?>

<form action="index.php" method="post" name="adminForm">
<div class="adminform">
<div class="cpanel-left">
	<div id="cpanel">
		<?php
		$link = 'index.php?option=com_phocagallery&view=phocagalleryimgs';
		echo PhocaGalleryRenderAdmin::quickIconButton( $link, 'icon-48-pg-image.png', JText::_('COM_PHOCAGALLERY_IMAGES') );
		
		$link = 'index.php?option=com_phocagallery&view=phocagallerycs';
		echo PhocaGalleryRenderAdmin::quickIconButton( $link, 'icon-48-pg-cat.png', JText::_( 'COM_PHOCAGALLERY_CATEGORIES' ) );
		
//		$link = 'index.php?option=com_phocagallery&view=phocagalleryt';
//		echo PhocaGalleryRenderAdmin::quickIconButton( $link, 'icon-48-pg-theme.png', JText::_( 'COM_PHOCAGALLERY_THEMES' ) );
		
//		$link = 'index.php?option=com_phocagallery&view=phocagalleryra';
//		echo PhocaGalleryRenderAdmin::quickIconButton( $link, 'icon-48-pg-vote.png', JText::_( 'COM_PHOCAGALLERY_CATEGORY_RATING' ) );
		
//		$link = 'index.php?option=com_phocagallery&view=phocagalleryraimg';
//		echo PhocaGalleryRenderAdmin::quickIconButton( $link, 'icon-48-pg-vote-img.png', JText::_( 'COM_PHOCAGALLERY_IMAGE_RATING' ) );
		
//		$link = 'index.php?option=com_phocagallery&view=phocagallerycos';
//		echo PhocaGalleryRenderAdmin::quickIconButton( $link, 'icon-48-pg-comment.png', JText::_( 'COM_PHOCAGALLERY_CATEGORY_COMMENTS' ) );
//		$link = 'index.php?option=com_phocagallery&view=phocagallerycoimgs';
//		echo PhocaGalleryRenderAdmin::quickIconButton( $link, 'icon-48-pg-comment-img.png', JText::_( 'COM_PHOCAGALLERY_IMAGE_COMMENTS' ) );
		
//		$link = 'index.php?option=com_phocagallery&view=phocagalleryusers';
//		echo PhocaGalleryRenderAdmin::quickIconButton( $link, 'icon-48-pg-users.png', JText::_( 'COM_PHOCAGALLERY_USERS' ) );
		
//		$link = 'index.php?option=com_phocagallery&view=phocagalleryfbs';
//		echo PhocaGalleryRenderAdmin::quickIconButton( $link, 'icon-48-pg-fb.png', JText::_( 'COM_PHOCAGALLERY_FB' ) );
		
		$link = 'index.php?option=com_phocagallery&view=phocagallerytags';
		echo PhocaGalleryRenderAdmin::quickIconButton( $link, 'icon-48-pg-tags.png', JText::_( 'COM_PHOCAGALLERY_TAGS' ) );
		
//		$link = 'index.php?option=com_phocagallery&view=phocagalleryimgs&task=phocagallerym.edit';
//		echo PhocaGalleryRenderAdmin::quickIconButton( $link, 'icon-48-pg-multiple.png', JText::_( 'COM_PHOCAGALLERY_MULTIPLE_ADD' ) );
		//$link = 'index.php?option=com_phocagallery&view=phocagalleryucs';
		//echo PhocaGalleryRenderAdmin::quickIconButton( $link, 'icon-48-pg-users-cat.png', JText::_( 'Users Categories' ) );
		
//		$link = 'index.php?option=com_phocagallery&view=phocagalleryin';
//		echo PhocaGalleryRenderAdmin::quickIconButton( $link, 'icon-48-pg-info.png', JText::_( 'COM_PHOCAGALLERY_INFO' ) );
		?>
				
		<div style="clear:both">&nbsp;</div>
	</div>
</div>
		

</div>

<input type="hidden" name="option" value="com_phocagallery" />
<input type="hidden" name="view" value="phocagallerycp" />
<input type="hidden" name="<?php echo JUtility::getToken(); ?>" value="1" />
</form>