<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Copynode extends CI_Controller
{
  
    function src_dest_cfg()
    {
     $cfg=array(
       'activity_to_activitys'=>array(
         'root_table'=>'nanx_activity',
         'root_table_selector'=>'pid',
         'hook_field'=>'activity_code',
         'new_field_value_to_set'=>array('activity_code','grid_title'),
         'related_tables'=>array(
                           'nanx_activity',
                           'nanx_activity_batch_btns',
                           'nanx_activity_biz_layout',
                           'nanx_activity_a2a_btns',
                           'nanx_activity_curd_cfg',
                           'nanx_activity_forbidden_field',
                           'nanx_activity_pid_order',
                           'nanx_activity_js_btns'
                           )
        )
     );
     return $cfg;
    } 

    function index()
    {
        $post = file_get_contents('php://input');
        $para = (array )json_decode($post);
        $source=(array)$para['source'];
        $target=(array)$para['target'];
        $copy_paste_code=$source['category'].'_to_'.$target['category'];
        $cfg = $this->src_dest_cfg();
        $actcfg = $cfg[$copy_paste_code];
        $this->paste($source,$actcfg);
    }
    
    function paste($source,$cfg)
    {
     $this->db->where($cfg['root_table_selector'],$source[$cfg['root_table_selector']]); 
     $seed=$this->db->get($cfg['root_table'])->result_array();
     $seed=$seed[0];
     $hook_field=$cfg['hook_field'];
     $hook=$seed[$hook_field];
     $new_values=array();
     foreach( $cfg['new_field_value_to_set']  as $field_to_set )
      {
        $old_value=$seed[$field_to_set];
        $new_value=$old_value.'_copy';  
        $new_values[$field_to_set]= $new_value;
      }
     
     foreach($cfg['related_tables'] as  $related_table)
     {
        $this->db->where($hook_field,$hook);
        $related_rows=$this->db->get($related_table)->result_array();
        foreach($related_rows as $related_row)
         {  
            unset($related_row['pid']);
            while(list($key,$value)=each($new_values)){
              if (array_key_exists($key,$related_row)){$related_row[$key]=$value;}
              }
            reset($new_values);  
            $this->db->insert($related_table,$related_row);
          }
     }
     
       
      
        $text =$this->lang->line('act_copy_success');
        $success = true;
        $sqlresult_code = $this->db->_error_number();
        $errmsg = $this->db->_error_message();
        if ($sqlresult_code > 0)
        {
            $success = false;
        }
        $res = array(
            'success' => $success,
            'opcode' =>'activity_paste',
            'msg'=> $text,
            'errcode' => $sqlresult_code,
             'errmsg' =>   $this->lang->line('err_occur').$errmsg);
        echo json_encode($res);
    }
}

?>