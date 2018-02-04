<?php

if ( ! defined('BASEPATH'))
{
	exit('No direct script access allowed');
}

class Plugin_runner extends CI_Controller {

    function save_request(){

         $post = file_get_contents('php://input');
         $p = (array) json_decode($post);
       
         $form=$p['form'];
         $data=$p['rows'];
         $invoice_num=$form->invoice_num; 
         $detail_table=$form->base_table;
         $master_table=str_replace('_detail', '', $detail_table);  
         $ret=array();

         $master_row = $this->db->get_where( $master_table, array('invoice_num' => $invoice_num))->row_array();
         if(  count($master_row) ==0 ){
              $ret['error_code']=-1;
              $ret['error_message']='单据号不存在';
              
              $json = json_encode($ret, JSON_UNESCAPED_UNICODE);

              $json_fixed = str_replace("null", "''", $json);
              echo $json_fixed;
              return false;
         }
         else
         {
            $input_date=$master_row['input_date'];
            foreach ($data as $key => $one_row_obj) {
                   $one_row=(array)$one_row_obj;
                   $id=$one_row['id'];
                   $invoice_num=$invoice_num;
                   $unix=$one_row['unix'];
                   $unit_price=$one_row['unit_price'];
                   $prod_code=$one_row['prod_code'];
                   $this_used=$one_row['this_used'];
                      
                
                   $sql=" update standx_in_log_detail set  used_num=used_num+$this_used  where id=$id  " ;
                   $this->db->query($sql);
                   $sql=" update standx_in_log_detail set  left_num=input_num - used_num  where id=$id  " ;
                   $this->db->query($sql);


                   $detail_data=array(
                   'invoice_num'=>$invoice_num,
                   'prod_code'=>$prod_code,
                   'unit_price'=>$unit_price,
                   'unix'=>$unix,
                   'input_num'=>$this_used,
                   'total_price'=>$unit_price*$this_used,
                   'input_date'=>$input_date,
                   'ref_id'=>$id
                   );

                   if($this_used>0){
                     $this->db->insert($detail_table,$detail_data);
                   }
                    

              }

              $sql="select sum(input_num*unit_price) as total_price from $detail_table where invoice_num='$invoice_num' ";
              $row=$this->db->query($sql)->row_array() ;
              $total_price=$row['total_price'];

              $sql=" update $master_table set total_price=$total_price where  invoice_num='$invoice_num' ";
              
              $this->db->query($sql) ;

              $ret['error_code']=0;
              $json = json_encode($ret, JSON_UNESCAPED_UNICODE);
              $json_fixed = str_replace("null", "''", $json);
              echo $json_fixed;
          }
         

    }

    function get_sql($prod_code){

         $sql=" update standx_in_log_detail set left_num=input_num - used_num" ;
         $this->db->query($sql) ;

         $sql  = "select standx_in_log_detail.id,standx_prod_list.prod_code,prod_name ,unit_price,unix,input_num,used_num,left_num, 0  as this_used from  standx_prod_list, standx_in_log_detail ";
         $sql  .= " where standx_in_log_detail.prod_code='$prod_code'    ";
         $sql .="  and standx_prod_list.prod_code=standx_in_log_detail.prod_code   and input_num - used_num >0 order by standx_in_log_detail.id";
        
         return $sql;
    }

	function list_inventory()
	{

		$post = file_get_contents('php://input');
		 $p = (array) json_decode($post);
		 $prod_code = $p['prod_code'];
		 $sql=$this->get_sql($prod_code);

         $rows=$this->db->query($sql)->result_array();

		 $total = count($rows);

		$result['rows'] = $rows;
		$result['total'] = $total;

		$json = json_encode($result, JSON_UNESCAPED_UNICODE);

		$json_fixed = str_replace("null", "''", $json);
		echo $json_fixed;

	}

	function fill_request()
	{

		$post = file_get_contents('php://input');
		$p = (array) json_decode($post);
		 
		$prod_code = $p['prod_code'];
		$num_ask =intval( $p['input_num']);
        
        if(strlen($prod_code)==0){
         $error_code=-1;
         return ;

        }
        else
        {
          $error_code=0;    
        }

 
       

        $sql=$this->get_sql($prod_code);

   
       $rows=$this->db->query($sql)->result_array();
       $rows_counter=count($rows);
      

       $num_filled=0;
       $counter=0;

        for ($counter=0; $counter <$rows_counter ; $counter++) { 

           $num_filled=$num_filled+$rows[$counter]['left_num'];

           $rows[$counter]['this_used']=$rows[$counter]['left_num'];
           $rows[$counter]['left_num']= 0;
           
           if($num_filled>=$num_ask){
            $gap=$num_filled - $num_ask ;
            $rows[$counter]['left_num']=$gap;
            $rows[$counter]['this_used']= $rows[$counter]['this_used'] - $gap;
            break;  
            }
        }


         $total = count($rows);

        $result['rows'] = $rows;
        $result['total'] = $total;

        $json = json_encode($result, JSON_UNESCAPED_UNICODE);

        $json_fixed = str_replace("null", "''", $json);
        echo $json_fixed;

         
           
     }
        

 }

 

?>