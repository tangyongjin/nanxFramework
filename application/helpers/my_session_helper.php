<?php
	function judge_session_exist($view)
	{
		$_this =& get_instance();
		$session_data = $_this->session->all_userdata();
		if (isset($session_data) && isset($session_data['user_id']))
		{
			$_this->load->view('abc',$view);
		}
		else
		{
			$_this->load->view('adminlogin');
		}
	}
?>