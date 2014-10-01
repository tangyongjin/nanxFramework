 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
      <?php
         echo '<title>' . $page_title . '</title>';
         echo $css_and_js;
      ?>
	</head>
    <body id="minwidth-body">
		<?php
		echo '<div id="border-top" class="h_blue">';
		$bs_url = $this->config->item('base_url');
		echo "<div id=oss_menu1></div>";
		echo "<div style='float:left;margin-top:9px;margin-left:5px;'><img src=$bs_url/css/images/nanx_logo.png /></div>";
		echo "<div id=menu_wrapper>";
		echo $banner_title;
        if (!isset($loginview))
			{
			echo $current_user_info;
			echo $sms_info;
			echo $mail_info;
			echo $logout_info;
			echo $backend_info;
			}

		echo '</div>';
		echo '</div>';
		?>	 
 
	<div id="content-box">
		<div id="element-box">
				<div class="adminform" style="height:242px;">
					<?php
						$user_item = 'user';
						if (isset($loginview))
							{
							$l = $this->load->view($loginview);
							}
						  else
							{
							if (isset($left))
								{
								echo $left;
								}

							if (isset($right))
								{
								$this->load->view($right);
								}

							if (isset($activity_div))
								{
								echo $activity_div;
								}
							}

						date_default_timezone_set('PRC');
						$date = date('Y-m-d');
						$week = $this->lang->line('week') [date('w') ];
						?>
		        </div>
		</div>
	</div>
	<div id=footer>
	  <?php
          echo "<div id=foot_date>$date $week</div>";
      ?>
	</div>
</body>
</html>
