<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_articles_category
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>

<?php 
	function cut_str1($string, $sublen, $start = 0, $code = 'UTF-8') 
     {
     	if($code == 'UTF-8')
     	{
     		$pa ="/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
     		preg_match_all($pa, $string, $t_string); if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen));
     		return join('', array_slice($t_string[0], $start, $sublen));
     	}
     	else
     	{
     		$start = $start*2;
     		$sublen = $sublen*2;
     		$strlen = strlen($string);
     		$tmpstr = ''; for($i=0; $i<$strlen; $i++)
     		{
     			if($i>=$start && $i<($start+$sublen))
     			{
     				if(ord(substr($string, $i, 1))>129)
     				{
     					$tmpstr.= substr($string, $i, 2);
     				}
     				else
     				{
     					$tmpstr.= substr($string, $i, 1);
     				}
     			}
     			if(ord(substr($string, $i, 1))>129) $i++;
     		}
     		if(strlen($tmpstr)<$strlen ) $tmpstr.= "";
     		return $tmpstr;
     	}
     }
?>
<div class="waterSupposed_body">
	<?php foreach ($list as $item) : ?>
	    <dl>
		    <?php $images = json_decode($item->images);?>
		    <dt>
		    	<img style="width: 134px;" title="<?php echo $item->title;?>" alt="<?php echo $item->title;?>" src="<?php echo $images->image_intro;?>"/>
		    </dt>
		    <dd>
		   	<h3>
		   	<?php if ($params->get('link_titles') == 1) : ?>
			<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
			<?php echo $item->title; ?>
	        <?php if ($item->displayHits) :?>
				<span class="mod-articles-category-hits">
	            (<?php echo $item->displayHits; ?>)  </span>
	        <?php endif; ?></a>
	        <?php else :?>
	        <?php echo $item->title; ?>
	        	<?php if ($item->displayHits) :?>
				<span class="mod-articles-category-hits">
	            (<?php echo $item->displayHits; ?>)  </span>
	        <?php endif; ?></a>
	            <?php endif; ?>
	        </h3>
	
			<p class="mod-articles-category-introtext">
				<?php echo cut_str1($item->introtext,100,0,'UTF-8'); ?>
			</p>
	
			</dd>
		</dl>
	<?php endforeach; ?>
</div>
