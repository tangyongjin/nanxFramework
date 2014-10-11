<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Activity extends CI_Controller

{
 
  
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
		$actcfg = $this->getActivityCfg($para);
		echo json_encode($actcfg, JSON_UNESCAPED_UNICODE);
	}
	
	
	 
	
   function getActivityCfg($para_array)
  {
    $this->load->model('MActivity');
    $cfg=$this->MActivity->getActivityCfg($para_array);
    return $cfg;
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
	 
	 
	
	
	
	function  callerIncaller($url,$para)
	{ 
	  
	  $c_and_m = explode("/", $url);
    $c=$c_and_m[0];
    $m=$c_and_m[1];
    $arg=json_encode($para);
    
    $control_dir=dirname(__FILE__);
    include_once(APPPATH.'controllers/'.$c.'.php');
    $CI = new $c();
	  $result=  call_user_func (array( $CI, $m), $para);
    return $result;
  }
  
  function  sqlIncaller($sql,$para)
	{  
		 $ret=$this->db->query($sql)->result_array();
     return $ret;
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
      	 
      	 
      	   
         $act_cfg_result=$this->getActivityCfg($para_array);
         $col_cfg=$act_cfg_result['colsCfg'];
         $c_columns=array_retrieve($col_cfg,array(array('segment'=>'display_cfg','index'=>'field_c')));
         $c_columns=array_retrieve($c_columns,'field_c');
         $e_columns=array_retrieve($col_cfg,'field_e');
         
         $c_e_cfg = array_combine($e_columns, $c_columns);
         $c_e_cfg=array($c_e_cfg);
   


         $this->load->model('MCurd');
         $result=$this->MCurd->getActivityData($para_array);
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
   
  
   
 
  function strMarcoReplace($str,$kv)
  {
  	if(is_array($kv)){}
  	else{
  	$k_v=(array)($kv);	
  	}
  
    while(list($key,$val)= each($k_v))
    {  	
    	$fixed= str_replace($key, "'".$val."'", $str);
    }
  	return $fixed;
  }
  
	
}

?>