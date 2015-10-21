<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms extends CI_Controller {
    
    function getSms() 
    {
       $post= (array )json_decode(file_get_contents('php://input'));
       $para=(array)$post;
       $pid=$para['pid'];
       $this->db->where('pid',$pid);
       $msgs=$this->db->get('nanx_sms')->result_array();
       $msg=$msgs[0];
      // debug($msg);
        echo json_encode($msg);
    }
    
     
    
}
?>
