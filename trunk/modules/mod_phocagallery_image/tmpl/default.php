<?php // no direct access
defined('_JEXEC') or die('Restricted access');

?>

<div class="fashion" style="margin-top:15px">
      <h2 class="hdTitle" style="font-weight:bold;font-size:18px;font-family: 'microsoft yahei',simsun,Arial;color:#000000" >潮品</h2>
      <div class="fashionList">
        <ul>
        
        <?php
foreach ($output as $value) {
	echo $value;
}
?>
         <!--  <li><a href="#" width="140" height="134" title="" class="pic"><img src="/images/info/idx_img_0.jpg" 

alt="" title=""></a></li>
          <li><a href="#" title="" class="pic"><img src="/images/info/idx_img_1.jpg" alt="" title=""></a></li>
          <li><a href="#" title="" class="pic"><img src="/images/info/idx_img_2.jpg" alt="" title=""></a></li>
          <li><a href="#" title="" class="pic"><img src="/images/info/idx_img_3.jpg" alt="" title=""></a></li>
          <li><a href="#" title="" class="pic"><img src="/images/info/idx_img_4.jpg" alt="" title=""></a></li>
          <li><a href="#" title="" class="pic"><img src="/images/info/idx_img_5.jpg" alt="" title=""></a></li>
           -->
        </ul>
      </div>
      <div class="other" style="display: none"><a href="#" title="更多" class="btn-link">更多&gt;&gt;</a></div>
    </div>




