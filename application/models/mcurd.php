<?php 

class MCurd extends CI_Model{

    function getCurrentCfg(){
        $sql = $this->db->select()->from('nanx_system_cfg')->get()->result_array();
        return $sql;
    }
    
    function insert_current_cfg($data){
        $this->db->insert('nanx_system_cfg', $data);
    $error_number=$this->db->_error_number();
        return $error_number;
    }
    
    function update_current_cfg($data){
        $this->db->where('id', $data['id']);
        $this->db->update('nanx_system_cfg', $data);    
    $error_number=$this->db->_error_number();
        return $error_number;
    }
    
    function delete_current_cfg($cfg_id){
        $this->db->delete('nanx_system_cfg', array('id' => $cfg_id));
        $error_number=$this->db->_error_number();
        return $error_number;
    }
    
    function getCfgItem($item){
        $item = $this->db->select('value')->get_where('nanx_system_cfg', array('key' => $item))->result_array()[0]['value'];
    return $item; 
    }

     

    function getActivityData($p)
    {
        
        $this->load->model('MDatafactory'); 
        if (array_key_exists('code', $p)) {
            $code = $p['code'];
            $this->db->where('activity_code', $code);
            $query         = $this->db->get('nanx_activity');
            $cfg           = $query->first_row('array');
            $activity_type = $cfg['activity_type'];
        } else {
            $activity_type = 'table';
        }
        
        if (($activity_type == 'service') && ($code == 'NANX_TBL_DATA')) {
            
            if (isset($_GET['start'])) {
                $start = $_GET['start'];
                $limit = $_GET['limit'];
            }
            
            $table = $p['table'];
            if (array_key_exists('pid_order', $p)) {
                $pidorder = $p['pid_order'];
            } else {
                $pidorder = 'asc';
            }
            
            if (array_key_exists('filter_field', $p)) {
                $filter_field = $p['filter_field'];
                $filter_value = $p['filter_value'];
                
                $this->db->where($filter_field, $filter_value);
                $rows  = $this->db->get($table)->result_array();
                $total = count($rows);
                $this->db->order_by('pid', $pidorder);
                $this->db->where($filter_field, $filter_value);
                $this->db->limit($limit, $start);
                $rows = $this->db->get($table)->result_array();
            } else {
                $sql   = "select * from $table order by pid $pidorder limit $start,$limit ";
                $rows  = $this->db->query($sql)->result_array();
                $total = $this->db->count_all($table);
            }
            
            $result['rows']  = $rows;
            $result['total'] = $total;
            $result['table'] = $table;
            $result['sql']   = null;
        } else {
            if (($activity_type == 'table') || ($p['code'] == 'NANX_TBL_DATA')) {
                $filter_field = null;
                $filter_value = null;
                $who_is_who_found=$this->MDatafactory->getWhoIsWho_where($p);
                if ( strlen( trim($who_is_who_found))==0  &&  array_key_exists('owner_data_only', $p)  )
                {
                   if($p['owner_data_only']==1){
                     $who_is_who_found='';
                     $who_is_who_found=$this->MDatafactory->getWhoIsProducer_where($p);
                   }
                }
                
                if (array_key_exists('filter_field', $p)) {
                    $filter_field = $p['filter_field'];
                    $filter_value = $p['filter_value'];
                }
                
                
                if (array_key_exists('query_cfg', $p)) {
                    $query_cfg = $p['query_cfg'];
                } else {
                    $query_cfg = null;
                }
                
                $table     = $p['table'];
                $pid_order = (isset($p['pid_order'])) ? $p['pid_order'] : 'asc';
                $result    = $this->MDatafactory->getDatabyBasetable($table, $filter_field, $filter_value, $pid_order, $query_cfg,$who_is_who_found);
            }
        }
        
        
        
        if ($activity_type == 'sql') {
            $activty_code = $p['code'];
            $this->db->where('activity_code', $activty_code);
            $query = $this->db->get('nanx_activity');
            $cfg   = $query->first_row('array');
            $sql   = $cfg['sql'];
            if (isset($p['para_json'])) {
                $sql_fixed = strMarcoReplace($sql, $p['para_json']);
            } else {
                $sql_fixed = $sql;
            }
            
            $result = $this->MDatafactory->getDatabySql($sql_fixed);
            if ($activty_code == 'NANX_TB_LAYOUT') {
                $mixed           = getLayoutFields($result['rows']);
                $rows            = $mixed['data'];
                $result['rows']  = $rows;
                $result['total'] = count($rows);
                $result['sql']   = $sql_fixed;
            }
        }
        return $result;

      }

}
?>