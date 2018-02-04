<?php 
//require_once 'excel/Excel/reader.php';
class MExcel extends CI_Model
{
	function  exportExcel($colscfg_and_rows,$fname)
	{
	  
    
		$this->load->library('PHPExcel_lib');
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setLastModifiedBy("NaNx");
    $objPHPExcel->setActiveSheetIndex(0);
    $col_count=count($colscfg_and_rows[0]);
    $row_count=count($colscfg_and_rows);
    for($row=0;$row< $row_count;$row++)
    {
    	$line=array_values($colscfg_and_rows[$row]);
      for($col=0;$col< $col_count; $col++)
        {
         $objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col,$row+1,$line[$col],PHPExcel_Cell_DataType::TYPE_STRING);
        }
    }
     
     $objPHPExcel->getActiveSheet()->setTitle('data');
     $rendererName = PHPExcel_Settings::PDF_RENDERER_TCPDF;
     $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
    
     $this->load->model('MFile');
     $fname=$this->MFile->getFilename4OS($fname);
     if($this->MFile->checkWriteAble('tmp'))
      {
           try
           {
                @$objWriter->save('tmp/'.$fname.'.xls');
           }

           catch(Exception $e)
           {
              return array('success'=>false,'msg'=>$e->getMessage());
           }      
          return array('success'=>true,'msg'=>'successed');
      }

      else
      {
         return array('success'=>false,'msg'=>'tmp '.  $this->lang->line('write_file_failed'));
      }
  }
  
  function  excel2table($tablename,$fname, $success_msg)
  {
  	$sheet_data=$this->prepareSheetData($tablename,$fname);
    $rdbms_result= $this->createTablebySheet($sheet_data );
    $success=true;
    if($rdbms_result['sqlresult_code'] >0) 
    {
      $success=false;
    }
      $res = array(
       'success' =>  $success,
       'opcode' => 'create_table_from_excel',
       'msg' =>  $success_msg,
       'errmsg' => $rdbms_result['errmsg']
                ) ;
       echo json_encode($res);
  }
  
  function  createTablebySheet($sheet)
  {  
     $this->load->helper('my_pinyin'); 
  	 $field_display_cfg=array();
  	 $first_col_is_id=false;
  	 
  	 if($sheet['summary']['rows_total']>0)
  	  { 
  	  	$colstr='';
  	  	$tbname=$sheet['tbname'];
  	  	for($i=0;$i< count($sheet['col']);$i++)
  	  	{
  	  	 $cname=$sheet['col'][$i]['colname'];
  	  	 $colname=strtolower(pinyin($sheet['col'][$i]['colname']));
  	  	 if(($i==0)&&($colname=='id'))
  	  	 {
  	  	 	 $colstr.=' ';
  	  	   $first_col_is_id=true;
  	  	 }
  	  	 else
  	  	 {
  	  	  	 $colstr.= $colname.' char('.$sheet['col'][$i]['len'].'),';
  	  	 }	
  	  	 array_push($field_display_cfg,array('base_table' => $tbname,'field_e'=> $colname,'field_c'=> $cname));
  	  	}

  	    $col_lists="id int(11) NOT NULL AUTO_INCREMENT,".$colstr. " PRIMARY KEY (id)";
  	    $sql="create table  $tbname ( $col_lists ) ";
  	    $this->db->query($sql);
  	   
  	    $sqlresult_code = $this->db->_error_number();
        $errmsg = $this->db->_error_message();
  	  
  	  }
  
    for($i=1;$i<=count($sheet['data']);$i++)
    {
       if($first_col_is_id)
        {
       	$row=$sheet['data'][$i];
       	}
       else
       { 
       	$id=array( '0' => $i);
        $row=array_merge($id, $sheet['data'][$i]);
       }
        
       $insertsql='';
       for ($j=0;$j< count($row);$j++)
       {
         $insertsql.="'".$row[$j]."',";
       }
        $insertsql=rtrim($insertsql,',');
       
       $sql="insert into $tbname values( $insertsql ) ";
       $this->db->query($sql);       
    }
    
     for($i=0;$i<count($field_display_cfg);$i++)
     {
      $this->db->insert('nanx_activity_field_special_display_cfg',	 $field_display_cfg[$i]);
     }
      return array(
      	    'sqlresult_code'=> $sqlresult_code,
            'errmsg'=> $errmsg
      );   
     
  }
   
   function  prepareSheetData($tb_prefix,$fname)
  {
		   $this->load->library('PHPExcel_lib');
       $objPHPExcel = PHPExcel_IOFactory::load($fname);
       $index=0;  //get only the first sheet
       foreach ($objPHPExcel->getWorksheetIterator() as $first_sheet)
        {
        if($index==0){break;}
        $index++;
        }
       
       
       $rows_total=$first_sheet->getHighestRow();  
       $highestColumn=$first_sheet->getHighestColumn();  
       $cols_total=PHPExcel_Cell::columnIndexFromString($highestColumn);
       $tb_cols=array();
       $data=array();
       for ($row=1;$row<=$rows_total;$row++){
           for ($col=0;$col<$cols_total;$col++){
               $cell=$first_sheet->getCellByColumnAndRow($col,$row);
               $val = ''.$cell->getValue();
               if($row==1)
           	    {
           	      $tb_cols[$col]=	array('colname' => $val,'len'=> strlen($val));
           	  	}
           	  	else
           	  	{
           	      $data[$row-1][$col]=$val;
                  $current_len= $tb_cols[$col]['len'];
                  $val_len=strlen($val);
                  $tb_cols[$col]['len']=($val_len >$current_len)? $val_len : $current_len;
           	  	}
           }
        }
       $table_meta=array();
       $table_meta['tbname']=$tb_prefix;
       $table_meta['summary']=array('rows_total'=> $rows_total-1,'cols_total'=> $cols_total);
       $table_meta['col']=$tb_cols;
       $table_meta['data']=$data;
       return $table_meta; 
  }
  
  
  
}
?>