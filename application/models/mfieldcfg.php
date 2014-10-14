<?php 

class MFieldcfg  extends CI_Model{
  
  function getMysqlDataTypes($range)
  {
   $data_types=array( 'bigint','binary','bit','blob','bool','boolean','char','date','datetime',
             'decimal','double','enum','float','int','longblob','longtext','mediumblob',
              'mediumint','mediumtext','numeric','real','set','smallint','text','time',
              'timestamp','tinybolb','tinyint','tinytext','varbinary','varchar', 'year');
  
  
   $data_types_have_length=array( 'bigint','binary','bit','blob','bool','boolean','char','date','datetime',
             'decimal','double','enum','float','int','longblob','longtext','mediumblob',
              'mediumint','mediumtext','numeric','real','set','smallint','text','time',
              'timestamp','tinybolb','tinyint','tinytext','varbinary','varchar', 'year');
  
  
   $data_types_need_wrapper=array('char','date','datetime','text','time','timestamp','varchar');
               
  
  
  if($range=='all'){return $data_types;}
  if($range=='have_length'){return $data_types;}
  if($range=='wrap'){return $data_types_need_wrapper;}
  
  }
  
  
  function getColsCfg($base_table,$fields_e,$transfer)
	{
		$col_cfg = array();
		$tmp_cfg = array();
		foreach($fields_e as $field)
		{
	    $display_cfg=$this->getDisplayCfg($base_table,$field,$transfer);
		 	$editor_cfg =$this->getEditorCfg($base_table,$field);	
      $tmp_cfg['field_e'] = $field;
			$tmp_cfg['display_cfg'] = $display_cfg;
			$tmp_cfg['editor_cfg'] = $editor_cfg;
			$col_cfg[] = $tmp_cfg;
		}
    return $col_cfg;
	}
	
	
	function getDisplayCfg($base_table,$field,$transfer)
	{   
     // echo $base_table;
	    if(!$transfer)
		   {
		    return array('field_c'=> $field,
		    'value'=> $field,
		   'width'=>200,'show_as_pic'=>0);
		   }
		   
      	    
			$array=array('base_table' => $base_table, 'field_e' => $field);
			$this->db->where($array);
			$this->db->select( array('field_c','field_width','label_width','show_as_pic'));
			$row=$this->db->get('nanx_activity_field_special_display_cfg')->first_row('array');
      if($row)
        {
       if(strlen($row['field_c'])==0){ $row['field_c']=$field;}
        $row['value']=$field;
        return $row;
        }
      
      $array=array('field_e'=>$field);
			$this->db->where($array);
		  $this->db->select( array('field_c','field_width','label_width'));
			$row=$this->db->get('nanx_activity_field_public_display_cfg')->first_row('array');   
      if($row){
        $row['value']=$field;
        return $row;
        }
      
      $array=array('field_e' => $field);
			$this->db->where($array);
			$this->db->select( array('field_c','field_width','show_as_pic'));
			$row=$this->db->get('nanx_activity_field_special_display_cfg')->first_row('array');   
      if($row){
        $row['value']=$field;
        return $row;
        }
      
     
      $display=array('field_c'=> $field,'value'=> $field,
           'width'=>200,'show_as_pic'=>"0");
      return $display;
	}
	
	
	  function colsTrnasfer($tb,$fields_e)
	{ 
		$col_cfg = array();
		$tmp_cfg = array();
		foreach($fields_e as $field)
		{
		  $disp=array(
		   'field_c'=> $this->lang->line($field),
		   'value'=> $field,
		   'width'=>200,'show_as_pic'=>0);
	    $display_cfg=$disp;
      $editor_cfg =$this->getEditorCfg($tb,$field);	
      $tmp_cfg['field_e'] = $field;
			$tmp_cfg['display_cfg'] = $display_cfg;
			$tmp_cfg['editor_cfg'] = $editor_cfg;
			$col_cfg[]=$tmp_cfg;
		}
    return $col_cfg;
	}
	
	
	
	 
	
  function getTriggerCfg($base_table,$field)
	{
    $where=array(
      'base_table'=> $base_table,
      'field_e' => $field
    );
    $this->db->where($where);
    $this->db->select('combo_table,list_field,value_field,filter_field,group_id,level');
	  $trigger_cfg=$this->db->get('nanx_biz_column_trigger_group')->first_row('array');
    return $trigger_cfg;
  }	
  
  
  function getCommonEditCfg($base_table,$field)
  {
     $w=array(
      'base_table'=> $base_table,
      'field_e' => $field
      );
    
     $this->db->where($w);
     $common=$this->db->get('nanx_biz_column_editor_cfg')->first_row('array');
     if(count($common)>0)
     {
        unset($common['pid']);
        unset($common['base_table']);
        unset($common['field_e']);
     }
    else
     {
      $common=array();
     }
     return $common;
  }
 
  function getFollowCfg($base_table,$field)
	{
    $where=array(
      'base_table'=> $base_table,
      'field_e' => $field
    );
    $this->db->where($where);
    $this->db->select('base_table,field_e,combo_table,combo_table_value_field,base_table_follow_field,combo_table_follow_field');
	  $follow_cfg=$this->db->get('nanx_biz_column_follow_cfg')->result_array();
    return $follow_cfg;
  }	

  function getEditorCfg($base_table,$field)
	{
	if ($base_table=='NULL')
	  {
    	if($field=='datatype')  	
	    return array(
	      'combo'=> $this->getDataTypes()
	     );	
		
		if($field=='option')  	
	    return array(
	      'combo'=> $this->getIndexOptions()
	     );	
		return null;
		}
		
	$editor_cfg=$this->getCommonEditCfg($base_table,$field);
	$dt=$this->checkDatetimeField($base_table,$field);
	if($dt){$editor_cfg['datetime']=$dt;}
	$follow_cfg=$this->getFollowCfg($base_table,$field);
  $trigger_cfg=$this->getTriggerCfg($base_table,$field);
  $editor_cfg['trigger_cfg']=$trigger_cfg;
  $editor_cfg['follow_cfg']=$follow_cfg;
  return $editor_cfg;
  }	  
  
    
  function getDataTypes()
  {
	$data_types=$this->getMysqlDataTypes('all');
  $combo=array();
  for($i=0;$i<count($data_types);$i++)
   {
   	$combo[]=array('code'=> $data_types[$i],'value'=> $data_types[$i]);
   }
  return $combo;            
  }


  
  
  function checkDatetimeField($base_table,$field){
		if($field=='pid'){return null;}
		$dt=null;
		$table_cols=$this->db->query("show full fields from  $base_table")->result_array();
  	$onecol=arrayfilter($table_cols,'Field',$field);
  	if(count($onecol)==1){
			  if(($onecol[0]['Type']=='datetime')||($onecol[0]['Type']=='date')||($onecol[0]['Type']=='time'))
			    {$dt=$onecol[0]['Type'];}
		}
	 return $dt;
	}
	
	
	
	function getForbiddenFields($activty_code){
		$this->db->where('activity_code', $activty_code);
		$rows = $this->db->get('nanx_activity_forbidden_field')->result_array();
	  $forbidden_fields=array_retrieve($rows,'field');
	  return $forbidden_fields;
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
	
}
 
?>