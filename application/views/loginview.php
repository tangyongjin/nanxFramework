<div class="m wbg shadow" id="login_main_form"  style="display:none;height:228px;width:550px;margin-top:100px;">
	<h1  id="logintext"><?php 
	  echo $this->lang->line('logintips'); 
	  ?></h1>
		<div id="section-box">
				<div class="m" style="height:158px;">
					<form  method="post" id="form-login">
					    <table>
					    <tr><td id="user_td"><?php echo $this->lang->line('account'); ?></td><td><input name="username" id="mod-login-username"  type="text"></td></tr>
		                <tr><td  id="pwd_td"><?php echo $this->lang->line('password');?></td><td><input name="passwd"   id="mod-login-password"  type="password"></td></tr>
					    </table>
       		            <span id="log_res"></span>
							<div class="button-holder">
								<div class="button1"  type="submit">
									<div class="next" style="height:30px;">
										<a  onclick='login()' ><?php echo $this->lang->line('login'); ?></a>
									</div>
								</div>
							</div>
					 </form>
				</div>
		<?php
	        $sql="select * from nanx_lang where  active='y' ";
	        $rows=$this->db->query($sql)->result_array();
	        $o='<div id="polyglotLanguageSwitcher"><form action="#">';
		    $o.='<select id="polyglot-language-options">';
		    foreach($rows as $r){
		         $selected='';
		         if($r['id']==$lang){$selected=' selected';} 
		         $o.= "<option id=".$r['id']." value=".$r['id']." $selected >".$r['lang_txt']."</option>";
		    }
		    $o.='</select></form></div>';
	        echo $o;
		?> 
		</div>
		<div id="lock">
      				    	<?php
      				    	       $logo_img_def= array(
      				    	             'id' => 'img_logo_150',
                                         'src' => "imgs/".$logo_pic,
                                         'class' => 'img_max_150' 
                                    );
					                   echo img($logo_img_def);
					        ?>
		</div>
</div>
	   
<div id="myModal" class="reveal-modal">
     <h1 style="font-size:16px;">
      <?php  echo $this->lang->line('login_success');?>
      </h1>
     <hr/>
     <br/>
     <p style="font-size:12px;"><?php  echo $this->lang->line('app_landing'); ?> 
  				    	<?php
      				    	       $loaddef= array(
                                 'src' => "imgs/backend/icons/loading-16.gif"
                                );
					                   echo img($loaddef);
					           ?>
      </p>
     <a class="close-reveal-modal">&#215;</a>
</div>