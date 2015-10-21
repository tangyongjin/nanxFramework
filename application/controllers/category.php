<?php 
/*------------------------------------------
/ Author   :
/ DateTime :2012-09-24
/ Desc     :Order Controller 执行订单的查询、明细的查询
------------------------------------------*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller {

  /*
  根据js文件名和div的ID生成一个div,让js来渲染.
  */
  function getui() {
      $js = $this->uri->segment(3);   //js文件名称
      $div = $this->uri->segment(4);  //div id
      $html = get_snippets($js,$div);
			$view['include']['snippets'] = $html;
      $this->load->view('abc',$view);
  }
  
  function getCategory(){
		$this->load->model('MCategory');
		$category_data = $this->MCategory->getCategory();
		echo json_encode($category_data);
	}
	
	function addCategory(){
		$category = $_POST;
		$this->load->model('MCategory');
		$error_number = $this->MCategory->insert_category($category);
		if($error_number!=0 ){
			echo("{success:false}");
			exit;
		}
		echo("{success:true}");
	}
	
	function updateCategory(){
		$category = $_POST;
		$this->load->model('MCategory');
		$error_number = $this->MCategory->update_category($category);
		if($error_number!=0 ){
			echo("{success:false}");
			exit;
		}
		echo("{success:true}");
	}
	
	function deleteCategory(){
		$category_code = $_POST['category_code'];
		$this->load->model('MCategory');
		$error_number = $this->MCategory->delete_category($category_code);
		if($error_number!=0 ){
			echo("{success:false}");
			exit;
		}
		echo("{success:true}");
	}
  
    
	 
}
?>
