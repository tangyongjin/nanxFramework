<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Dataproxy extends CI_Controller
{

    function index()
    {
        
        $post = file_get_contents('php://input');
        $para_array = (array )json_decode($post);
      
        $getDataUrl=$para_array['getDataUrl'];
        $result=$this->callerIncaller($getDataUrl,$para_array);
        
        return $result;
    }


    function  callerIncaller($url,$para)
    { 
         $model_and_function = explode("/", $url);
         $model=$model_and_function[0];
         $function=$model_and_function[1];
         $this->load->model($model);
         $result=$this->$model->$function($para);
         return $result;
    }

     
}
?>