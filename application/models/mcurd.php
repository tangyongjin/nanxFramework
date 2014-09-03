<?php 

class MCurd extends CI_Model{

	function getCurrentCfg(){
		$sql = $this->db->select()->from('nanx_system_cfg')->get()->result_array();
		return $sql;
	}
	
	function insert_current_cfg($data){
		$this->db->insert('nanx_system_cfg', $data);
  	$error_number=$this->db->_error_number();
		return $error_number;
	}
	
	function update_current_cfg($data){
		$this->db->where('id', $data['id']);
		$this->db->update('nanx_system_cfg', $data); 	
  	$error_number=$this->db->_error_number();
	 	return $error_number;
	}
	
	function delete_current_cfg($cfg_id){
		$this->db->delete('nanx_system_cfg', array('id' => $cfg_id));
		$error_number=$this->db->_error_number();
	 	return $error_number;
	}
	
	function getCfgItem($item){
		$item = $this->db->select('value')->get_where('nanx_system_cfg', array('key' => $item))->result_array()[0]['value'];
  	return $item; 
	}
}
?>

