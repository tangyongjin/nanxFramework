<?php

class MActivity extends CI_Model
{
    
    private $_CI; 
    

    public function __construct()
   {
    $this->_CI =& get_instance();
   }


    function skip_field($activity_code, $fields_e)
    {
        $this->load->model('MFieldcfg');
        $forbidden_fields = $this->MFieldcfg->getForbiddenFields($activity_code);
        $fields_e         = array_diff($fields_e, $forbidden_fields);
        $res              = array_diff($fields_e, $forbidden_fields);
        return $res;
    }
    
    function getJSBtns($activity_code)
    {
        $this->db->where('activity_code', $activity_code);
        $rows = $this->db->get('nanx_activity_js_btns')->result_array();
        return $rows;
    }
    
    
    function getBatchBtns($activity_code)
    {
        $this->db->where('activity_code', $activity_code);
        $rows = $this->db->get('nanx_activity_batch_btns')->result_array();
        return $rows;
    }
    
    function  callerIncaller($url,$para)
    { 
        $c_and_m = explode("/", $url);
        $c=$c_and_m[0];
        $m=$c_and_m[1];
        $arg=json_encode($para);
        
        $control_dir=dirname(__FILE__);
        $CI=&get_instance();
        $CI->load->library("../controllers/$c");
        
        $this->_CI->load->library("../controllers/$c");
       
        $result=$CI->$c->$m($para);
        return $result;
    }
  
    
    
    function getActivityBasedBtns($activity_code)
    {
        $this->db->where('activity_code', $activity_code);
        $rows = $this->db->get('nanx_activity_a2a_btns')->result_array();
        return $rows;
    }
    
    
    function getCURDcfg($activity_code)
    {
        $this->db->select();
        $this->db->where('activity_code', $activity_code);
        $curdcfg = $this->db->get('nanx_activity_curd_cfg')->row();
        if (empty($curdcfg)) {
            $curdcfg = array(
                'activity_code' => $activity_code,
                'fn_add' => 1,
                'fn_update' => 1,
                'fn_del' => 1
            );
        }
        return $curdcfg;
    }
    
    
    
    function getPidOrder($activity_code)
    {
        $sql = "select  pid_order from nanx_activity_pid_order";
        $sql .= " where activity_code='$activity_code' ";
        $pordercfg = $this->db->query($sql)->row();
        if (empty($pordercfg)) {
            $pordercfg = array(
                'activity_code' => $activity_code,
                'pid_order' => 'asc'
            );
        }
        return $pordercfg;
    }
    
    

     function  sqlIncaller($sql)
    {  
         $ret=array(); 
         $dbres=$this->db->query($sql);
         if ($dbres){
            $ret['rows']=$dbres->result_array();
            $ret['dbok']=true;
         }
         else
         {
            $ret['dbok']=false;
            $ret['rows']=null;
         }
         return $ret;
    }




     function getFieldesByType($activity_summary,$para_array)
    {    
        $activity_type   = $activity_summary['activity_type'];
        $activity_code   = $activity_summary['activity_code'];
        $url_for_get_cfg = $activity_summary['url_for_get_cfg'];
        $service_url     = $activity_summary['service_url'];
        $sql             = $activity_summary['sql'];
        $base_table      = $activity_summary['base_table'];
          
        $col_cfg=array();   



       if ($activity_type == 'html') {
            $col_cfg = array();
        }
      
       if ($activity_type == 'table') {
            $para_array['transfer'] = true;
            $fields_e               = $this->skip_field($activity_code, $this->db->list_fields($base_table));
            $col_cfg = $this->MFieldcfg->getColsCfg($base_table, $fields_e, $para_array['transfer']);
        }

         if ($activity_type == 'sql') {
            $this->load->model('MFieldcfg');
            
            if (isset($para_array['para_json'])) {
                $sql_para  = $para_array['para_json'];
                $sql_fixed = strMarcoReplace($sql, $sql_para);
            } else {
                $sql_fixed = $sql;
            }


            $ret = $this->sqlIncaller($sql_fixed);
            
            if(! $ret['dbok']){
                $col_cfg=array('sql_syntax_error'=>true);
            }
            else
            {
                 if ($ret['rows'] )
                    {
                        $fields_e = array_keys($ret['rows'][0]);
                        if ($activity_code == 'NANX_TB_LAYOUT') {
                            $arr      = getLayoutFields($ret['rows']);
                            $fields_e = $arr['cols'];
                        }
                        $col_cfg = $this->MFieldcfg->getColsCfg('NULL', $fields_e, true);
                    } 
                    else 
                    {
                        $fields_e = array(
                            0 => 'pid'
                        );
                        if ($activity_code == 'NANX_TB_LAYOUT') {
                            $fields_e = array(
                                0 => 'col_0'
                            );
                        }
                        $col_cfg = $this->MFieldcfg->getColsCfg('NULL', $fields_e, true);
                    }
            }
             
        }

        if ($activity_type == 'service') {
            $selfmodel=$this;

            $ret = $selfmodel->callerIncaller($service_url, $para_array);
            if ($ret) {
                $ret2arr = $ret;
                $fields_e = array_keys($ret2arr[0]);
                if ($activity_code=='NANX_TBL_DATA')
                {
                    if (in_array($para_array['table'], array(
                        'nanx_system_cfg',
                        'nanx_sms',
                        'nanx_activity_field_public_display_cfg'
                    ))) {
                        $this->load->model('MFieldcfg');
                        $col_cfg = $this->MFieldcfg->colsTrnasfer('NULL', $fields_e);
                    } else {
                        $transfer = false;
                        if (array_key_exists('transfer', $para_array)) {
                            $transfer = $para_array['transfer'];
                        }
                        $this->load->model('MFieldcfg');
                        
                        $col_cfg = $this->MFieldcfg->getColsCfg('NULL', $fields_e, $transfer);
                    }
                }
                
                if (in_array($activity_code, array(
                    'NANX_SYS_CONFIG',
                    'NANX_TBL_CREATE',
                    'NANX_TBL_STRU',
                    'NANX_TBL_INDEX'
                ))) {
                    $this->load->model('MFieldcfg');
                    $col_cfg = $this->MFieldcfg->colsTrnasfer('NULL', $fields_e);
                }
                
                
                if ( $activity_code=='NANX_FS_2_TABLE')
                {
                    $col_cfg    = array();
                    $file_trunk = $para_array['file_trunk'];
                    for ($i = 0; $i < $file_trunk; $i++) {
                        $col_i = array(
                            'field_e' => $i,
                            'display_cfg' => array(
                                'field_c' => $i,
                                'value' => $i
                            )
                        );
                        array_push($col_cfg, $col_i);
                    }
                }
            }
        }
       return $col_cfg;
    }

   

     function getActivityCfg($para_array)
    {

        $this->load->model('MFieldcfg');
        $this->load->model('MLayout');
        $layout_cfg   = array();
        $activity_code = $para_array['code'];
        $this->db->where('activity_code', $activity_code);
        $query           = $this->db->get('nanx_activity');
        $activity_summary             = $query->first_row('array');
        $activity_type   = $activity_summary['activity_type'];

        if ($activity_type == 'table') {
            $base_table             = $activity_summary['base_table'];
            $layout_cfg = $this->MLayout->getLayoutCfg($activity_code, $base_table);
        }

      
        if (array_key_exists('table', $para_array) && (strlen($para_array['table']) > 0)) {
            $activity_summary['base_table'] = $para_array['table'];
        }
        
        $col_cfg=$this->getFieldesByType($activity_summary,$para_array);
        
        if(array_key_exists('sql_syntax_error', $col_cfg))
        {
        $activity_summary['sql_syntax_error']   = $col_cfg['sql_syntax_error'];
        $col_cfg=array();     
        }
        
        $activity_summary['pidOrder']           = $this->getPidOrder($activity_code);
        $activity_summary['curdCfg']            = $this->getCURDcfg($activity_code);
        $activity_summary['colsCfg']            = $col_cfg;
        $activity_summary['layoutCfg']          = $layout_cfg;
        $activity_summary['activty_based_btns'] = $this->getActivityBasedBtns($activity_code);
        $activity_summary['js_btns']            = $this->getJSBtns($activity_code);
        $activity_summary['batch_btns']         = $this->getBatchBtns($activity_code);
        $activity_summary['who_is_who']         = $this->session->userdata('who_is_who');
        $activity_summary['whoami']             = $this->session->userdata('user');
        return $activity_summary;
    }
    
}

?>