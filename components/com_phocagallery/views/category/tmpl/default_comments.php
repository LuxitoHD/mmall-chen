<?php defined('_JEXEC') or die('Restricted access'); 

?><div id="phocagallery-comments"><?php
	echo '<div style="font-size:1px;height:1px;margin:0px;padding:0px;">&nbsp;</div>';//because of IE bug
	
	if (!empty($this->commentitem)){
		$userImage	= JHtml::_( 'image', 'components/com_phocagallery/assets/images/icon-user.'.$this->tmpl['formaticon'],'');
	
		$smileys = PhocaGalleryComment::getSmileys();
		
		foreach ($this->commentitem as $itemValue) {
			$date		= JHtml::_('date',  $itemValue->date, JText::_('DATE_FORMAT_LC2') );
			$comment	= $itemValue->comment;
			$comment 	= PhocaGalleryComment::bbCodeReplace($comment);
			foreach ($smileys as $smileyKey => $smileyValue) {
				$comment = str_replace($smileyKey, JHtml::_( 'image', 'components/com_phocagallery/assets/images/'.$smileyValue .'.'.$this->tmpl['formaticon']), $comment);
			}
			
			echo '<fieldset>'
			    .'<legend>'.$userImage.'&nbsp;'.$itemValue->name.'</legend>'
				.'<p><strong>'.PhocaGalleryText::wordDelete($itemValue->title, 50, '...').'</strong></p>'
				.'<p style="overflow:auto;width:'.$this->tmpl['commentwidth'].'px;">'.$comment.'</p>'
				.'<p style="text-align:right"><small>'.$date.'</small></p>'
				.'</fieldset>';
		}
	}
	
	echo '<fieldset>'
		.'<legend>'.JText::_('COM_PHOCAGALLERY_ADD_COMMENT').'</legend>';

	if ($this->tmpl['alreadycommented']) {
	
		echo '<p>'.JText::_('COM_PHOCAGALLERY_COMMENT_ALREADY_SUBMITTED').'</p>';
			
	} else if ($this->tmpl['notregistered']) {
	
		echo '<p>'.JText::_('COM_PHOCAGALLERY_COMMENT_ONLY_REGISTERED_LOGGED_SUBMIT_COMMENT').'</p>';
			
	} else {
		
		?>		
		<form action="<?php echo $this->tmpl['action'];?>" name="phocagallerycommentsform" id="phocagallery-comments-form" method="post" >
		
		
		<table>
			<tr>
				<td><?php echo JText::_('COM_PHOCAGALLERY_NAME');?>:</td>
				<td><?php echo $this->tmpl['name']; ?></td>
			</tr>
			
			<tr>
				<td><?php echo JText::_('COM_PHOCAGALLERY_TITLE');?>:</td>
				<td><input type="text" name="phocagallerycommentstitle" id="phocagallery-comments-title" value="" maxlength="255" class="comment-input" /></td>
			</tr>
			
			<tr>
				<td>&nbsp;</td>
				<td>
				<a href="#" onclick="pasteTag('b', true); return false;"><?php echo JHtml::_('image', 'components/com_phocagallery/assets/images/icon-b.'.$this->tmpl['formaticon'], JText::_('COM_PHOCAGALLERY_BOLD'));?></a>&nbsp;
				<a href="#" onclick="pasteTag('i', true); return false;"><?php echo JHtml::_('image', 'components/com_phocagallery/assets/images/icon-i.'.$this->tmpl['formaticon'], JText::_('COM_PHOCAGALLERY_ITALIC'));?></a>&nbsp;
				<a href="#" onclick="pasteTag('u', true); return false;"><?php echo JHtml::_('image', 'components/com_phocagallery/assets/images/icon-u.'.$this->tmpl['formaticon'], JText::_('COM_PHOCAGALLERY_UNDERLINE'));?></a>&nbsp;&nbsp;
				
				<a href="#" onclick="pasteSmiley(':)'); return false;"><?php echo JHtml::_('image', 'components/com_phocagallery/assets/images/icon-s-smile.'.$this->tmpl['formaticon'], JText::_('COM_PHOCAGALLERY_SMILE'));?></a>&nbsp;
				<a href="#" onclick="pasteSmiley(':lol:'); return false;"><?php echo JHtml::_('image', 'components/com_phocagallery/assets/images/icon-s-lol.'.$this->tmpl['formaticon'], JText::_('COM_PHOCAGALLERY_LOL'));?></a>&nbsp;
				<a href="#" onclick="pasteSmiley(':('); return false;"><?php echo JHtml::_('image', 'components/com_phocagallery/assets/images/icon-s-sad.'.$this->tmpl['formaticon'], JText::_('COM_PHOCAGALLERY_SAD'));?></a>&nbsp;
				<a href="#" onclick="pasteSmiley(':?'); return false;"><?php echo JHtml::_('image', 'components/com_phocagallery/assets/images/icon-s-confused.'.$this->tmpl['formaticon'], JText::_('COM_PHOCAGALLERY_CONFUSED'));?></a>&nbsp;
				<a href="#" onclick="pasteSmiley(':wink:'); return false;"><?php echo JHtml::_('image', 'components/com_phocagallery/assets/images/icon-s-wink.'.$this->tmpl['formaticon'], JText::_('COM_PHOCAGALLERY_WINK'));?></a>&nbsp;
							
				
				</td>
			</tr>
			
			<tr>
				<td>&nbsp;</td>
				<td>
					<textarea name="phocagallerycommentseditor" id="phocagallery-comments-editor" cols="30" rows="10"  class= "comment-input" onkeyup="countChars();" ></textarea>
				</td>
			</tr>
			
			<tr>
				<td>&nbsp;</td>
				<td><?php echo JText::_('COM_PHOCAGALLERY_CHARACTERS_WRITTEN');?> <input name="phocagallerycommentscountin" value="0" readonly="readonly" class="comment-input2" /> <?php echo JText::_('COM_PHOCAGALLERY_AND_LEFT_FOR_COMMENT');?> <input name="phocagallerycommentscountleft" value="<?php echo $this->tmpl['maxcommentchar'];?>" readonly="readonly" class="comment-input2" />
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td align="right">
					<input type="submit" id="phocagallerycommentssubmit" onclick="return(checkCommentsForm());" value="<?php echo JText::_('COM_PHOCAGALLERY_SUBMIT_COMMENT'); ?>"/>
				</td>
			</tr>
			
		</table>
		
		<input type="hidden" name="task" value="comment"/>
		<input type="hidden" name="view" value="category"/>
		<input type="hidden" name="controller" value="category"/>
		<input type="hidden" name="tab" value="<?php echo $this->tmpl['currenttab']['comment'];?>" />
		<input type="hidden" name="catid" value="<?php echo $this->category->slug ?>"/>
		<input type="hidden" name="Itemid" value="<?php echo JRequest::getVar('Itemid', 0, '', 'int') ?>"/>
		<?php echo JHtml::_( 'form.token' ); ?>
		</form>
		
		<?php
	}
	?>
	
	</fieldset>
</div>
