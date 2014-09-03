<?php
 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Curd extends CI_Controller
{
	 
	function listData()
	{
	   
	 	$post = file_get_contents('php://input');
		$p = (array)json_decode($post);
		$this->load->model('MDatafactory'); ///activity_type
		
	 
		if(  array_key_exists('code',$p))
		{
		$code=$p['code'];
	  $this->db->where('activity_code', $code);
		$query = $this->db->get('nanx_activity');
		$cfg = $query->first_row('array');
		$activity_type=$cfg['activity_type'];
	  }
	  else
	  {$activity_type='table';
	  }
		
	 if(( $activity_type=='service')&&( $code  =='NANX_TBL_DATA'))
	 {  
	     
	      if(isset($_GET['start']))
		   {
		   	$start = $_GET['start'];
		  	$limit = $_GET['limit'];
		   }
		   
	      $table=$p['table'];
		    if(array_key_exists('pid_order',$p))
		    {
		      $pidorder=$p['pid_order'];
		    }
		    else
		    {
		      $pidorder='asc';
		    }
		    
		    if(array_key_exists('filter_field',$p))
		  {
				$filter_field=$p['filter_field'];
				$filter_value=$p['filter_value'];
		    
		   	$this->db->where($filter_field,$filter_value);
			  $rows=$this->db->get($table)->result_array();
		    $total=count($rows);
		    $this->db->order_by('pid',$pidorder);
		    $this->db->where($filter_field,$filter_value);
		    $this->db->limit($limit,$start);
			  $rows=$this->db->get($table)->result_array();
		  }
		  else
		  {
		      $sql="select * from $table order by pid $pidorder limit $start,$limit ";
		      $rows=$this->db->query($sql)->result_array();
		      $total=$this->db->count_all($table);
		  }
	   
	    $result['rows'] = $rows;
		  $result['total'] = $total;
		  $result['table'] = $table;
		  $result['sql'] =null;
	 }
	 else
	 { 
		if(( $activity_type=='table')||( $p['code']  =='NANX_TBL_DATA'))
		{
 		 $filter_field=null;
		 $filter_value=null;
		 
		 if (array_key_exists('filter_field', $p)) {
				$filter_field=$p['filter_field'];
		  	$filter_value=$p['filter_value'];
		 }
		   
		 
		 if (array_key_exists('query_cfg',$p)) {
				$query_cfg=$p['query_cfg'];
		 }else
		 {
		 $query_cfg=null;
		 }
		 
		 $table=$p['table'];
		 $pid_order=(isset($p['pid_order']))? $p['pid_order'] :'asc';
	 	 $result=	$this->MDatafactory->getDatabyBasetable($table,$filter_field,$filter_value,$pid_order,$query_cfg);
	  }
   }
    
    
	  
	  if($activity_type=='sql')
		{
	  $activty_code=$p['code'];
		$this->db->where('activity_code', $activty_code);
		$query = $this->db->get('nanx_activity');
		$cfg = $query->first_row('array');
		$sql=$cfg['sql'];
	  if(isset($p['para_json']))
	  {
	  $sql_fixed= strMarcoReplace($sql,$p['para_json']);
	  }
	  else
	  {  $sql_fixed=$sql;
	  }
	   
		 $result=	$this->MDatafactory->getDatabySql($sql_fixed);
	   if($activty_code=='NANX_TB_LAYOUT'){
	   $mixed=getLayoutFields($result['rows']);
	   $rows=$mixed['data'];
	   $result['rows'] = $rows;
		 $result['total'] = count($rows);
		 $result['sql'] = $sql_fixed;
	   }
	  }
	  
	  $json = json_encode($result,JSON_UNESCAPED_UNICODE);
		echo  str_replace("null", "''", $json);
	}
	
	function updateData()
	{ 
		$post = file_get_contents('php://input');
		$p = (array)json_decode($post);
		$actcode=$p['actcode'];
		$this->write_notify($actcode,'update');
 		$base_table = $p['table'];
	  $rawData=(array)$p['rawdata'];
		$pid = $rawData['pid'];
	
	  
		$dt_fileds = $this->getDatetimeFiled($base_table);
		$date_check = $this->checkDateFmt($p, $dt_fileds);
		unset($rawData['pid']);
		
		
		$this->db->where('pid', $pid);
		
		$row_to_update=$this->db->get($base_table)->result_array();
		if(count($row_to_update)==1)
		{
		 $row_to_update=$row_to_update[0];
		}
		else
		{
		 $row_to_update='';  
		}

		$this->db->where('pid', $pid);
		$this->db->update($base_table, $rawData);
		$errno = $this->db->_error_number();
		if ($errno == 0)
		{
			$sql=$this->db->last_query();
		  $resp=array(
      'success'=>true,
      'msg'=>$this->lang->line('success_update_table_data')
      );
		
		}
		else
		{
		  $resp=array(
      'success'=>false,
      'msg'=>$this->lang->line('error_code').':'.$errno
      );
		}
		
		 $this->write_session_log('update',$p,$row_to_update);
	   echo json_encode($resp);
	}

  function batchData()
	{
		$post = file_get_contents('php://input');
		$p = (array)json_decode($post);
		$actcode=$p['actcode'];
 		$batch_pids=$p['batch_pids'];
 		$base_table = $p['table'];
	  $rawData=(array)$p['rawdata'];
	  $arr=(array) $p['rawdata'];
	  	
	  $errno=0;
	  $single_err=0;
	  foreach($batch_pids as $pid)
	  {
	    
	    $this->db->where('pid', $pid);
 		  $this->db->update($base_table, $arr);
 		  $single_err=$this->db->_error_number();
 		  $errno+= $single_err;
	  }
		 
		if ($errno == 0)
		{
			$sql=$this->db->last_query();
		  $resp=array(
      'success'=>true,
      'msg'=>$this->lang->line('success_batch_update_table_data') 
      );
		
		}
		else
		{
		  $resp=array(
      'success'=>false,
      'msg'=>$this->lang->line('error_code').':'.$single_err
     );
		}
		 $this->write_session_log('batchUpdateData',$p,'');
	  echo json_encode($resp);
	}
	
	function addData()
	{
		$post = file_get_contents('php://input');
		$p = (array)json_decode($post);
		$actcode=$p['actcode'];
	  $this->write_notify($actcode,'add');
		$base_table = $p['table'];
		$rawData=(array)$p['rawdata'];
		$this->db->insert($base_table, $rawData);
		$errno = $this->db->_error_number();
		if ($errno == 0)
		{
		  $resp=array(
      'success'=>true,
      'msg'=> $this->lang->line('success_add_table_data')
      );
		}
		else
		{
			 $resp=array(
      'success'=>false,
      'msg'=>$this->lang->line('error_code').':'.$errno
      );
		}
		 $this->write_session_log('add',$p,'');
		 echo json_encode($resp);
	}
	
		function deleteData()
	{
	   
		$post = file_get_contents('php://input');
		$p = (array)json_decode($post);
		$actcode=$p['actcode'];
		$this->write_notify($actcode,'delete');
		$base_table = $p['table'];
		$pids = $p['pid_to_del']; // pid like '1,23,4,9'
    $total_error=0;
		$rows_deleted=array();
		
		foreach($pids as $pid)
		{
			$where = array(
				'pid' => $pid
			);
		
		$this->db->where($where);
		
		$row_to_del=$this->db->get($base_table)->result_array();
		if(count($row_to_del)==1)
		{
		 array_push($rows_deleted,$row_to_del[0]);
		}
			
		$this->db->delete($base_table, $where);
		$errno = $this->db->_error_number();
		$total_error = $total_error + $errno;
		}

		if ($total_error == 0)
		{
		  $resp=array(
      'success'=>true,
      'msg'=> $this->lang->line('success_delete_table_data')
      );
		}
		else
		{
			  $resp=array(
      'success'=>false,
      'msg'=>$this->lang->line('error_code').':'.$errno
      );
		}
		 $this->write_session_log('delete',$p,$rows_deleted);
		 echo json_encode($resp);
	}

	function write_notify($activity_code,$action)
	{ 
	  $sess=$this->session->all_userdata();
	  $operator=$sess['staff_name'];
	  $sql="select  '$operator' as operator, grid_title,user ,action from nanx_activity   ,nanx_activity_nofity,nanx_user_role_assign
          where nanx_activity.activity_code=nanx_activity_nofity.activity_code  and
          nanx_activity_nofity.activity_code ='$activity_code'  and action='$action' and 
          nanx_activity_nofity.receiver_role_list=nanx_user_role_assign.role_code";
    
	  if($action=='add'){$action=$this->lang->line('operation_add');}
	  if($action=='update'){$action=$this->lang->line('operation_update');}
	  if($action=='delete'){$action=$this->lang->line('operation_delete');}
	  date_default_timezone_set('PRC');
	  $datesend=date('Y-m-d H:i:s');
	  $msgs=$this->db->query($sql)->result_array();
	  if($msgs){
       for($i=0;$i<count($msgs);$i++)
       {
       $operator=$msgs[$i]['operator'];
       $act=$msgs[$i]['grid_title'];
       $txt="$operator:".$this->lang->line('on_activity').':'.$act.$this->lang->line('executed').$action.$this->lang->line('operation'); 
       $msg_send=array(
       'sender'=>$this->lang->line('system_sender'),
       'receiver' => $msgs[$i]['user'],
       'msg'=> $txt ,
       'title'=> $txt ,
       'sendtime'=> $datesend);
       $this->db->insert( 'nanx_sms', $msg_send);
       }	  
	  }
	} 

 
  function write_session_log($type,$p,$old_data)
  {
    
    if(! array_key_exists('rawdata',$p )) {$p['rawdata']=$object = new stdClass();}

    $sess=$this->session->all_userdata();
	  $operator=$sess['staff_name'];
    $user=$sess['user'];
    
   
    	  
	  $log_data=array('user'=> $operator.'['.$user.']',
	                   'action_cmd'=> $type ,
	                   'act_code'=> $p['actcode'],
	                   'table'=> $p['table'],
	                   'rawdata'=>array2string((array)$p['rawdata'])
	                  );
	  
	  switch ($type)
	  {
	    case 'add':
	    $log_data['pids']='';
	    
      break;	    
	    case 'delete':
	    $log_data['pids']=array2string($p['pid_to_del']);
	    $log_data['old_data']=array2string($old_data);
	    break; 

	    case 'update':
	    $log_data['pids']='';
	  //  $log_data['rawdata']= array2string( (array)($p['rawdata']));
	    
	    $log_data['old_data']=array2string($old_data);
	    
      break;
	    case 'batchUpdate':
	    $log_data['pids']=array2string($p['batch_pids']);
	    break;
	  }
		$this->db->insert('nanx_session_log', $log_data);
	
	  
  } 

	function getDatetimeFiled($table)
	{
		$sql2 = "SELECT  C.`COLUMN_NAME`  FROM information_schema.`COLUMNS` C where  table_schema='oss'  and  table_name='$table' and DATA_TYPE='datetime'";
		$dt_fields = $this->db->query($sql2)->result_array();
	}

	function checkDateFmt($array, $cols)
	{
		$check = true;
		foreach($array as $col)
		{
		}
	}
}

?>