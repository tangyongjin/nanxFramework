<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class backend extends CI_Controller
{
     
    
    function admin() 
    { 
      $js_folder=$this->i18n->get_current_locale(); 
      $successmsg =$this->lang->line('default_success_msg');
      $this->load->model('MUi'); 	 
      $page=$this->MUi->getCommPage('backend', $js_folder);
      $user = $this->session->userdata('user');
      $roles   =$this->session->userdata('roles');
      $role_list=array_retrieve($roles ,'role_code');
      $isadmin=false;
      if( in_array( 'admin' ,$role_list  )){$isadmin=true;}
      
      if(!$isadmin)
      {
      echo "Not admin,can not access backend .";
      return;
      }
      
      if (empty($user)) 
      {
 	    $page['loginview']='loginview';
	    $this->load->view('framework',$page );
      }
      else
      {
	    $this->load->view('backend_view',$page );
      }
    }
    
    
    
    function url()
    {
      $file=$_GET['file'];
      $imgstr=img($file);
      echo  "<div style='margin:20px;'>".$imgstr.'<br/>'.$file."</div>";
    }
 }
?>