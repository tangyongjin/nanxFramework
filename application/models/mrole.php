<?php 
class MRole extends CI_Model{
	function select_role_list(){
		$query = $this->db->select('id,text,parent_id')->from('t_role')->get()->result(); 
		return $query;
	}
}
?>