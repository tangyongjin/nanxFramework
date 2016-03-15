<?php 


class MInventory extends CI_Model{

    
 
    function docu(){
        echo 'called' ;
        
    }

    function check_if_can_input_log(){
        echo 'called' ;
        
    }

   function  check_foreign_key($para){
     
     $table=$para['table'] ;
     $master_table=str_replace('_detail', '', $table);  
     $data=(array)$para['rawdata'];
     $invoice_num=$data['invoice_num'];

     $rows = $this->db->get_where($master_table, array('invoice_num' => $invoice_num))->result_array();
     

     if(  count($rows) ==0 ){
          return false;
     }
     else
     {
          return true;
     }
   }



  function  calc_inventory(){

 

//   cakestore2_dept_return_log_detail |
// | cakestore2_direct_log_detail      |
// | cakestore2_in_log_detail          |
// | cakestore2_lost_log_detail        |
// | cakestore2_out_log_detail         |
// | cakestore2_retrun_out_log_detail 


   $sql="delete from  cakestore2_inventory_tmp" ;
   $this->db->query($sql) ;

   
     

 
  //+ add
   $sql=" insert into cakestore2_inventory_tmp ( vendor_code,prod_code,unit_price,unix,num_left,total_price) ";
   $sql.="  select    vendor_code,prod_code,unit_price,unix,sum(input_num),sum(total_price)  from cakestore2_in_log_detail group by  vendor_code, prod_code,unit_price,unix";
   $this->db->query($sql) ;


   $sql=" insert into cakestore2_inventory_tmp ( vendor_code,prod_code,unit_price,unix,num_left,total_price) ";
   $sql.="  select  vendor_code,  prod_code,unit_price,unix,sum(input_num),sum(total_price)  from cakestore2_dept_return_log_detail group by  vendor_code,prod_code,unit_price,unix";
   $this->db->query($sql) ;


    




   //- del 
   $sql=" insert into cakestore2_inventory_tmp ( vendor_code,prod_code,unit_price,unix,num_left,total_price) " ;
   $sql.="  select    vendor_code,prod_code,unit_price,unix,-sum(input_num),-sum(total_price)  from cakestore2_out_log_detail group by  vendor_code, prod_code,unit_price,unix";
   $this->db->query($sql) ;

   $sql=" insert into cakestore2_inventory_tmp ( vendor_code,prod_code,unit_price,unix,num_left,total_price) " ;
   $sql.="  select   vendor_code, prod_code,unit_price,unix,-sum(input_num),-sum(total_price)  from cakestore2_lost_log_detail group by  vendor_code,prod_code,unit_price,unix";
   $this->db->query($sql) ;

   $sql=" insert into cakestore2_inventory_tmp ( vendor_code,prod_code,unit_price,unix,num_left,total_price) " ;
   $sql.="  select    vendor_code,prod_code,unit_price,unix,-sum(input_num),-sum(total_price)  from cakestore2_retrun_out_log_detail group by  vendor_code,prod_code,unit_price,unix";
   $this->db->query($sql) ;








   $sql="delete from  cakestore2_inventory" ;
   $this->db->query($sql) ;

   $sql=" insert into cakestore2_inventory ( vendor_code,prod_code,unit_price,unix,num_left,total_price) " ;
   $sql.=" select   vendor_code,prod_code,unit_price,unix,sum(num_left),sum(total_price) from cakestore2_inventory_tmp group by  vendor_code, prod_code,unit_price,unix";
    
   $this->db->query($sql) ;

   echo "库存计算完毕" ;

  }

   

   function update_master_table($para){
                
     $table=$para['table'] ;
     $master_table=str_replace('_detail', '', $table);  
      
     $sql="update $table set total_price=unit_price*input_num ;";
     $this->db->query($sql);

     $sql="update $master_table set total_price=0 ;";
     $this->db->query($sql);

  
     $sql="select invoice_num,sum(total_price) as total_price from $table group by  invoice_num;" ;
     

     $rows=$this->db->query($sql)->result_array();
     foreach ($rows  as $one) {
             $this->db->where('invoice_num', $one['invoice_num']);
             $this->db->update($master_table, $one); 
     }

   }

    function add_inventory($para)
    {
        

        //debug($para);

        if( array_key_exists('rawdata', $para)  )
        {
     
        $data=(array)$para['rawdata'];

        }
         else
            {

         $data=$para;
            }




        $prod_code=$data['prod_code'];
        $unit_price=$data['unit_price'];
        
        $query = $this->db->get_where('cakestore2_inventory', array('prod_code'=>$prod_code, 'unit_price' => $unit_price)); 
        $rows=$query->result_array();
        if(  count($rows)==0 ){

            $data['num_left']=$data['input_num'];
            unset($data['input_num']);
            unset($data['input_date']);
            unset($data['invoice_num']);
            unset($data['vendor_code']);
            $data['total_price']=$data['num_left']*$data['unit_price'];
            
            $this->db->insert('cakestore2_inventory',$data); 

        }
        else
        {   

            $input_num=$data['input_num'];
            $unit_price=$data['unit_price'];
            $prod_code=$data['prod_code'];
            $total_price=$input_num*$unit_price;
            $sql="  update cakestore2_inventory set   num_left=num_left+$input_num,total_price=total_price+ $total_price ";
            $sql.=" where prod_code='$prod_code' and  unit_price=$unit_price ";
  //          echo $sql;
            $this->db->query($sql) ;
        }
    }


   function  delete_inventory($data)
    {
 
        if( array_key_exists('rawdata', $data)){
          $data=(array)$data['rawdata'];
        }
    
        $input_num=$data['input_num'];
        $unit_price=$data['unit_price'];
        $prod_code=$data['prod_code'];
        $total_price=$input_num*$unit_price;
        $sql="  update cakestore2_inventory set   num_left=num_left - $input_num,total_price=total_price -  $total_price ";
        $sql.=" where prod_code='$prod_code' and  unit_price=$unit_price ";
        $this->db->query($sql) ;
      }
     
    }




?>
