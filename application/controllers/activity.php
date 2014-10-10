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
		$layout_cfg=array(); 
	  $activty_code=$para_array['code'];
		$this->db->where('activity_code', $activty_code);
		$query = $this->db->get('nanx_activity');
		$cfg = $query->first_row('array');
		$activity_type=$cfg['activity_type'];
		$url_for_get_cfg= $cfg['url_for_get_cfg'];
		$service_url=$cfg['service_url'];
		$sql= $cfg['sql'];
		
    if($activity_type=='html')
    {
    	 $col_cfg='';
    }
    
    if($activity_type=='table')
    {
     $para_array['transfer']=true;
     $base_table = $cfg['base_table'];
     $fields_e=  $this->skip_field($activty_code,$this->db->list_fields($base_table));
     $this->load->model('MFieldcfg');
     $col_cfg=$this->MFieldcfg->getColsCfg($base_table,$fields_e,$para_array['transfer']);
     $this->load->model('MLayout');
     $layout_cfg=$this->MLayout->getLayoutCfg($activty_code,$base_table);
    }

    
		 if($activity_type=='sql')
    {
     $this->load->model('MFieldcfg');
     
     if(isset($para_array['para_json']))
      {
      $sql_para=$para_array['para_json'];
      $sql_fixed= strMarcoReplace($sql,$sql_para);
      }
      else
      {
      	  $sql_fixed=$sql;
      }
      
     $ret=$this->sqlIncaller($sql_fixed,$para_array); 
      if($ret)
      {
        $fields_e = array_keys($ret[0]);
        if($activty_code=='NANX_TB_LAYOUT'){ $arr=getLayoutFields($ret); $fields_e=$arr['cols']; }
        $col_cfg=$this->MFieldcfg->getColsCfg('NULL',$fields_e,true);
      }
    else
     {
      $fields_e=array(0=>'pid');
      if($activty_code=='NANX_TB_LAYOUT'){ $fields_e=array(0=>'col_0');}
      $col_cfg=$this->MFieldcfg->getColsCfg('NULL',$fields_e,true);
     }
    }
    
    
    if($activity_type=='service')
    {
      $this->load->model('MFieldcfg');
      $ret=$this->callerIncaller($service_url,$para_array); 
      if($ret)
      {
        $ret2arr=$ret;
       // debug($ret2arr);
        
        $fields_e = array_keys($ret2arr[0]);
        if(in_array($activty_code,array('NANX_TBL_DATA')))
         {
          if( in_array( $para_array['table'],array('nanx_system_cfg','nanx_sms','nanx_activity_field_public_display_cfg')))
           {
          $col_cfg=$this->MFieldcfg->colsTrnasfer('NULL',$fields_e);
           }
           else
           {
            $transfer=false;
            if( array_key_exists('transfer',$para_array))
             {
             $transfer=$para_array['transfer'];
             }
            $col_cfg=$this->MFieldcfg->getColsCfg('NULL',$fields_e,$transfer);
           }
         }
         
        if(in_array($activty_code,array('NANX_SYS_CONFIG','NANX_TBL_CREATE')))
         {
         $col_cfg=$this->MFieldcfg->colsTrnasfer('NULL',$fields_e);
         }
         
         
         if(in_array($activty_code,array('NANX_TBL_STRU','NANX_TBL_INDEX')))
         {
         $col_cfg=$this->MFieldcfg->colsTrnasfer('NULL',$fields_e);
         }

        if(in_array($activty_code,array('NANX_FS_2_TABLE')))
         {
         
         $col0= array('field_e' =>'pid',
                          'display_cfg' =>array('field_c'=>'pid','value'=>'pid')
                        );
         //$col_cfg=array($col0);
         $col_cfg=array();
         $file_trunk=$para_array['file_trunk'];
         for($i=0;$i< $file_trunk;$i++)
          {
            
           $col_i= array('field_e' =>'filename_'.$i,
                          'display_cfg' =>array('field_c'=>'filename_'.$i,'value'=>'filename_'.$i)
                        );
          
          
           $col_i= array('field_e' => $i,
                          'display_cfg' =>array('field_c'=> $i,'value'=> $i)
                        );
                        
           array_push($col_cfg,$col_i);
          }
         }
      }
      else
      {
      $fields_e=array(0=>'pid');
      }
    }
    
    if( array_key_exists('table',$para_array)&&(strlen($para_array['table'])>0))
	    {
       $cfg['base_table']=$para_array['table'];
	    }
    $cfg['pidOrder']= $this->getPidOrder($activty_code);
	  $cfg['curdCfg'] = $this->getCURDcfg($activty_code);
	  $cfg['colsCfg'] = $col_cfg;
	  $cfg['layoutCfg'] = $layout_cfg;
	  $cfg['activty_based_btns']=$this->getActivityBasedBtns($activty_code);
	  $cfg['js_btns']=$this->getJSBtns($activty_code);
	  $cfg['batch_btns']=$this->getBatchBtns($activty_code);
		$cfg['who_is_who']=$this->session->userdata('who_is_who');
    $cfg['whoami']=$this->session->userdata('user');

    
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
	 
	
	function getPidOrder($activty_code)
	{
	 $sql="select  pid_order from nanx_activity_pid_order";
	 $sql.=" where activity_code='$activty_code' ";
	 $pordercfg=$this->db->query($sql)->row();
	 if(empty($pordercfg)) 
	  {
	  $pordercfg=array('activity_code'=> $activty_code,'pid_order'=>'asc');
	  }
	 return $pordercfg;
	}
	
	function getCURDcfg($activty_code)
	{
	 $this->db->select();
	 $this->db->where('activity_code',$activty_code);  
	 $curdcfg=$this->db->get('nanx_activity_curd_cfg')->row();
	 if(empty($curdcfg)) 
	  {
	  $curdcfg=array('activity_code'=> $activty_code, 'fn_add'=>1,'fn_update'=>1,'fn_del'=>1 );
	  }
	 return $curdcfg;
	}
	
	function skip_field($activty_code,$fields_e)
	{ 
	  $this->load->model('MFieldcfg');
		$forbidden_fields=$this->MFieldcfg->getForbiddenFields($activty_code);
		$fields_e=array_diff($fields_e,$forbidden_fields);
    $res =    array_diff($fields_e,$forbidden_fields);
		return $res;
	}
	 
	
		function getActivityBasedBtns($activty_code)
	{
		$this->db->where('activity_code', $activty_code);
		$rows = $this->db->get('nanx_activity_a2a_btns')->result_array();
		return   $rows;
	}
	
		function getJSBtns($activty_code)
	{
	 $this->db->where('activity_code', $activty_code);
   $rows = $this->db->get('nanx_activity_js_btns')->result_array();
   return   $rows;
	}
	
	 
		function getBatchBtns($activty_code)
	{
		$this->db->where('activity_code', $activty_code);
		$rows = $this->db->get('nanx_activity_batch_btns')->result_array();
		return   $rows;
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
  
   $rows=$this->getExportData($para_array);   
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
   
   function   getExportData($para)
   {
    /*
     [code] => NANX_TBL_DATA
    [table] => newoss_book_sale_record
    [filter_field] => 
    [filter_value] => 
    [transfer] => 
    [activity_type] => service
    [excel_name] => newoss_book_sale_record
    [query_cfg] => 
    
    */ 
    if(($para['code']=='NANX_TBL_DATA')&&($para['activity_type']=='service'))
    {
      $table=$para['table']; 
	    $sql="select * from $table ";
	    $rows=$this->db->query($sql)->result_array();
      return $rows;
    }
    
    
    if($para['activity_type']=='sql')
   {
    $code=$para['code'];
    $sql="select `sql` from nanx_activity where  activity_code='$code'";
    $row=$this->db->query($sql)->result_array()[0];
    $sql_for_grid=$row['sql'];
    $ci =& get_instance();     
    $ci->load->model('MDatafactory');
    $table_rows =	$this->MDatafactory->getDatabySql($sql_for_grid);
   }
   else
   {
    $ci =& get_instance();     
    $ci->load->model('MDatafactory');
   
    $who_is_who_found=$this->MDatafactory->getWhoIsWho_where($para);
                if ( strlen( trim($who_is_who_found))==0  &&  array_key_exists('owner_data_only', $para)  )
                {
                   if($para['owner_data_only']==1){
                     $who_is_who_found='';
                     $who_is_who_found=$this->MDatafactory->getWhoIsProducer_where($para);
                   }
                }



    $table_rows =	 $ci->MDatafactory->getDatabyBasetable($para['table'],$para['filter_field'],$para['filter_value'],'asc',$para['query_cfg'] ,$who_is_who_found );
   }
   return $table_rows['rows'];
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