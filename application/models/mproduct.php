<?php 

class MProduct extends CI_Model{

	function getProduct(){
		$sql="select pro.* , pc.category_name , ppd.price as price from product pro left join price_plan_detail ppd on (pro.product_code = ppd.product_code and ppd.price_plan_code = 'STAND') left join product_category pc on (pc.category_code = pro.category_code)";
		$product=$this->db->query($sql)->result_array();
		return $product;
	}
	
	function insert_product($data){
		$this->db->insert('product', $data);
  	$error_number=$this->db->_error_number();
		return $error_number;
	}
	
	function update_product($data){
		$this->db->where('product_code', $data['product_code']);
		$this->db->update('product', $data); 	
  	$error_number=$this->db->_error_number();
	 	return $error_number;
	}
	
	function delete_product($product_code){
		$this->db->delete('product', array('product_code' => $product_code));
		$error_number=$this->db->_error_number();
	 	return $error_number;
	}
	
	function get_product(){
		$sql="select pro.product_code , pro.product_name , ppd.price as price , 0 as qty from product pro left join price_plan_detail ppd on (pro.product_code = ppd.product_code and ppd.price_plan_code = 'STAND')";
		$query = $this->db->query($sql);
    return $query;
	}
	
	function product_for_pda(){
		$product_array = $this->db->select('product_code , product_name')->from('product')->get()->result_array();
		return $product_array;
	}
  
}

?>