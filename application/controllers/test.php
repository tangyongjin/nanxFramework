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

$tb='standx_abc';
$m='MRdbms';
$fun='fun1';
 $this->load->model($m);
// debug($model);
$fd=$this->$m->$fun($tb);
//$model->{$fun}(); 
 debug($fd);
}

 
}
?>