<?php
 
class MRdbms extends CI_Model

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



    function check_filed_is_number_type($table,$field){
      $fields = $this->MRdbms->getTableColInfo($table);
      
      $found=-1;
      foreach ($fields as $key => $one_field) {
          if( $one_field['field_name']== $field ){
             $found=$key;
          }
      }
      $datatype= $fields[$found]['datatype'];
      $number_types=array('int','tinyint','smallint','mediumint','bigint','float','double','decimal');
      if( in_array($datatype, $number_types)  ){
        return true;
      }else
      {
        return false;
      }
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