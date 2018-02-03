<?php

class ACL 
{
    private $url_model; 
    private $url_method; 
    private $url_param; 
    private $CI;
    
    function check_login()
    {

      $user = $this->CI->session->userdata('user');
      $eid= $this->CI->session->userdata('eid');
    
      if (empty($user)){return false;} 
      if (empty($eid)){return false;} 
      $CI=&get_instance();
      $this_eid=$CI->config->item('eidfolder');
      if($eid==$this_eid){return true;}else{return false;}
      return false;
    }
    
    function filter()
    {
 
    	  $this->CI = & get_instance();
        $url = $_SERVER['REQUEST_URI'];
        $arr = explode('/', $url);


        
        $arr = array_slice($arr, array_search('index.php', $arr) + 1, count($arr));
        $this->url_model = isset($arr[0]) ? $arr[0] : '';
        $this->url_method = isset($arr[1]) ? $arr[1] : 'index';
        $this->url_param = isset($arr[2]) ? $arr[2] : '';

        // debug($_SERVER['REQUEST_URI']);
        // print_r($url);
        // print_r($arr);die;


        if(in_array($this->url_method,array('logger','login','dologin','logout')))
        {  
          return;
        }
        
        $is_login= $this->check_login();

        if(!$is_login) 
        { 
            $CI=&get_instance();
        	  $bs_url=$CI->config->item('base_url');
            redirect('home/login');

            // header("Location:{$bs_url}home/login");
          }
         else 
        {
          return;
        }
    }
}
?>
