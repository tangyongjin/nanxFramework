<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Log extends CI_Controller
{
     

    function showlog(){

    	$this->load->helper('file');

		$jstr = '<script src="http://47.92.72.19:8080/jslib/jquery/jquery-1.7.1.min.js" type="text/javascript" charset="utf-8"></script>';
		$jstr .= '<script src="http://47.92.72.19:8080/js/log.js" type="text/javascript" charset="utf-8"></script>';
		$css  = "http://47.92.72.19:8080/css/log.css";
		$css_str = "<link rel='stylesheet' href=$css> ";
		echo '<html><head><meta http-equiv="content-type" content="text/html;charset=utf-8">' . $jstr . $css_str . '</head>';
		echo "<div>";        
		echo "<input onclick=clear_log() type=button value=Clear_log name=Hide_Input>";
		echo "</div>";
        $logfile=helper_getlogname();
		echo "<h2>Docker:logfile=$logfile </h2>";
		echo "<br/>";
		$string = read_file( helper_getlogname()  );
        echo  "<pre>" .$string."</pre>";
        echo "</html>";
    }


     public function clearlog(){
         file_put_contents( helper_getlogname(),'');
     }
     
      public function test(){
      	 echo "111" ;
      	 echo helper_getlogname();
     }
     

      
    
    
}
?>
