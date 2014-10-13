<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Rdbms extends CI_Controller
{
  
    function getTableColInfo($table)
    {
        $sql = " show full fields from $table ";
        $cols_all = $this->db->query($sql)->result_array();
        $col_info = array();
        $pid = 0;
        foreach ($cols_all as $col)
        {
            $value_list = array_values($col);
            $col_obj = $this->getColumnDetail($value_list);
            $col_obj['pid'] = $pid;
            $pid++;
            $col_info[] = $col_obj;
        }
        return $col_info;
    }

    function runsql()
    {
        $params = (array )json_decode($_REQUEST['params']);
        $sql = $params['sql'];
        $ret = $this->db->query($sql);

        $success = 'success';
        $sqlresult_code = '0';
        $res = array('success' => 'success', 'server_resp' => array('success' => true));

        echo json_encode($res);

    }


    function get_table_creation_info_directshow()
    {
        $post = file_get_contents('php://input');
        $para_array = (array )json_decode($post);
        $ret = $this->get_table_creation_info($para_array);
        echo json_encode($ret, JSON_UNESCAPED_UNICODE);
    }

    function get_table_creation_info_no_directshow()
    {
        $post = file_get_contents('php://input');
        $para_array = (array )json_decode($post);
        $ret = $this->get_table_creation_info($para_array);
        return $ret;
    }


    function get_table_creation_info($para_array)
    {
        if (array_key_exists('table', $para_array))
        {
            $table = $para_array['table'];
            $output['createtable'] = false;
            $output['altertable'] = true;
        } else
        {
            $table = 'nanx_shadow';
            $output['createtable'] = true;
            $output['altertable'] = false;
        }

        $output = array();
        $col_info = $this->getTableColInfo($table);
        $tmp = $this->getKeynameAndPKcols($table);
        $key_names = $tmp['key_names'];
        $primary_key_columns = $tmp['primary_key_columns'];

        $charset_and_coolaction = $this->get_charset_collation('');
        $output['charset'] = $charset_and_coolaction['charset'];
        $output['collation'] = $charset_and_coolaction['collation'];
        array_unshift($output['collation'], array('[default]'));
        $output['table'] = $table;
        $output['key_names'] = $key_names;
        $output['primary_key_columns'] = $primary_key_columns;
        $output['success'] = true;
        
        $output[0] = array(
            'pid' => 'pid',
            'field_name' => 'field_name',
            'datatype' => 'datatype',
            'length' => 'length',
            'default_value' => 'default_value',
            'primary_key' => 'primary_key',
            'not_null' => 'not_null',
            'unsigned' => 'unsigned',
            'auto_increment' => 'auto_increment',
            'comment' => 'comment');
        $output['rows'] = $col_info;
        return $output;
    }

    function getKeynameAndPKcols($table)
    {
        $tmp = array();
        $table_keys = $this->getTableKeys($table);
        $key_names = array();
        $primary_key_columns = array();
        if (!empty($table_keys))
        {
            foreach ($table_keys as $key)
            {
                $key_names[] = strtolower($key['Key_name']);
                if (strcasecmp($key['Key_name'], 'PRIMARY') == 0)
                {
                    $primary_key_columns[] = $key['Column_name'];
                }
            }
        }
        $tmp['key_names'] = $key_names;
        $tmp['primary_key_columns'] = $primary_key_columns;
        return $tmp;
    }


    function get_min_table_indexes_directshow()
    {
        $post = file_get_contents('php://input');
        $para_array = (array )json_decode($post);
        $table = $para_array['table'];
        $ret = $this->get_min_table_indexes($table);
        echo json_encode($ret, JSON_UNESCAPED_UNICODE);
    }


    function get_min_table_indexes_no_directshow()
    {
        $post = file_get_contents('php://input');
        $para_array = (array )json_decode($post);
        $table = $para_array['table'];
        $ret = $this->get_min_table_indexes($table);
        return $ret;
    }


    function get_min_table_indexes($table)
    {

        $output = new stdClass();
        $output->success = true;
        $output->primary_keys = array();

        $cols4index = array();
        $table_columns = $this->getTableColumnNames($table);
        foreach ($table_columns as $column)
        {
            $cols4index[] = $column;
        }

        $rows = $this->getTableKeys($table);
        $indexes = array();
        for ($i = 0; $i < count($rows); $i++)
        {

            if (strtolower($rows[$i]['Key_name']) == 'primary')
            {
                $output->primary_keys[] = $rows[$i]['Column_name'];
            }

            $index = $this->index_with_key($rows[$i]['Key_name'], $indexes);
            if ($index)
            {
                $index->columns = $index->columns . ', ' . $rows[$i]['Column_name'];
                continue;
            }

            $index = new stdClass();

            $index->index = $rows[$i]['Key_name'];
            $index->columns = $rows[$i]['Column_name'];
            $index->add_column = '';
            $index->option = (!$rows[$i]['Non_unique']) ? 'UNIQUE' : (($rows[$i]['Index_type'] ==
                'FULLTEXT') ? 'FULLTEXT' : '');
            $indexes[] = $index;
        }
        $response = array();
        $response['id'] = 1989;
        $response['table'] = $table;
        $response['server_resp'] = $output;
        $response['rows'] = $indexes;
        for ($j = 0; $j < count($indexes); $j++)
        {
            $response['rows'][$j]->pid = $j;
        }


        $response['cols4index'] = $cols4index;
        $response['success'] = true;
        $response[0] = array(
            'pid' => 'pid',
            'index' => 'index',
            'columns' => 'columns',
            'add_column' => 'add_column',
            'option' => 'option');
        return $response;
    }

    function index_with_key($key_name, $list)
    {
        for ($x = 0; $x < count($list); $x++)
        {
            if ($list[$x]->index == $key_name)
            {
                return $list[$x];
            }
        }
        return null;
    }


    function prepare_data($rows)
    {
        $fields = array();
        $models = array();
        $data = array();
        if (!$rows)
            return array(
                $fields,
                $models,
                $data);
        foreach ($rows[0] as $name => $value)
        {
            $fields[] = $name;
            $c = new stdClass;
            $c->id = $name;
            $c->header = $name;
            $c->sortable = true;
            $c->dataIndex = $name;
            $c->width = strlen($name) * 8 + 8;
            $models[] = $c;
        }
        foreach ($rows as $row)
        {
            $arr = (array )$row;
            $data[] = array_values($arr);
            $i = 0;
            foreach ($arr as $key => $value)
            {
                if (strlen((string )$value) * 8 > $models[$i]->width)
                {
                    $models[$i]->width = strlen((string )$value) * 8;
                }
                $i++;
            }
        }
        return array($data);
    }


    function get_charset_collation($params)
    {
        $charset_and_collaction = array();
        $charsets = $this->getCharsets();
        foreach ($charsets as $c)
        {
            $charset_and_collaction['charset'][] = array($c);
        }
        $collations = $this->getCollations();
        foreach ($collations as $c)
        {
            $charset_and_collaction['collation'][] = array($c);
        }
        return $charset_and_collaction;
    }

    function getCharsets()
    {
        return array(0 => array(
                'Charset' => 'utf8',
                'Description' => 'UTF-8 Unicode',
                'Default collation' => 'utf8_general_ci',
                'Maxlen' => 3));
    }

    function getCollations()
    {
        return array(0 => array(
                'Collation' => 'utf8_bin',
                'Charset' => 'utf8',
                'Id' => 83,
                'Default' => '',
                'Compiled' => 'Yes',
                'Sortlen' => 1));
    }


    function getTableColumnNames($table)
    {
        $fields = $this->db->query("show columns from $table")->result_array();
        return $fields;
    }


    function getTableKeys($table)
    {
        return $this->db->query("show keys from $table")->result_array();
    }


    function getColumnDetail($data)
    {
        $fld = array();
        $fld['field_name'] = $data[0];
        $type = $data[1];
        $fld['multi_set'] = array();
        $fld['scale'] = null;
        
        if (preg_match("/^(.+)\((\d+),(\d+)/", $type, $query_array))
        {
            $fld['datatype'] = $query_array[1];
            $fld['length'] = is_numeric($query_array[2]) ? $query_array[2] : '';
            $fld['scale'] = is_numeric($query_array[3]) ? $query_array[3] : '';
        } elseif (preg_match("/^(.+)\((\d+)/", $type, $query_array))
        {
            $fld['datatype'] = $query_array[1];
            $fld['length'] = is_numeric($query_array[2]) ? $query_array[2] : '';
        } elseif (preg_match("/^(enum|set)\((.*)\)$/i", $type, $query_array))
        {
            $fld['datatype'] = $query_array[1];
            $arr = explode(",", $query_array[2]);
            $fld['enums'] = $arr;
            foreach ($arr as $val)
            {
                $new_val = trim($val, "'");
                $new_val = trim($new_val, '"');
                $fld['multi_set'][] = array($new_val);
            }
            $zlen = max(array_map("strlen", $arr)) - 2; // PHP >= 4.0.6
            $fld['length'] = ($zlen > 0) ? $zlen : 1;
        } else
        {
            $fld['datatype'] = $type;
            $fld['length'] = '';
        }
        $fld['not_null'] = ($data[3] != 'YES');
        $fld['primary_key'] = ($data[4] == 'PRI');
        $fld['unique_key'] = ($data[3] == 'UNI');
        $fld['auto_increment'] = (strpos($data[6], 'auto_increment') !== false);
        $fld['binary'] = (strpos($type, 'blob') !== false || strpos($type, 'binary') !== false);
        $fld['unsigned'] = (strpos($type, 'unsigned') !== false);
        $fld['zerofill'] = (strpos($type, 'zerofill') !== false);
        if (!$fld['binary'])
        {
            $d = $data[5];
            if ($d != '' && $d != 'NULL')
            {
                $fld['has_default'] = true;
                $fld['default_value'] = $d;
            } else
            {
                $fld['has_default'] = false;
            }
        }
        $fld['ctype'] = $this->translateType($fld['datatype']);

        $fld['comment'] = $data[8];
        if(!$fld['scale']==null)
         {
        $fld['length']=$fld['length'].','.$fld['scale'];
         }
        return $fld;
    }


    function translateType($t)
    {
        switch (strtoupper($t))
        {
            case 'STRING':
            case 'CHAR':
            case 'VARCHAR':
            case 'TINYBLOB':
            case 'TINYTEXT':
            case 'ENUM':
            case 'SET':
                return 'C';
            case 'TEXT':
            case 'LONGTEXT':
            case 'MEDIUMTEXT':
                return 'X';
            case 'IMAGE':
            case 'LONGBLOB':
            case 'BLOB':
            case 'MEDIUMBLOB':
            case 'BINARY':
                return 'B';
            case 'YEAR':
            case 'DATE':
                return 'D';
            case 'TIME':
            case 'DATETIME':
            case 'TIMESTAMP':
                return 'T';
            case 'INT':
            case 'INTEGER':
            case 'BIGINT':
            case 'TINYINT':
            case 'MEDIUMINT':
            case 'SMALLINT':
                return 'I';
            default:
                return 'N';
        }
    }


    function adu()
    {
        $post = file_get_contents('php://input');
        $para_array = (array )json_decode($post);
        $optype = $para_array['optype'];

        if (($optype == 'NANX_TBL_DATA') || ($optype == 'NANX_SYS_CONFIG'))
        {
            $sqls = $this->data_adu($para_array);
        }

        if ($optype == 'NANX_TBL_STRU')
        {
            $sqls = $this->tb_structure_adu($para_array);
        }

        if ($optype == 'NANX_TBL_INDEX')
        {
            $sqls = $this->tb_index_adu($para_array);
        }


    }


    function data_adu($para)
    {
        $table = $para['table'];
        $a = $para['a'];
        $d = $para['d'];
        $u = $para['u'];


        $errs = array();
        for ($i = 0; $i < count($a); $i++)
        {
            $a_row = (array )$a[$i];
            unset($a_row['pid']);
            $this->db->insert($table, $a_row);
            $errmsg = $this->db->_error_message();
            $errno = $this->db->_error_number();
            if ($errno > 0)
            {
                array_push($errs, $errmsg);
            }
        }


        for ($i = 0; $i < count($d); $i++)
        {
            $d_row = (array )$d[$i];
            $this->db->delete($table, array('pid' => $d_row[0]));
            $errno = $this->db->_error_number();
            if ($errno > 0)
            {
            	  $errmsg = $this->db->_error_message();
                array_push($errs, $errmsg);
            }
        }

        for ($i = 0; $i < count($u); $i++)
        {
            $u_row = (array )$u[$i];
            $pid = $u_row['pid'];
            $this->db->where('pid', $pid);
            $this->db->update($table, $u_row);
            $errno = $this->db->_error_number();
            if ($errno > 0)
            {   
            	  $errmsg = $this->db->_error_message();
                array_push($errs, $errmsg);
            }
        }

        $msg=$this->lang->line('success_update_table_data'); 
        if (count($errs) > 0)
        {
            $msg = $errs;
        }

        $resp = array('success' => true, 'msg' => $msg);
        print json_encode($resp, JSON_UNESCAPED_UNICODE);
    }


    function tb_structure_adu($para)
    {

        $table = $para['table'];
        $cols_all = $this->getTableColInfo($table);
        
        
        $a = $para['a'];
        $d = $para['d'];
        $u = $para['u'];

        $errs = array();

        for ($i = 0; $i < count($a); $i++)
        {
            $a_row = (array )$a[$i];
            unset($a_row['pid']);
            $newcol = $a_row['field_name'];
            $newcol_datatype = $a_row['datatype'];
            if (array_key_exists('length', $a_row))
            {
                $newcol_len = $a_row['length'];
                $newcol_datatype = $newcol_datatype . '(' . $newcol_len . ')';
            }
            $alt_sql = "alter table $table add $newcol $newcol_datatype";
            $this->db->query($alt_sql);
            $errno = $this->db->_error_number();
            if ($errno > 0)
            {
            	  $errmsg = $this->db->_error_message();
                array_push($errs, $errmsg);
            }
        
        
        }
        
        for ($i = 0; $i < count($d); $i++)
        {
            $d_row = (array )$d[$i];
            $col_to_drop = $cols_all[$d_row[0]]['field_name'];
            $alt_sql = "alter table $table drop $col_to_drop";
            if(! ($col_to_drop=='pid'))
            {
             $this->db->query($alt_sql);
             $errno = $this->db->_error_number();
             if ($errno > 0)
             {  
             	$errmsg = $this->db->_error_message();
                array_push($errs, $errmsg);
             }
            }
        }

        for ($i = 0; $i < count($u); $i++)
        {
            $u_row = (array )$u[$i];
            $pid = $u_row['pid'];
            $col_orginal_name = $cols_all[$pid]['field_name'];
            $col_orginal_datatype = $cols_all[$pid]['datatype'];
            
            $col_orginal_len = '(' . $cols_all[$pid]['length'] . ')';
           
            $col_orginal_comment=" comment '". $cols_all[$pid]['comment']."'";
            
            
            
            
            $new_col_name = $col_orginal_name;
            $new_col_datatype = $col_orginal_datatype;
            $new_col_len = $col_orginal_len;

            $comment_string='';
            
            if (array_key_exists('field_name', $u_row))
            {
                $new_col_name = $u_row['field_name'];
            }


            if (array_key_exists('comment', $u_row))
            {
                $comment_string = " comment '".$u_row['comment']."'";
            }
            else
            {
            $comment_string=$col_orginal_comment;
            }




            if (array_key_exists('datatype', $u_row))
            {
                $new_col_datatype = $u_row['datatype'];
            }

            if (array_key_exists('length', $u_row))
            {
                $new_col_len = '(' . $u_row['length'] . ')';
            }

            $new_null = '';
            if (array_key_exists('not_null', $u_row))
            {
                $new_null = ($u_row['not_null'] == true) ? ' not null' : ' null';
            }
             
            if(!($col_orginal_name=='pid'))
            {
              
             if( in_array( $new_col_datatype , array('date','datetime'))) 
             {
              $new_col_len='';
             } 
              
             $alt_sql = "alter table $table change  $col_orginal_name    $new_col_name   $new_col_datatype $new_col_len  $new_null  $comment_string";
             $this->db->query($alt_sql);
             $errno = $this->db->_error_number();
             if ($errno > 0)
             { 
             	  $errmsg = $this->db->_error_message();
                array_push($errs, $errmsg);
             }
            }
        }
        
        $msg =$this->lang->line('rdbms_success');
        if (count($errs) > 0)
        {
            $msg = $errs;
        }

        $resp = array('success' => true, 'msg' => $msg,'alt_sql'=> $alt_sql );
        print json_encode($resp, JSON_UNESCAPED_UNICODE);
    }

    function tb_index_adu($para)
    {
        $table = $para['table'];
        $a = $para['a'];
        $d = $para['d'];
        $u = $para['u'];

      
        $errs = array();
        
        $indexs_info = $this->get_min_table_indexes($table);
        $all_indexs = $indexs_info['rows'];

      

        for ($i = 0; $i < count($u); $i++)
        {
            $update_info = (array )$u[$i];
            $pid_of_index = $update_info['pid'];
            
            if(array_key_exists ('columns',$update_info))
            {
            $columns = $update_info['columns'];
            }
            else
            {
            $columns = $all_indexs[$pid_of_index]->columns;
            }
            
            if(array_key_exists ('option',$update_info))
            {
            $option = $update_info['option'];
            }
            else
            {
            $option = $all_indexs[$pid_of_index]->option;
            }
            
            
            if(array_key_exists ('index',$update_info))
            {
            $index_name = $update_info['index'];
            }
            else
            {
            $index_name = $all_indexs[$pid_of_index]->index;
            }
            if($option=='(NULL)')
            {
            	$option='';
            }

            $fixed_update_info=array(
            'index' => $index_name,
            'columns'=> $columns,
            'option' => $option
            );
            array_push($d, $pid_of_index);
            array_push($a, $fixed_update_info);
        }
        
        for ($i = 0; $i < count($d); $i++)
        {
            $d_row = (array )$d[$i];
            $indexname_to_del = $all_indexs[$d_row[0]]->index;
            if($indexname_to_del=='PRIMARY')
             {
            $sql = "alter table $table   DROP PRIMARY KEY";
             }
             else
             {
            $sql = "alter table $table drop index $indexname_to_del";
             }
            $this->db->query($sql);
            $errno = $this->db->_error_number();
            if ($errno > 0)
            {   
              	$errmsg = $this->db->_error_message();
                array_push($errs, $errmsg);
            }
        }

        for ($i = 0; $i < count($a); $i++)
        {
            $a_row = (array )$a[$i];
            $indexname = (array_key_exists('index', $a_row)) ? $a_row['index'] : '';
            $option = (array_key_exists('option', $a_row)) ? $a_row['option'] : '';
            $columns = $a_row['columns'];
            $sql = "alter table $table add   $option index  $indexname ( $columns) ";
             
            
            $this->db->query($sql);
            $errno = $this->db->_error_number();
            if ($errno > 0)
            {   
              	$errmsg = $this->db->_error_message();
                array_push($errs, $errmsg);
            }
        }
        
         $msg=$this->lang->line('success_update_table_data');
        if (count($errs) > 0)
        {
            $msg = $errs;
        }

        $resp = array('success' => true, 'msg' => $msg);
        print json_encode($resp, JSON_UNESCAPED_UNICODE);
    }


    function exportTableData()
    {
        $params = (array )json_decode($_REQUEST['params']);
        $table = $params['nodevalue'];
        $cols = $params['selected_value'];
        $sql = "select  $cols  from  $table";
        $rows = $this->db->query($sql)->result_array();
        $this->load->model('MExcel');
        $this->MExcel->exportExcel($rows);

    }
    
    
     function tb_index_adu2($para)
    {
        $table = $para['table'];
        $a = $para['a'];
        $d = $para['d'];
        $u = $para['u'];
        $errs = array();
        $indexs_info = $this->get_min_table_indexes($table);
        $all_indexs = $indexs_info['rows'];

        for ($i = 0; $i < count($u); $i++)
        {
            $update_info = (array )$u[$i];
            $pids_of_index = $update_info['pid'];
            
            if(array_exists ('columns',$pids_of_index))
            {
            $columns = $pids_of_index['columns'];
            }
            else
            {
            $columns = $all_indexs[$d_row[0]]->columns;
            }
 
 
            if(array_exists ('option',$pids_of_index))
            {
            $option = $pids_of_index['option'];
            }
            
            
            $columns = $pids_of_index['columns'];
            array_push($d, $pid);
            array_push($a, $update_info);
        }
        
        
    
         

        for ($i = 0; $i < count($d); $i++)
        {
            $d_row = (array )$d[$i];
            $indexname_to_del = $all_indexs[$d_row[0]]->index;
            $sql = "alter table $table drop index $indexname_to_del";
            
            $this->db->query($sql);
            $errno = $this->db->_error_number();
            if ($errno > 0)
            {   
              	$errmsg = $this->db->_error_message();
                array_push($errs, $errmsg);
            }
          
        }

        for ($i = 0; $i < count($a); $i++)
        {
            $a_row = (array )$a[$i];
            $indexname = (array_key_exists('index', $a_row)) ? $a_row['index'] : '';
            $option = (array_key_exists('option', $a_row)) ? $a_row['option'] : '';
            $columns = $a_row['columns'];
            $sql = "alter table $table add   $option index  $indexname ( $columns) ";
            
          //  echo $sql;
            $this->db->query($sql);
            $errno = $this->db->_error_number();
            if ($errno > 0)
            {   
              	$errmsg = $this->db->_error_message();
                array_push($errs, $errmsg);
            }
        }
        
         $msg=$this->lang->line('success_update_table_data');
        if (count($errs) > 0)
        {
            $msg = $errs;
        }

        $resp = array('success' => true, 'msg' => $msg);
        print json_encode($resp, JSON_UNESCAPED_UNICODE);
    }
    
    function getTableFields($para)
    {
      $tb=$para['table'];
      $fields_e=$this->db->list_fields($tb);
      if (array_key_exists('cols_selected',$para)){
        if(  strlen($para['cols_selected'])>0){
           $fields_e = explode(",",$para['cols_selected']);
        }
      }
      $fds=array_flip($fields_e);
      return( array($fds));
    }

}

?>