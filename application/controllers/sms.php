<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms extends CI_Controller {
    
    function getSms() 
    {
       $post= (array )json_decode(file_get_contents('php://input'));
       $para=(array)$post;
       $id=$para['id'];
       $this->db->where('id',$id);
       $msgs=$this->db->get('nanx_sms')->result_array();
       $msg=$msgs[0];
       echo json_encode($msg);
    }
    
     
    
}
?>