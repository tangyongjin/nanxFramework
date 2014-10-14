<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class File extends CI_Controller {
	function upload() 
	{
	  
  	  if($_SERVER['REQUEST_METHOD']=='POST'&&empty($_POST)&&empty($_FILES)&&$_SERVER['CONTENT_LENGTH']>0)
      {
      $post_size_get= $_SERVER['CONTENT_LENGTH']; 
      $check=$this->check_postsize_and_post_max_size($post_size_get);
      echo json_encode($check,JSON_UNESCAPED_UNICODE);    
      return;
      }
     
      $this->load->model('MFile');
    	$params = (array)json_decode($_REQUEST['params']); 
 	    $formfield=$params['formfield'];
      $dest=$params['dest'];
      
 	    $show_client_upload_info=false;
      if(array_key_exists('opcode',$_REQUEST))
      {
        if($_REQUEST['opcode']=='upload_pic'){$show_client_upload_info=true;}
      }
		   
      $write_able=$this->MFile->checkWriteAble($dest);
      if(!$write_able){
      $ret=array('success'=>false,'msg'=>'['.$dest.']'.$this->lang->line('check_write_able'),'show_client_upload_info'=>true);
      echo json_encode($ret,JSON_UNESCAPED_UNICODE);    
      return;
      }


      $filename = $_FILES[$formfield]["name"];
      $result = array();
      $os_filename=$this->MFile->getFilename4OS($filename);

      if(@move_uploaded_file($_FILES[$formfield]["tmp_name"],  $dest."/".$os_filename))
      {
   	   $bs_url = $this->config->item('base_url');
       $result = array('success'=> true,'msg'=> $this->lang->line('success_upload_file'),'server_filename'=> $os_filename,'serverURL' => $bs_url.'/'.$dest.'/'.$filename );  
      }
       else
      {
       $show_client_upload_info=true; 
       $errmsg=$this->lang->line('failed_upload_file_with_copy');
       $errcode=$_FILES[$formfield]['error'];
       $maxsize=ini_get('upload_max_filesize');
       if($errcode==1){$errmsg='[ERROR:1]'.$this->lang->line('file_size_over').$maxsize;}
       if($errcode==3){$errmsg='[ERROR:3]'.$this->lang->line('upload_only_part') ;}
       if($errcode==4){$success=true;$errmsg='';}
       $result = array('success'=>false, 'msg'=> $errmsg);  
      }
     
     $result['show_client_upload_info']=$show_client_upload_info;
     echo json_encode($result,JSON_UNESCAPED_UNICODE);    
  }
  
  function check_postsize_and_post_max_size ($size_get)
  {
   $post_max_size = ini_get('post_max_size');
   $post_max_size_ini = $post_max_size;
   
   switch ( substr($post_max_size,-1) )
   {
    case 'G':
      $post_max_size = $post_max_size * 1024;
    case 'M':
      $post_max_size = $post_max_size * 1024;
    case 'K':
       $post_max_size = $post_max_size * 1024;
   }
   if($size_get>=$post_max_size)
   {
    $check=array('success'=>false,'msg'=> $this->lang->line('post_size_too_big').$post_max_size_ini ,'show_client_upload_info'=>true);
    return $check;
   }
  }
  
  
  function getContent()
  { 
    $post = file_get_contents('php://input');
		$para = (array)json_decode($post);
		$fname=$para['fname'];
		$this->load->helper('file');
		$content=read_file( 'js/upload/'.$fname);
	  $res=array(
	  'content' =>$content
	  );
   echo json_encode($res);    
  }
  
  
  function getFSGridFields()
  {
    
    $header=array(
    'filename'=>0
    );

    return array($header);
  }
  
  
  function fs2array()
  {
      if(isset($_GET['start']))
		   {
		   	$start = $_GET['start'];
		  	$limit = $_GET['limit'];
		   }
     $para = (array )json_decode(file_get_contents('php://input'));
     $os_path=$para['os_path'];
     $file_trunk=$para['file_trunk'];
     $this->load->model('MFile');
     $files=$this->MFile->getFileList('imgs','all');
     $result=array();
     $tr=array_chunk($files,5);
      
      if(isset($_GET['start']))
		   {
		   	$start = $_GET['start'];
		  	$limit = $_GET['limit'];
		    $segment=array_slice($tr,$start,$limit);
		   }
		   else
		   {
		    $segment=$tr;
		   }
     $result['rows']=$segment;
     $result['total']=count($tr);
     $result['table']='vstable';
     $json = json_encode($result,JSON_UNESCAPED_UNICODE);
     echo $json;
  }

}
?>