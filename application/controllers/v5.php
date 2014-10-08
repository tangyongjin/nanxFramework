<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class V5 extends CI_Controller
{
    
    function cb()
    {
    $sql="select * from nanx_user ";
    echo $sql;
    $users=$this->db->query($sql)->result_array();
   // debug($users);     
    $uids=array_map(function($one){return $one['staff_name'];}    , $users);
   // debug($uids);


  //  $uids=array_walk($users, function(&$value,$key){ $value['staff_name']='cc';  });
  //  debug($users);


    $uids=array_walk($users, function(&$value,$key){ echo $key; debug($value); });
    debug($users);



    }

}

?>