<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {


function py()
{
 $this->load->helper('my_pinyin'); 
 $s='Dis';
 $x=pinyin($s);
 $ret=array('code'=>0,'msg'=>'aa');
 	echo json_encode($ret);
}
	
	
function index()
{
 $this->load->model('MFile');
 $f="hello";
 echo $this->MFile->getFileType($f);
 
 
}

 
}
?>