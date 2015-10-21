<?php
class MHooks extends CI_Model
{
  
 
 
 	function getHooksbyActcode($activity_code,$event)
	{
	

    $this->db->order_by('execute_order');
    $query = $this->db->get_where('nanx_activity_hooks', array('hook_type'=>'data', 'hook_when'=>'after', 'activity_code' => $activity_code,'hook_event'=>$event));
   
    $rows_after=$query->result_array();

    $this->db->order_by('execute_order');
    $query = $this->db->get_where('nanx_activity_hooks', array('hook_type'=>'data', 'hook_when'=>'before', 'activity_code' => $activity_code,'hook_event'=>$event));
    $rows_before=$query->result_array();


    $this->db->order_by('execute_order');
    $query = $this->db->get_where('nanx_activity_hooks', array('hook_type'=>'check',  'activity_code' => $activity_code,'hook_event'=>$event));
    $checks=$query->result_array();


		return  array('checks'=>$checks ,'after' =>$rows_after,'before' =>$rows_before  );
	

  }


	
  function addHook(){

  }

  function deleteHook(){

  }


  function updateHook(){

  }
  

 
}
?>