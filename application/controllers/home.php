<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller {
    function index() 
    { 
      $lang= $lang=$this->i18n->get_current_locale();
      $this->load->model('MUi'); 	 
      $page=$this->MUi->getCommPage('front',$lang);
      $activities = $this->session->userdata('user_activity'); 
      $left=$this->MUi->getActionBlock($activities);
  	  $page['left']=$left;
 	    $page['right']='jpanel_right';
	    $this->load->view('framework',$page );
       
    }
    
    
    function checkDatabaseConnection()
    {
      if ( $this->load->database() === FALSE )
       {
         exit('THE END IS NIGH!');
       }
       else
       {
       return true;
       }
    }
    
    function login()
    {
     if ($this->uri->segment(3) === FALSE)
     {
      $lang=$this->i18n->get_current_locale();
      $this->i18n->load_language();
     }
     else
     {
      $lang = $this->uri->segment(3);
      $this->i18n->set_current_locale($lang);
     }
     
    	$this->load->model('MUi');
      $page=$this->MUi->getCommPage("login",$lang);
 	    $page['lang']=$lang;
	    $page['loginview']='loginview';
	    $this->load->view('framework',$page );
    }
    
    
    function dologin()
	{ 
		  $post = file_get_contents('php://input') ;
      $p=(array)json_decode($post);
      $u=array(  'user'=> $p['account'] ); 
      
    $result=array();
 
    $user = $this->db->select('pid,user,password,staff_name,active,salt')->get_where('nanx_user', $u)->result_array();
    
    
    if(sizeof($user)!=1)
    {
    $result['code']=-1;
    $result['msg']=$this->lang->line('login_err'); 
    $result['einfo']='auth failed';
    echo json_encode($result,JSON_UNESCAPED_UNICODE);
    return;
    }
    
    
    if( $user[0]['active']!='Y')
    {
    $result['code']=-2;
    $result['msg']=$this->lang->line('user_locked'); 
    echo json_encode($result,JSON_UNESCAPED_UNICODE);
    return;
    }
    
    
    if(sizeof($user)==1)
    {
     $salt=$user[0]['salt'];
     $pwd_db=$user[0]['password'];
     $pwd_try= $p['password'];
     $pwd_try_with_salt= md5(md5($pwd_try).$salt);   


    if($pwd_try_with_salt==$pwd_db)
    {
    $result['code']= 0;
    $result['msg']='';
    $result['user']=$p['account'];
    $this->setsession($p['account']);
    echo json_encode($result);
    return;
    }
    else
    {
    $result['code']=-1;
    $result['msg']=$this->lang->line('login_err'); 
    $result['einfo']='auth failed';
    echo json_encode($result,JSON_UNESCAPED_UNICODE);
    return;
    }
    }
	}
	
	 
	
	function setsession($user)
	{
	   $this->load->model('MUserRole');
		 $this->load->model('MSystempara'); 	 
		 
		 
		 $eid=$this->config->item('base_url'); 
		 $this->session->set_userdata('eid',$eid);
		 $this->session->set_userdata('user',$user);
	   $this->session->set_userdata('user_activity',null);
	   	   
		  
		 
	   $sql="select role_code from nanx_user_role_assign where user='".$user."' ";
     $roles=$this->db->query($sql)->result_array();
	   $this->session->set_userdata('roles', $roles);

	   $activity_list=$this->MUserRole->getActivitybyRoleCode($roles);
	   $activity=array_retrieve($activity_list,'activity_code');
	   $this->session->set_userdata('user_activity',$activity);
  
  
	   $sql="select staff_name from nanx_user where user='".$user."'";
	   $r=$this->db->query($sql)->result_array();
	   $staff=$r[0]['staff_name'];
	   $this->session->set_userdata('staff_name',$staff);
	   
	   
	   
     $page_title=$this->MSystempara->getCfgItem('PAGE_TITLE');
 	   $banner_title=$this->MSystempara->getCfgItem('BANNER_TITLE');
	   $this->session->set_userdata('page_title',$page_title);
     $this->session->set_userdata('banner_title',$banner_title);
	}
	
	function ie6issue()
	{
	   if ($this->uri->segment(3) === FALSE)
     {
      $lang=$this->i18n->get_current_locale();
      $this->i18n->load_language();
     }
     else
     {
      $lang = $this->uri->segment(3);
      $this->i18n->set_current_locale($lang);
     }
	    $this->load->view('ie6issue');
	    
	    
	}
	 function logout()
   {
   $this->session->unset_userdata( array('eid'=>'','user'=>'','user_activity'=>'','roles'=>''));
         redirect('home/index');
   }
        
	function test()
	{
	$this->load->library('email');
  $this->email->from('tangyongjin97@qq.com', 'Tang');
  $this->email->to('tangyongjin97@qq.com'); 
  $this->email->subject('Email Test');
  $this->email->message('测试邮件,中文'); 
  $this->email->send();
  echo $this->email->print_debugger();
	}
}
?>