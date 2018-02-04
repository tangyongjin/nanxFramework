<?php
 
 
 
 function getargs(){

     // $post    = file_get_contents('php://input');
     // $p       = (array) json_decode($post);
     
     // debug($_POST);

     // return $p;

 } 

 
 
 function sysdatetime()
 {
  date_default_timezone_set("Asia/Chongqing");
  $cur= date("Y-m-d H:i:s", time()); 
  return $cur;
 }
 
 function sysdate()
 {
 	date_default_timezone_set("Asia/Chongqing");
  $cur= date("Y-m-d", time()); 
  return $cur;
 }
 
 function sysdate_format($format)
 {
 	date_default_timezone_set("Asia/Chongqing");
  $cur= date($format, time()); 
  return $cur;
 }
 
?>