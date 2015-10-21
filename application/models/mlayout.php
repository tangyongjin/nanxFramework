<?php

class MLayout extends CI_Model{
	function getLayoutCfg($act_code,$table){
		$sql="select row,field_list from nanx_activity_biz_layout where  activity_code='$act_code' and 	raw_table='$table' order by row   ";
	  $query=$this->db->query($sql);
	  $ret=$query->result_array();
		return $ret;
	}
}
?>
