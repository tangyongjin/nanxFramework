<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Rdbms extends CI_Controller
{
   



   function get_table_creation_info_directshow()
    {
    

        $post = file_get_contents('php://input');
        $para_array = (array )json_decode($post);
        $this->load->model('MRdbms');

        $ret = $this->MRdbms->get_table_creation_info($para_array);
        echo json_encode($ret, JSON_UNESCAPED_UNICODE);
    


    }

 


    function get_min_table_indexes($table)
    {

        $this->load->model('MRdbms');
      //  $ret = $this->MRdbms->get_min_table_indexes($table);



        $output = new stdClass();
        $output->success = true;
        $output->primary_keys = array();

        $cols4index = array();
        $table_columns = $this->getTableColumnNames($table);
        foreach ($table_columns as $column)
        {
            $cols4index[] = $column;
        }

        $rows =  $this->MRdbms->getTableKeys($table);
        $indexes = array();
        for ($i = 0; $i < count($rows); $i++)
        {

            if (strtolower($rows[$i]['Key_name']) == 'primary')
            {
                $output->primary_keys[] = $rows[$i]['Column_name'];
            }

            $index = $this->MRdbms->index_with_key($rows[$i]['Key_name'], $indexes);
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
            $response['rows'][$j]->id = $j;
        }


        $response['cols4index'] = $cols4index;
        $response['success'] = true;
        $response[0] = array(
            'id' => 'id',
            'index' => 'index',
            'columns' => 'columns',
            'add_column' => 'add_column',
            'option' => 'option');
        return $response;
    }



       function getTableColumnNames($table)
    {
        $fields = $this->db->query("show columns from $table")->result_array();
        return $fields;
    }

 function get_min_table_indexes_directshow()
    {
        $post = file_get_contents('php://input');
        $para_array = (array )json_decode($post);
        $table = $para_array['table'];

        $this->load->model('MRdbms');
        $ret = $this->MRdbms->get_min_table_indexes($table);
        echo json_encode($ret, JSON_UNESCAPED_UNICODE);
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
            unset($a_row['id']);
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
            $this->db->delete($table, array('id' => $d_row[0]));
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
            $id = $u_row['id'];
            $this->db->where('id', $id);
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
        $this->load->model('MRdbms');
        $cols_all = $this->MRdbms->getTableColInfo($table);
        $a = $para['a'];
        $d = $para['d'];
        $u = $para['u'];

        $errs = array();

        for ($i = 0; $i < count($a); $i++)
        {
            $a_row = (array )$a[$i];
            unset($a_row['id']);
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
            if(! ($col_to_drop=='id'))
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
            $id = $u_row['id'];
            $col_orginal_name = $cols_all[$id]['field_name'];
            $col_orginal_datatype = $cols_all[$id]['datatype'];
            $col_orginal_len = '(' . $cols_all[$id]['length'] . ')';
            $col_orginal_comment=" comment '". $cols_all[$id]['comment']."'";
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
             
            if(!($col_orginal_name=='id'))
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
            $id_of_index = $update_info['id'];
            
            if(array_key_exists ('columns',$update_info))
            {
            $columns = $update_info['columns'];
            }
            else
            {
            $columns = $all_indexs[$id_of_index]->columns;
            }
            
            if(array_key_exists ('option',$update_info))
            {
            $option = $update_info['option'];
            }
            else
            {
            $option = $all_indexs[$id_of_index]->option;
            }
            
            
            if(array_key_exists ('index',$update_info))
            {
            $index_name = $update_info['index'];
            }
            else
            {
            $index_name = $all_indexs[$id_of_index]->index;
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
            array_push($d, $id_of_index);
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
     
    
     
 


 }

?>