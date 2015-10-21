<?php
/*------------------------------------------
/ Author   :
/ DateTime :2012-09-24
/ Desc     :Order Controller 执行订单的查询、明细的查询
------------------------------------------*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dbl_cmd extends CI_Controller {
	 
	 function index()
	 {
	 $command = $_REQUEST['command'];
	 
	 if($command=='treeProcess')
	   {
	   	$this->treeProcess( $_REQUEST );
	   }
	   
	 if($command=='dbProcess')
	   {
	   	$this->dbProcess( $_REQUEST );
	   }
  		
	  if($command=='user.retrieve_user_activity')
	   {
	   echo '{"id":"0","data":{"success":true,"data":{"explorerWidth":250,"explorerMinWidth":200,"datapanelHeight":200,"datapanelMinHeight":200,"datapanelActiveTab":0,"activeConnTab":0,"activeDbTab":0,"activeTableTab":0},"history_data":""}}';
	   
	   }
	 
	 if($command=='get_db_tables')
     {
     $sql=$this->sqlBuilder();	
     echo  '{"id":"0","data":{"success":true,"data":{"success":true,"columns":["Table_Name","category"],"result":[["old_man","table"],["oss_boss","table"],["oss_client","table"],["oss_fault_type","table"],["oss_ipmanager","table"],["oss_network_log","table"],["oss_pay_cycle_code","table"],["oss_resource","table"],["oss_sale_contract","table"],["oss_sale_contract_biz","table"],["oss_sale_income_bill","table"],["oss_sms","table"],["oss_sms_phone","table"],["oss_ywtz233","table"],["outbox","table"]]},
    "history_data":["2013-02-15 15:22:27","0 ms","show columns from `k666`.`city`","k666","success"]}}';
     
     }	 
	 
	 }
	 
	 
	 	function treeProcess()
   {   
  	$command = $_REQUEST['command'];
  	if($command=='user.retrieve_user_activity')
  	{
  	echo '
  	{"id":"0","data":{"success":true,"data":{"explorerWidth":250,"explorerMinWidth":200,"datapanelHeight":200,"datapanelMinHeight":200,"datapanelActiveTab":0,"activeConnTab":0,"activeDbTab":0,"activeTableTab":0},"history_data":""}}
  	';
  	}	
	 
	 
	 if($command=='connection.get_connections')
  	{
  	echo '
  	{"id":"0","data":{"success":true,"data":[["localhost222",null,null,null,"",null,null,null]],"history_data":""}}
  	';
  	}	
	 
	 echo  '{"id":"0","data":{"success":true,"data":{"success":true,"columns":["Table_Name","category"],"result":[["old_man","table"],["oss_boss","table"],["oss_client","table"],["oss_fault_type","table"],["oss_ipmanager","table"],["oss_network_log","table"],["oss_pay_cycle_code","table"],["oss_resource","table"],["oss_sale_contract","table"],["oss_sale_contract_biz","table"],["oss_sale_income_bill","table"],["oss_sms","table"],["oss_sms_phone","table"],["oss_ywtz233","table"],["outbox","table"]]},
    "history_data":["2013-02-15 15:22:27","0 ms","show columns from `k666`.`city`","k666","success"]}}';
	 
	  
	 
	 
	 
	 
	 
	 
	 }
	 
	  function sqlBuilder()
	  {
	   $sql="select TABLE_NAME As Table_Name,'table' as category from 'information_schema'.'TABLES' where TABLE_SCHEMA = '" . 'oss'. "' and TABLE_TYPE = 'BASE TABLE'  and TABLE_NAME like 'o%'  ";
	   return  $sql;
	  }
}
?>
