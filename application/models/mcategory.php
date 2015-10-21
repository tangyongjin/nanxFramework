<?php 

class MCategory extends CI_Model{

	function getCategory(){
		$sql = $this->db->select()->from('product_category')->get()->result_array();
		return $sql;
	}
	
	function insert_category($data){
		$this->db->insert('product_category', $data);
  	$error_number=$this->db->_error_number();
		return $error_number;
	}
	
	function update_category($data){
		$this->db->where('category_code', $data['category_code']);
		$this->db->update('product_category', $data);
  	$error_number=$this->db->_error_number();
	 	return $error_number;
	}
	
	function delete_category($categoryt_code){
		$this->db->delete('product_category', array('category_code' => $category_code));
		$error_number=$this->db->_error_number();
	 	return $error_number;
	}
  
}

?>
