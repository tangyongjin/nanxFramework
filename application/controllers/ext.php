<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author:Tang
filename:ext.php
Class:Ext
Desc:从数据库的表格,取得字段,生成Extjs需要的column,filed等
得到诸如:
columns:
[
 new Ext.grid.RowNumberer(), 
{dataIndex:'id',hidden:true},
{dataIndex:'x',header:'x',width:55},
{dataIndex:'name',header:'name',width:55},
{dataIndex:'age',header:'age',width:55},
{dataIndex:'sex',header:'sex',width:55}
]

目前header与column名字相同，都是英文字段名，
下步:添加一个所有字段的列表，根据字段名，取得中文表头名

*/

class Ext extends CI_Controller {

	function get_columns($table_name){

  $fields = $this->db->list_fields($table_name);

  $column_start=<<<EOH
  columns:<br/>[<br/>&nbsp;new Ext.grid.RowNumberer(), 
				    <br/>{dataIndex:'id',hidden:true},
EOH;
						
  $out_orignial=<<<EOH
  		 {dataIndex:'\$field',header:'\$field',width:55},
EOH;
  		
  $fields_out='';		
      foreach ($fields as $field)
      {
        $out= $out_orignial;
        $out=str_replace('$field',$field,$out);
        $fields_out.=$out."";
      }
  $fields_out= $column_start.$fields_out.']';
  //替换最后一个 "}," 去掉","
  $fields_out=  str_replace("},]",'}]',$fields_out);
  $fields_out=  str_replace("},",  '},<br/>', $fields_out);
  $fields_out=  str_replace("]",'<br/>]',$fields_out);
  
   
  
  echo $fields_out; 
	}
	 
	function test(){
$tables = $this->db->list_tables();
foreach ($tables as $table)
{
   echo "<br/>表格名字:".$table."<br/>";
   $this->get_columns($table);
	
}

	 }
}
?>