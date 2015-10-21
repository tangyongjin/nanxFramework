<?php 
 
class MSystempara extends CI_Model{
	function getCurrentCfg(){
		$ret = $this->db->select()->from('nanx_system_cfg')->get()->result_array();
		return $ret;
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
		$item = $this->db->select('config_value')->get_where('nanx_system_cfg', array('config_key' => $item))->result_array()[0]['config_value'];
  	return $item; 
	}
}
?>
