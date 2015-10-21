<?php 
class MSession extends CI_Model
{

 function getCurrentUser()
 {
  $s=$this->session->all_userdata();
  $user=$s['user'];
  return $user;
 }

 function sessionLog()
 {
  
 }
 
}
?>
