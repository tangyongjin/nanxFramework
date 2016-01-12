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
        $url = $_SERVER['PHP_SELF'];
        $arr = explode('/', $url);
        $arr = array_slice($arr, array_search('index.php', $arr) + 1, count($arr));
        $this->url_model = isset($arr[0]) ? $arr[0] : '';
        $this->url_method = isset($arr[1]) ? $arr[1] : 'index';
        $this->url_param = isset($arr[2]) ? $arr[2] : '';
 
        if(in_array($this->url_method,array('logger','login','ie6issue','dologin','logout')))
        {  
          return;
        }
        
        $is_login= $this->check_login();

        if(!$is_login) 
        { 
            $CI=&get_instance();
        	  $bs_url=$CI->config->item('base_url');
            $using_ie6 = (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.') !== FALSE);
            if($using_ie6)
             {
        	  header("Location:$bs_url/index.php/home/ie6issue");
             }
             else
        	   {
        	   header("Location:$bs_url/index.php/home/login");
        	  }
        }
         else 
        {
          return;
        }
    }
}
?>
