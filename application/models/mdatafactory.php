<?php
class MDatafactory extends CI_Model
{
    function setSqlbyBasetable($basetable, $filter_field, $filter_value, $pid_order)
    {
        $where = array(
            'base_table' => $basetable
        );
        
        $combo_fields = $this->db->select('base_table,field_e,combo_table,list_field,value_field,filter_field,group_id,level')->get_where('nanx_biz_column_trigger_group', $where)->result_array();
        $base_fields  = $this->db->list_fields($basetable);
        
        $transed_field = array();
        $joins         = array();
        $ghosts        = array();
        
        
        
        $field_list_str = '';
        $join_str       = '';
        $ghosts_str     = '';
        
        // 对每个列,查找combo_fields,看是否需要替换为left join形式.
        foreach ($base_fields as $table_field) {
            $found           = $this->getTransedField($basetable, $table_field, $combo_fields);
            //debug($found);
            $transed_field[] = $found['transed'];
            $ghosts[]        = $found['ghost'];
            $joins[]         = $found['join'];
        }
        
        
        foreach ($transed_field as $field) {
            $field_list_str .= $field . ",";
        }
        
        foreach ($ghosts as $ghost) {
            if (strlen($ghost) > 10) {
                $ghosts_str .= $ghost . ",";
            }
        }
        
        $live_and_ghost = $field_list_str . $ghosts_str;
        $live_and_ghost = substr($live_and_ghost, 0, -1);
        
        foreach ($joins as $join) {
            $join_str .= $join;
        }
        
        
        
        
        $sql = "select $live_and_ghost from $basetable ";
        
        $filter_sql = '';
        if ($filter_field) {
            $filter_sql = " where  $basetable.$filter_field='" . $filter_value . "'";
        }
        
        $sql_select = $sql . $join_str . $filter_sql;
        $sql_select .= " order by $basetable.pid $pid_order";
        //echo $sql_select;
        
        return $sql_select;
    }
    
    function getTransedField($basetable, $field, $combo_fileds)
    {
        
        if ($field == 'pid') {
            $transed = $basetable . "." . $field;
            $join    = '';
            return array(
                'join' => '',
                'transed' => $transed,
                'ghost' => ''
            );
        }
        
        //根据combo方式,挨个对table_field进行检查,看是否需要进行join连接.
        //如果combo_fields为空,则直接返回field.
        if (!$combo_fileds) {
            $transed = $basetable . "." . $field;
            $join    = '';
            $ghost   = '';
        }
        
        //如果combo_fields不为空,则检查,找到则返回转后的,否则直接直接返回field.
        
        foreach ($combo_fileds as $combo_4meta) {
            if ($field == $combo_4meta['field_e']) {
                $transed = $combo_4meta['combo_table'] . "." . $combo_4meta['list_field'] . " as " . $combo_4meta['field_e'];
                $join    = " left join   " . $combo_4meta['combo_table'] . " on " . $combo_4meta['combo_table'] . "." . $combo_4meta['value_field'] . "=" . $basetable . "." . $field;
                $ghost   = " $basetable.$field  as ghost_$field";
                break;
            } else {
                $join    = '';
                $transed = $basetable . "." . $field;
                $ghost   = '';
            }
        }
        
        reset($combo_fileds);
        return array(
            'join' => $join,
            'transed' => $transed,
            'ghost' => $ghost
        );
    }


    function join_who_is_who($sql,$who_is_who_found)
    {
      $who_is_who_found=trim($who_is_who_found);
      if (strlen($who_is_who_found)==0){
        return $sql;
      } 

      $sql_has_where='';
      if (strpos($sql,'where') !== false)
      {
         $new_where=" and $who_is_who_found ";
      }else{
        $new_where=" where $who_is_who_found ";
      }

      $orderbystring_pos=strrpos($sql,'order');

      $sql_add_whoiswho = substr_replace($sql, $new_where, $orderbystring_pos, 0);
      return $sql_add_whoiswho;


    }
    
    function getDatabyBasetable($table, $filter_field, $filter_value, $pid_order, $query_cfg,$who_is_who_found)
    {
        $transfer = true;
        $sql      = $this->setSqlbyBasetable($table, $filter_field, $filter_value, $pid_order);
        if ($query_cfg) {
            $all_fields = $this->db->query("show full fields from  $table")->result_array();
            $all_fields = array_retrieve($all_fields, array(
                'Field',
                'Type'
            ));
            $this->load->model('MFieldcfg');
            $need_types   = $this->MFieldcfg->getMysqlDataTypes('wrap');
            $needs        = $this->check_col_wrapper($need_types, $all_fields);
            $query_cfg    = (array) ($query_cfg);
            $search_count = $query_cfg['count'];
            $search_cfg   = (array) $query_cfg['lines'];
            $sql          = $this->buildSql($table, $sql, $search_count, $search_cfg, $needs);
        }

        $sql=$this->join_who_is_who($sql,$who_is_who_found);
        
        $db_q = $this->db->query($sql);
        if ($db_q) {
            $rows  = $db_q->result_array();
            $total = count($rows);
            
            
            if (isset($_GET['start'])) {
                $start = $_GET['start'];
                $limit = $_GET['limit'];
                $sql   = $sql . " limit $start,$limit";
            }
            $rows          = $this->db->query($sql)->result_array();
            $data['rows']  = $rows;
            $data['total'] = $total;
            $data['table'] = $table;
            $data['sql']   = $sql;
            return $data;
        } else {
            $data['success'] = false;
            $data['error']   = 'SqlSyntaxError';
            $data['msg']     = 'check sql para' . $sql;
            $data['sql']     = $sql;
            return $data;
        }
    }
    
    function getWhoIsProducer_where($p)
    {
       $sql_who_is_who='';  
       $maintable=$p['table'];
       $whoami=$p['whoami'];
       $sql="select field_e from  nanx_biz_column_editor_cfg where base_table='$maintable' and is_produce_col=1 "; 
       $row=$this->db->query($sql)->row_array();
       $main_table_field=$row['field_e'];
       $sql_who_is_who=" $maintable.$main_table_field='$whoami'";
       return $sql_who_is_who;
    }
    
    function getWhoIsWho_where($p)
    {
    
      if(! array_key_exists('whoami', $p) ) {return '';}  
      $sql_who_is_who='';  
      $who_is_who=$p['who_is_who'];
      if (count($who_is_who)>=1 )
              {
              $maintable=$p['table'];
              $logged_user=$p['whoami'];
              $who_is_who=$p['who_is_who'][0];
              $who_is_who_value=$who_is_who->inner_table_value;  
              $staff_table=$who_is_who->inner_table;
              $sql=" select * from nanx_biz_column_trigger_group where base_table='$maintable'  and combo_table='$staff_table' and level=1 limit 1 ";
              $row=$this->db->query($sql)->row_array();
              if($row){
                $main_table_field=$row['field_e'];
                $sql_who_is_who=" $maintable.$main_table_field = $who_is_who_value";
               } 
              }
     return $sql_who_is_who;
    }

    function buildSql($table, $sql, $count, $lines, $needs)
    {
        $fix   = 'where 1=1 and(';
        $where = '';
        for ($i = 0; $i < $count; $i++) {
            $and_or = $lines['and_or_' . $i];
            if ($i == 0) {
                $and_or = '';
            }
            $field = $lines['field_' . $i];
            if (in_array($field, $needs)) {
                $wrapp_text = "'";
            } else {
                $wrapp_text = "";
            }
            
            $field = $table . "." . $lines['field_' . $i];
            
            $operator = $lines['operator_' . $i];
            $arg      = $lines['vset_' . $i];
            
            if ($operator == 'like') {
                $arg = '%' . $arg . '%';
            }
            if ($operator == 'like_end') {
                $operator = 'like';
                $arg      = $arg . '%';
            }
            if ($operator == 'like_begin') {
                $operator = 'like';
                $arg      = '%' . $arg;
            }
            
            
            $where .= $and_or . ' (' . $field . ' ' . $operator . ' ' . $wrapp_text . $arg . $wrapp_text . ') ';
            
        }
        $sql = str_replace('order', $fix . $where . ') order ', $sql);
        return $sql;
    }
    
    function check_col_wrapper($need_types, $all_fields)
    {
        $need = array();
        foreach ($all_fields as $one) {
            $field = $one['Field'];
            $a     = explode('(', $one['Type']);
            $type  = $a[0];
            if (in_array($type, $need_types)) {
                $need[] = $field;
            }
        }
        return $need;
    }
    
    function getDatabySql($sql)
    {
        $rows          = $this->db->query($sql)->result_array();
        $total         = count($rows);
        $data['rows']  = $rows;
        $data['total'] = $total;
        $data['sql']   = $sql;
        return $data;
    }
    
    
}
?>