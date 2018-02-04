<?php
class Testrunner extends CI_Controller
{


    public function __construct()
    {
        
        
        require_once  FCPATH. "application/controllers/testrunner.cfg.php";
      
        $this->controllers=$controllers;

        parent::__construct();
    }
    


   public function debug($x)
   {

     error_reporting(E_ALL);
     ini_set('display_errors', 1);
    
    
    echo "<pre>";
    print_r($x);
    echo "</pre>";
    
   }
   
    function get_php_source_code()
    {   

        $post=$this->input->post();

        
        $fname=$post['err_file'];
        $no=$post['err_line'];

        $this->load->helper('file');
        $string = htmlspecialchars(read_file($fname ));
        $good='<script id="php_source"   type="syntaxhighlighter" class="brush: php;collapse:false;highlight:['.$no.']"><![CDATA['.$string.' ]]></script>';
        echo $good;





    }

    function tail($filename, $lines, $buffer)
    { 
 
    $f = fopen($filename, "rb");
    fseek($f, -1, SEEK_END);
    if(fread($f, 1) != "\n") $lines -= 1;

    $output = '';
    $chunk = '';
    $last=''; 

    while(ftell($f) > 0 && $lines >= 0)
    {
        $seek = min(ftell($f), $buffer);
        fseek($f, -$seek, SEEK_CUR);
        $output = ($chunk = fread($f, $seek)).$output;
        fseek($f, -mb_strlen($chunk, '8bit'), SEEK_CUR);
        $lines -= substr_count($chunk, "\n");
    }

    while($lines++ < 0)
    {
        $output = substr($output, strpos($output, "\n") + 1);
    }

    fclose($f); 
    return $output; 
}


    public function  last_php_err()
    { 
        $php_log_file='/var/log/php_errors.log';
        $log=$this->tail($php_log_file,3,4096);
        $log2=nl2br($log);
        $log2=$log;
        
        $lines=  preg_split('/\n|\r\n?/', $log2);
        
        $err_line=0;
        $err_file='';
        if  (  count($lines) >=2 )
        {
           $last_err=$lines[ count($lines) -2];
           if(strlen($last_err) >=30 ){
              @$items=split(' ',$last_err);
              $counter=count($items);
              $err_line=$items[ $counter -1 ];
              $err_file=$items[ $counter -4 ];
           }
        }
        
        $ret=array(
          'err_line'=>$err_line,
          'err_file'=>$err_file,
          'content' =>nl2br($log2)
          );
      jsonoutput($ret);
     
     }



     public function index()
     {

      header("access-control-allow-origin: *");

      $controllers=$this->controllers;
   
      
      $html=array();

      foreach ($controllers as $one_controller) {
  
        $this->load->library("../controllers/".$one_controller);

        $class_methods = get_class_methods($one_controller);
         
        
         

        if(($key = array_search('__construct', $class_methods)) !== false) {
          unset($class_methods[$key]);
        }

        if(($key = array_search('get_instance', $class_methods)) !== false) {
          unset($class_methods[$key]);
        }

        asort($class_methods);
        
        if($one_controller =='job'){
             $class_methods=array('debug','importUsers','importCardReaders','regionalStatisticsByIds','regionalStatistics','importCards');

        }

        



        $tpl=$this->controller_tpl($one_controller,$class_methods);   
        $html[]=$tpl;
      }

      $page=array('controller_and_methods'=>$html,'version_to_test'=>1);
     
      $this->load->view('testframework_view',$page);
      
     
     }


     
 
    public  function controller_tpl($Controller_name,$function_list){


      $tpl= '<tr><td style="width:200px;"><div class="form-group"><div class="col-md-8"><div class="radio"><label for="function_radio">';
      $tpl.='<input type="radio" name="function_radio" id="Controller_name" value="Controller_name" checked="checked"> Controller_name </label> </div> </div> </div> </td>';
      $tpl.='<td style="width:600px;"><div class="form-group"><div class="col-md-8"><select id="Controller_name_methods" name="Controller_name_methods" class="form-control">';
      $tpl.='Function_list</select> </div> </div> </td> </tr>';




      $Function_list='';
         foreach ($function_list as $one_function) {
         $Function_list.="<option  id=$one_function value=$one_function>$one_function</option>";
      }

    $tpl = str_replace("Controller_name", $Controller_name, $tpl);
    $tpl = str_replace("Function_list", $Function_list, $tpl);
    return $tpl;
    }

 





     
}
?>
