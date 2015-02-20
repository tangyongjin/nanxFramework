<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Curd extends CI_Controller
{
    
    function listData()
     {
        
         $post = file_get_contents('php://input');
         $p    = (array) json_decode($post);
         $this->load->model('MCurd');
         $result=$this->MCurd->getActivityData($p);

         $json = json_encode($result, JSON_UNESCAPED_UNICODE);
         $json_fixed=str_replace("null", "''", $json);
          

         echo $json_fixed;
     }
    
    function updateData()
    {
        $post    = file_get_contents('php://input');
        $p       = (array) json_decode($post);
        $actcode = $p['actcode'];
        $this->write_notify($actcode, 'update');
        $base_table = $p['table'];
        $rawData    = (array) $p['rawdata'];
        $pid        = $rawData['pid'];
        
        
        $dt_fileds  = $this->getDatetimeFiled($base_table);
        $date_check = $this->checkDateFmt($p, $dt_fileds);
        unset($rawData['pid']);
        
        
        $this->db->where('pid', $pid);
        
        $row_to_update = $this->db->get($base_table)->result_array();
        if (count($row_to_update) == 1) {
            $row_to_update = $row_to_update[0];
        } else {
            $row_to_update = '';
        }
        
        $this->db->where('pid', $pid);
        $this->db->update($base_table, $rawData);
        $errno = $this->db->_error_number();
        if ($errno == 0) {
            $sql  = $this->db->last_query();
            $resp = array(
                'success' => true,
                'msg' => $this->lang->line('success_update_table_data')
            );
            
        } else {
            $resp = array(
                'success' => false,
                'msg' => $this->lang->line('error_code') . ':' . $errno
            );
        }
        
        $this->write_session_log('update', $p, $row_to_update);
        echo json_encode($resp);
    }
    
    function batchData()
    {
        $post       = file_get_contents('php://input');
        $p          = (array) json_decode($post);
        $actcode    = $p['actcode'];
        $batch_pids = $p['batch_pids'];
        $base_table = $p['table'];
        $rawData    = (array) $p['rawdata'];
        $arr        = (array) $p['rawdata'];
        
        $errno      = 0;
        $single_err = 0;
        foreach ($batch_pids as $pid) {
            
            $this->db->where('pid', $pid);
            $this->db->update($base_table, $arr);
            $single_err = $this->db->_error_number();
            $errno += $single_err;
        }
        
        if ($errno == 0) {
            $sql  = $this->db->last_query();
            $resp = array(
                'success' => true,
                'msg' => $this->lang->line('success_batch_update_table_data')
            );
            
        } else {
            $resp = array(
                'success' => false,
                'msg' => $this->lang->line('error_code') . ':' . $single_err
            );
        }
        $this->write_session_log('batchUpdateData', $p, '');
        echo json_encode($resp);
    }
    
    function addData()
    {
        $post    = file_get_contents('php://input');
        $p       = (array) json_decode($post);
        $actcode = $p['actcode'];
        $this->write_notify($actcode, 'add');
        $base_table = $p['table'];
        $rawData    = (array) $p['rawdata'];
        $this->db->insert($base_table, $rawData);
        $errno = $this->db->_error_number();
        if ($errno == 0) {
            $resp = array(
                'success' => true,
                'msg' => $this->lang->line('success_add_table_data')
            );
        } else {
            $resp = array(
                'success' => false,
                'msg' => $this->lang->line('error_code') . ':' . $errno
            );
        }
        $this->write_session_log('add', $p, '');
        echo json_encode($resp);
    }
    
    function deleteData()
    {
        
        $post    = file_get_contents('php://input');
        $p       = (array) json_decode($post);
        $actcode = $p['actcode'];
        $this->write_notify($actcode, 'delete');
        $base_table   = $p['table'];
        $pids         = $p['pid_to_del']; // pid like '1,23,4,9'
        $total_error  = 0;
        $rows_deleted = array();
        
        foreach ($pids as $pid) {
            $where = array(
                'pid' => $pid
            );
            
            $this->db->where($where);
            
            $row_to_del = $this->db->get($base_table)->result_array();
            if (count($row_to_del) == 1) {
                array_push($rows_deleted, $row_to_del[0]);
            }
            
            $this->db->delete($base_table, $where);
            $errno       = $this->db->_error_number();
            $total_error = $total_error + $errno;
        }
        
        if ($total_error == 0) {
            $resp = array(
                'success' => true,
                'msg' => $this->lang->line('success_delete_table_data')
            );
        } else {
            $resp = array(
                'success' => false,
                'msg' => $this->lang->line('error_code') . ':' . $errno
            );
        }
        $this->write_session_log('delete', $p, $rows_deleted);
        echo json_encode($resp);
    }
    
    function write_notify($activity_code, $action)
    {
        $sess     = $this->session->all_userdata();
        $operator = $sess['staff_name'];
        $sql      = "select  '$operator' as operator, grid_title,user ,action from nanx_activity   ,nanx_activity_nofity,nanx_user_role_assign
          where nanx_activity.activity_code=nanx_activity_nofity.activity_code  and
          nanx_activity_nofity.activity_code ='$activity_code'  and action='$action' and 
          nanx_activity_nofity.receiver_role_list=nanx_user_role_assign.role_code";
        
        if ($action == 'add') {
            $action = $this->lang->line('operation_add');
        }
        if ($action == 'update') {
            $action = $this->lang->line('operation_update');
        }
        if ($action == 'delete') {
            $action = $this->lang->line('operation_delete');
        }
        date_default_timezone_set('PRC');
        $datesend = date('Y-m-d H:i:s');
        $msgs     = $this->db->query($sql)->result_array();
        if ($msgs) {
            for ($i = 0; $i < count($msgs); $i++) {
                $operator = $msgs[$i]['operator'];
                $act      = $msgs[$i]['grid_title'];
                $txt      = "$operator:" . $this->lang->line('on_activity') . ':' . $act . $this->lang->line('executed') . $action . $this->lang->line('operation');
                $msg_send = array(
                    'sender' => $this->lang->line('system_sender'),
                    'receiver' => $msgs[$i]['user'],
                    'msg' => $txt,
                    'title' => $txt,
                    'sendtime' => $datesend
                );
                $this->db->insert('nanx_sms', $msg_send);
            }
        }
    }
    
    
    function write_session_log($type, $p, $old_data)
    {
        
        if (!array_key_exists('rawdata', $p)) {
            $p['rawdata'] = $object = new stdClass();
        }
        
        $sess     = $this->session->all_userdata();
        $operator = $sess['staff_name'];
        $user     = $sess['user'];
        
        
        
        $log_data = array(
            'user' => $operator . '[' . $user . ']',
            'action_cmd' => $type,
            'act_code' => $p['actcode'],
            'table' => $p['table'],
            'rawdata' => array2string((array) $p['rawdata'])
        );
        
        switch ($type) {
            case 'add':
                $log_data['pids'] = '';
                
                break;
            case 'delete':
                $log_data['pids']     = array2string($p['pid_to_del']);
                $log_data['old_data'] = array2string($old_data);
                break;
            
            case 'update':
                $log_data['pids'] = '';
                //  $log_data['rawdata']= array2string( (array)($p['rawdata']));
                
                $log_data['old_data'] = array2string($old_data);
                
                break;
            case 'batchUpdate':
                $log_data['pids'] = array2string($p['batch_pids']);
                break;
        }
        $this->db->insert('nanx_session_log', $log_data);
        
        
    }
    
    function getDatetimeFiled($table)
    {
        $sql2      = "SELECT  C.`COLUMN_NAME`  FROM information_schema.`COLUMNS` C where  table_schema='oss'  and  table_name='$table' and DATA_TYPE='datetime'";
        $dt_fields = $this->db->query($sql2)->result_array();
    }
    
    function checkDateFmt($array, $cols)
    {
        $check = true;
        foreach ($array as $col) {
        }
    }
}

?>