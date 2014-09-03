<?php
	function judge_session_role($role)
	{
		$_this =& get_instance();
		$session_data = $_this->session->all_userdata();
		if (isset($session_data) && isset($session_data['user_id']))
		{
			$user_id = $session_data['user_id'];
			//$user_name = 'admin';
			$row = $_this->db->select('t_user_role.id')->from('t_user_role')->join('t_user','t_user.id = t_user_role.user_id')->join('t_role','t_role.id = t_user_role.role_id')->where('t_user.id',$user_id)->where('t_role.role_name',$role)->get()->result();

			
			if(count($row)!=0)
			{
				echo('{"success":true}');
			}else{
				echo('{"success":true}');	
			}
		}
	}
?>