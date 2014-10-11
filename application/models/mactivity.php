<?php 

class MActivity extends CI_Model{



    function skip_field($activty_code,$fields_e)
	{ 
	  $this->load->model('MFieldcfg');
		$forbidden_fields=$this->MFieldcfg->getForbiddenFields($activty_code);
		$fields_e=array_diff($fields_e,$forbidden_fields);
    $res =    array_diff($fields_e,$forbidden_fields);
		return $res;
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
	


	function getActivityBasedBtns($activty_code)
	{
		$this->db->where('activity_code', $activty_code);
		$rows = $this->db->get('nanx_activity_a2a_btns')->result_array();
		return   $rows;
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
  
}

?>