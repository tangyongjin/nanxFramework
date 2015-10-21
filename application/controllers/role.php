<?php 

class Role extends CI_Controller {
	
	function getui() 
	{
    $js = $this->uri->segment(3);   //js文件名称
    $div = $this->uri->segment(4);  //div id
    $html = get_snippets($js,$div);
		$view['include']['snippets'] = $html;
    $this->load->view('abc',$view);
  }
  
 	function  listNodes()
 	{
 	 	$sql=" select node_id as ID, node_name as name,11 as size,IFNULL(parent_id,'')    as parentID from node  ";
	 	$nodes=$this->db->query($sql)->result_array();
	 	echo json_encode($nodes);
 	}
 
  function  add()
 	{
    $post = file_get_contents('php://input') ;
    $x=(array)json_decode($post);
    $this->db->insert('user_role', $x); 
    $code=mysql_errno();
    if($code==0)
    {
    $code=0;
    $msg='成功添加';
    $ret=array('code'=> $code, 'msg'=> $msg);
    echo json_encode($ret);
    }else
    {
    $code=-1;
    $msg='添加失败';
    $ret=array('code'=> $code, 'msg'=> $msg);
    echo json_encode($ret);
    }
 	}
 
 
  function  delete()
 	{
    $post = file_get_contents('php://input') ;
    $x=(array)json_decode($post);
    $role_code=$x['role_code']; 
    $where = array( 'role_code' => $role_code);  
    $this->db->delete('user_role', $where);  
 	}
 

  function  update()
	{
		/*开启事务*/
		$this->db->trans_begin();
		
		$role_code=$_POST['role_code'];
		$role_name=$_POST['role_name'];
		$activity_code_array = $_POST['activity_code_array'];
		
		$activity_code_array = json_decode($activity_code_array, true);
		
		$user_role = array('role_code'=>$role_code,'role_name'=>$role_name);
		
		$error_number = 0;
		
		/*先修改user_role*/
		$this->db->where('role_code', $role_code);
		$this->db->update('user_role', $user_role);	
  	$error_number += $this->db->_error_number();
  	
  	/*再删除role_code的所有activity*/
		$this->db->where('role_code',$role_code);
		$this->db->delete('user_role_privilege');
		$error_number += $this->db->_error_number();
		
		foreach($activity_code_array as $one_activity_code)
		{
			$this->db->insert('user_role_privilege',$one_activity_code);
			$error_number += $this->db->_error_number();
		}
		
		if($error_number!=0)
		{
			$this->db->trans_rollback();
			echo("{success:false}");
			exit;
		}else
		{
			/*提交事务*/
			$this->db->trans_commit();
			echo("{success:true}");
		}
	}


   function  listall()
   {
   	$sql="select * from user_role";
   	$query=$this->db->query($sql)->result_array();
  
   	//$fields = $query->list_fields();
		//翻转数组
		//$fields = array_flip($fields);
		//获得行
		//$rows = $query->result_array();
		
		//取得字段名
		//$this->load->model('MUI');
		//$fieldsNames = array_keys($fields);
		//$current_level = $this->session->userdata('level');
		//$fields = $this->MUI->setFieldsName($fields,$current_level);	
		//$data = array('data'=>$rows,'columModle'=>$fields,'fieldsNames'=>$fieldsNames);	
		
		echo json_encode($query,JSON_UNESCAPED_UNICODE);
   }
 	 
   function  listallactivity()
   {
   	$sql="select activity_code, screen_name from activity";
   	$query=$this->db->query($sql)->result_array();
  
   	//$fields = $query->list_fields();
		//翻转数组
		//$fields = array_flip($fields);
		//获得行
		//$rows = $query->result_array();
		
		//取得字段名
		//$this->load->model('MUI');
		//$fieldsNames = array_keys($fields);
		//$current_level = $this->session->userdata('level');
		//$fields = $this->MUI->setFieldsName($fields,$current_level);	
		//$data = array('data'=>$rows,'columModle'=>$fields,'fieldsNames'=>$fieldsNames);	
		
		echo json_encode($query,JSON_UNESCAPED_UNICODE);
   }
 	  function  listallactivitybyrole()
   {
    $post = file_get_contents('php://input') ;
    $x=(array)json_decode($post);
    $role_code=$x['role_code']; 
   	$sql="select role_code,screen_name ,user_role_privilege.activity_code from  	user_role_privilege 
    left join activity on   activity.activity_code=user_role_privilege.activity_code where role_code='$role_code'";
    
   	$query=$this->db->query($sql)->result_array();
  
   	//$fields = $query->list_fields();
		//翻转数组
		//$fields = array_flip($fields);
		//获得行
		//$rows = $query->result_array();
		
		//取得字段名
		//$this->load->model('MUI');
		//$fieldsNames = array_keys($fields);
		//$current_level = $this->session->userdata('level');
		//$fields = $this->MUI->setFieldsName($fields,$current_level);	
		//$data = array('data'=>$rows,'columModle'=>$fields,'fieldsNames'=>$fieldsNames);	
		echo json_encode($query,JSON_UNESCAPED_UNICODE);
   }
  
 	
}
?>
