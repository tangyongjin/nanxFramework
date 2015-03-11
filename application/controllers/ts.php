<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Ts extends CI_Controller
{
    function   sendsms()
    {
    
     
    
    $x=array(
        'code'=>10,
        'ms1g'=>'msg show');

    echo  json_encode($x);

  
    }
    
     
     
    
     
    

    
    
}
?>
