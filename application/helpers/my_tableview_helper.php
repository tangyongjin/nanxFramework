<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function tableview2($dbresult,$map,$urlcfg=array(),$width=null)
{
	
$CI_obj=&get_instance();
$tbl_heading=array_values($map);
$field_list=array_keys($map);

if(isset($urlcfg))
{
$url_keys=array_keys($urlcfg);
}
else
  {
	$url_keys=null;
	}



if(isset($width))
 {
 }
else
  {
	$width='955px';
	}



if( count($url_keys)==0){	$url_keys=array();}
$tmpl = array (
      'table_open' => '<table  class=thin width='.$width. ' border="1" cellpadding="3" cellspacing="0">',
      'heading_row_start' => '<tr>',
      'row_start' => '<tr bgcolor="#EFEDDD">');
      $CI_obj->table->set_template($tmpl); 
      $CI_obj->table->set_empty("&nbsp;");
      $CI_obj->table->set_heading($tbl_heading);
      
 //对每条数据库记录,按照$field_list中出现的列名，取值
while(list($rowindex,$one_db_row)=each($dbresult))
{
	
		  $table_row = array();
	    $table_row = NULL;
        reset($field_list);

while(list($kindex,$kname)=each($field_list))
{
	      if (in_array($kname,$url_keys))
        {
        	
        	if( is_array($urlcfg[$kname]))
        	  {
        	  
        	  if (strlen($one_db_row[$kname])==0) 
        	  {
        	  	$table_row[] = anchor($urlcfg[$kname][0].'/'.$one_db_row[$urlcfg[$kname][1]],$urlcfg[$kname][2]);
        		}
        	  else
        	  {
        	  	$table_row[] = anchor($urlcfg[$kname][0].'/'.$one_db_row[$urlcfg[$kname][1]],$one_db_row[$kname]);
        	  	
        	  	
        	  	}
        		}
        	else
        	  {$table_row[] = anchor($urlcfg[$kname].'/'.$one_db_row[$kname],$one_db_row[$kname]);}
        }
        else
        {
        $table_row[] =$one_db_row[$kname];
        }
}     
       $CI_obj->table->add_row($table_row);
}

  $html_table = $CI_obj->table->generate();
  echo $html_table;
}
?>