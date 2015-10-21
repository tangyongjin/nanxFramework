<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class grid2excel extends CI_Controller {
	 
   
   function tbl2excel()
   {
   	$post = file_get_contents('php://input');
    $para_array = (array)json_decode($post);
   	$tbname=$para_array['tbname'];
   	$rows=$this->db->get($tbname)->result_array();
    $fields =array( $this->db->list_fields($tbname));
    $res=array_merge($fields,$rows);
    $this->load->model('MExcel');
    $this->MExcel->exportExcel($res,$tbname);
   }
   
   
   function readExcel()
{   
	  echo "<html>";
	  echo '<meta http-equiv="content-type" content="text/html; charset=utf-8" />';
		$this->load->library('PHPExcel_lib');
    $objPHPExcel = PHPExcel_IOFactory::load("uploads/abc.xls");
    foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
    $rows_total         = $worksheet->getHighestRow(); // e.g. 10
     
    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
    $cols_total = PHPExcel_Cell::columnIndexFromString($highestColumn);
    
    echo "rows total.".$rows_total;
    echo "cosl total.".$cols_total;
    $tb_cols=array();
    echo '<table>';
    for ($row = 1; $row <= $rows_total; ++ $row) {
        echo '<tr>';
        for ($col = 0; $col < $cols_total; ++ $col) {
            $cell = $worksheet->getCellByColumnAndRow($col, $row);
            $val = ''.$cell->getValue();
            if($row==1)
        	    {
        	    $tb_cols[]=	array('colname' => $val,'len'=> strlen($val));
        	  	}
        	  	else
        	  	{
           // $tb_cols[$col]['val'] =$val;
            $current_len= $tb_cols[$col]['len'];
            $val_len=strlen($val);
            $tb_cols[$col]['len']=($val_len >$current_len)? $val_len : $current_len;
        	  	}
                   //     debug($tb_cols);       	  
            echo '<td>'.$val.'</td>';
        }
        echo '</tr>';
     }
    echo '</table>';
    }
    echo "</html>";
  //  debug($tb_cols);
    $cols=array_retrieve($tb_cols,'colname');
  //  debug($cols);
 }   
}
?>
