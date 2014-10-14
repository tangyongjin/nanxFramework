<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Activity extends CI_Controller

{
 
  
  function service1()
  {
    $x=array('msg' =>'执行结果' ,'success'=>true );
    //echo json_encode($x);
  }

	function listall()
	{
		$sql = "select * from activity";
		$rows = $this->db->query($sql)->result_array();
		echo json_encode($rows);
	}

	 
	function getActCfg()
	{ 
		$post = file_get_contents('php://input');
		$para = (array)json_decode($post);
    $this->load->model('MActivity');
    $actcfg=$this->MActivity->getActivityCfg($para);
		echo json_encode($actcfg, JSON_UNESCAPED_UNICODE);
	}
	
	
	 
	

	function getActRawData()
	{
   	$post = file_get_contents('php://input');
    $para = (array)json_decode($post);
		$this->db->where($para);
		$query = $this->db->get('nanx_activity');
		$rawData = $query->first_row('array');
	  echo json_encode($rawData, JSON_UNESCAPED_UNICODE);
	}
	 
    
  function getIndexOptions()
  {
	$dt=array('(NULL)','UNIQUE','FULLTEXT');
  $combo=array();
  for($i=0;$i<count($dt);$i++)
   {
   	$combo[]=array('code'=> $dt[$i],'value'=> $dt[$i]);
   }
  return $combo;            
  }


   function grid2excel()
    {
         $post = file_get_contents('php://input');
      	 $para_array = (array)json_decode($post);


      	 if(array_key_exists('rawdata',$para_array))
      	 {
          $para_array=(array)$para_array['rawdata'];
      	 }
      	  
      	 if(!array_key_exists('filter_field',$para_array))
      	 {
      	   $para_array['filter_field']='';
      	 }
      	 
      	 if(!array_key_exists('filter_value',$para_array))
      	 {
      	   $para_array['filter_value']='';
      	 }
      	
      	 if(!array_key_exists('query_cfg',$para_array))
      	 {
      	   $para_array['query_cfg']=null;
      	 }

         $this->load->model('MActivity');
         $act_cfg_result=$this->MActivity->getActivityCfg($para_array);
         $col_cfg=$act_cfg_result['colsCfg'];

         $c_columns=array_retrieve($col_cfg,array(array('segment'=>'display_cfg','index'=>'field_c')));
         $c_columns=array_retrieve($c_columns,'field_c');
         $e_columns=array_retrieve($col_cfg,'field_e');
         
         $c_e_cfg = array_combine($e_columns, $c_columns);
         $c_e_cfg=array($c_e_cfg);
   


         $this->load->model('MCurd');
         $CI=&get_instance();
         $CI->load->model('MCurd');
         
         $result=$CI->MCurd->getActivityData($para_array);
         
         $rows=$result['rows'];    
   
         $colscfg_and_rows=array_merge($c_e_cfg,$rows);
         $fname=$para_array['excel_name'];
         
         $this->load->model('MExcel');
         $ci = &get_instance();
         $ci->load->model('MExcel');
         
         $write_result=$ci->MExcel->exportExcel($colscfg_and_rows,$fname);
         
         if($write_result['success'])
           {
           $this->load->helper('url');
           echo json_encode(array('success' => true ,'showdownload'=>true,'fname'=>base_url().'/tmp/'.$fname.'.xls'));
           }
           else
           {
           echo json_encode(array('success' => false ,'msg'=> $write_result['msg'],'errmsg'=> $write_result['msg']));
           }
  }
   
  
   
  
	
}

?>