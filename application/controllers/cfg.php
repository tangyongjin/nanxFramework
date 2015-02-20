<?php 
/*------------------------------------------
/ Author   :
/ DateTime :2012-09-24
/ Desc     :Order Controller 执行订单的查询、明细的查询
------------------------------------------*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cfg extends CI_Controller {

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
  
	function getCurrentCfg(){
		$this->load->model('MSystempara');
		$cfg_data = $this->MSystempara->getCurrentCfg();
		echo json_encode($cfg_data);
	}
	
	function addCurrentCfg(){
		$cig = $_POST;
		$this->load->model('MSystempara');
		$error_number = $this->MSystempara->insert_current_cfg($cig);
		if($error_number!=0 ){
			echo("{success:false}");
			exit;
		}
		echo("{success:true}");
	}
	
	function updateCurrentCfg(){
		$cig = $_POST;
		$this->load->model('MSystempara');
		$error_number = $this->MSystempara->update_current_cfg($cig);
		if($error_number!=0 ){
			echo("{success:false}");
			exit;
		}
		echo("{success:true}");
	}
	
	function deleteCurrentCfg(){
		$cig_id = $_POST['id'];
		$this->load->model('MSystempara');
		$error_number = $this->MSystempara->delete_current_cfg($cig_id);
		if($error_number!=0 ){
			echo("{success:false}");
			exit;
		}
		echo("{success:true}");
	}
	
	function getLevelName()
	{
	$sql="select id,level,level_name from nodes_level_cfg";
	$r=$this->db->query($sql)->result_array();
	echo json_encode($r);
	}
	
	
	function getGridNameCfg()
	{
		 
	$sql
	   ="select  ui_grid_column_cfg.id, ui_grid_column_cfg.level,nodes_level_cfg.level_name,field,screen_name from ui_grid_column_cfg left join nodes_level_cfg on 
	  ui_grid_column_cfg.level=nodes_level_cfg.level ";
	
	$r=$this->db->query($sql)->result_array();
	echo json_encode($r);
	
	}
	
	//添加Grid 列名显示配置
	function addGridNameCfg()
  {   
	 	  $post = file_get_contents('php://input') ;
      $p=(array)json_decode($post);
      
      $row=array
      (
      'level'=> $p['level'],
      'field'=> $p['field'],
      'screen_name'=> $p['screen_name'] 
       );
      
      $this->db->insert('ui_grid_column_cfg', $row); 
      $result=array();
      $result['code']=0;
      $result['msg']='添加成功';
      echo json_encode($result);
	}
	
 
		function updateGridNameCfg()
  {   
	 	  $post = file_get_contents('php://input') ;
      $p=(array)json_decode($post);
      
      $row=array
      (
      'level'=> $p['level'],
      'field'=> $p['field'],
      'screen_name'=> $p['screen_name'] 
       );
      $this->db->where('id', $p['id']);
      $this->db->update('ui_grid_column_cfg', $row); 
      $result=array();
      $result['code']=0;
      $result['msg']='修改成功';
      echo json_encode($result);
	}
	 	function deleteGridNameCfg()
  {   
	 	  $post = file_get_contents('php://input') ;
      $p=(array)json_decode($post);
      $id=$p['id'];
      $this->db->delete('ui_grid_column_cfg', array('id' => $id)); 
      $result=array();
      $result['code']=0;
      $result['msg']='删除成功';
      echo json_encode($result);
	}
}
?>