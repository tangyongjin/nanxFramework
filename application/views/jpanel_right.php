<?php

$CI=& get_instance();
$bs_url=$CI->config->item('base_url');
   
$workevent=$this->lang->line('workevent');

$show_all_sms=$this->lang->line('show_all_sms');
 
$html='
<div id=accordion_holder  class="cpanel-right">
    <div class="pane-sliders">
	  <div style="display:none;"><div>
	 	</div>
	 	</div>
<div class="panel" style="width:614px;">
	<div  class="pane-toggler title" id="cpanel-panel-latest"> 
	<span id=work_event_pointer>'.$workevent.'&nbsp;</span><span id=show_all_sms>'.$show_all_sms.'</span>
	<span id="timestamp" style="font-weight:normal;"></span>
	<img id="loading_gif"  style="display:none;" src=BASE_URL/css/images/loading_small.gif /> 
	</div>
	<div id="work_event"  class="pane-slider content" style="height:648px;">
   </div>
 </div>
</div>
</div>';
$html=str_replace("BASE_URL",$bs_url,$html);
echo $html;
?>