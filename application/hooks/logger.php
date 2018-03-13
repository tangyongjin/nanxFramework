<?php

class Logger
{
    
     
 
    private $url_model;
    private $url_method;
    private $url_param;
    private $app_config;
   
  
    
    public function __construct() {
        
        require_once "/var/www/html/application/helpers/my_logger_helper.php";
       
    }

    function mlog()
    {
        
     
        $url              = $_SERVER['PHP_SELF'];
        $arr              = explode('/', $url);
        $arr              = array_slice($arr, array_search('index.php', $arr) + 1, count($arr));
        $this->url_model  = isset($arr[0]) ? $arr[0] : '';
        $this->url_method = isset($arr[1]) ? $arr[1] : 'index';
        $this->url_param  = isset($arr[2]) ? $arr[2] : '';
        
        if (strpos($_SERVER['REQUEST_URI'], 'showlog') > -1) {
            return false;
        }
        
        $post = file_get_contents('php://input');
        write_log($_SERVER['REQUEST_URI'], $post);
    }
    
    
 



}

?>
