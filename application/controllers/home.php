<?php 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Home extends CI_Controller
{
  
    


    function index()
    {
        
        $session_id = $this->session->userdata('session_id');
        
        //echo "sessid is  $session_id  </br>"  ;


        $logged_user= $this->session->userdata('user');
         
        

        if( is_null($logged_user)){
         
          $this->login();
        

        }
        
 
        $lang = $this->i18n->get_session_lang();
        

        
        
        $this->load->model('MUi');
        $page          = $this->MUi->getCommPage('front', $lang);
        $activities    = $this->session->userdata('user_activity');
        $left          = $this->MUi->getActionBlock($activities);
        $page['left']  = $left;
        $page['right'] = 'jpanel_right';
        $this->load->view('framework', $page);
        
    }
    
    
    function checkDatabaseConnection()
    {
        if ($this->load->database() === FALSE) {
            exit('THE END IS NIGH!');
        } else {
            return true;
        }
    }
    
    function login()
    {
      

        
     

     
        if ($this->uri->segment(3) === FALSE) {
            $lang_select = $this->i18n->get_user_default_lang();

        } else {
            $lang_select = $this->uri->segment(3);
           
        }


      

        $this->session->unset_userdata('lang');
        $this->session->set_userdata('lang', $lang_select);

        
        
        $this->load->model('MUi');
        $page              = $this->MUi->getCommPage("login", $lang_select);
        $page['lang']      = $lang_select;
        $page['loginview'] = 'loginview';
        $page['showlogin']=true;
        $this->load->view('framework', $page);
    }
    
    
    function dologin()
    {   

       //  $this->clear_sess();


        $post = file_get_contents('php://input');
        $p    = (array) json_decode($post);
        $u    = array(
            'user' => $p['account']
        );

        $lang=$p['lang'] ;
        
        $result = array();
        
        $user = $this->db->select('pid,user,password,staff_name,active,salt')->get_where('nanx_user', $u)->result_array();
        
        
        if (sizeof($user) != 1) {
            $result['code']  = -1;
            $result['msg']   = $this->lang->line('login_err');
            $result['einfo'] = 'auth failed';
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            return;
        }
        
        
        if ($user[0]['active'] != 'Y') {
            $result['code'] = -2;
            $result['msg']  = $this->lang->line('user_locked');
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            return;
        }
        
        
        if (sizeof($user) == 1) {
            $salt              = $user[0]['salt'];
            $pwd_db            = $user[0]['password'];
            $pwd_try           = $p['password'];
            $pwd_try_with_salt = md5(md5($pwd_try) . $salt);
            
            
            if ($pwd_try_with_salt == $pwd_db) {
                $result['code'] = 0;
                $result['msg']  = '';
                $result['user'] = $p['account'];
                
                $eid = $this->config->item('base_url');
              

                $this->setsession($p['account'],$eid,$lang);
                echo json_encode($result);
                return;
            } else {
                $result['code']  = -1;
                $result['msg']   = $this->lang->line('login_err');
                $result['einfo'] = 'auth failed';
                echo json_encode($result, JSON_UNESCAPED_UNICODE);
                return;
            }
        }
    }
    
    
    
 function setsession($user,$eid,$lang)
    {
 
        $this->load->model('MUserRole');
        $this->load->model('MSystempara');
        $eid = $this->config->item('base_url');
        $this->session->set_userdata('eid', $eid);
        $this->session->set_userdata('user', $user);

        $this->session->set_userdata('ABCDEF', $user);

        $this->session->set_userdata('lang', $lang);
        
        $sql   = "select role_code from nanx_user_role_assign where user='" . $user . "' ";
        $roles = $this->db->query($sql)->result_array();
        $this->session->set_userdata('roles', $roles);
        
        $activity_list = $this->MUserRole->getActivitybyRoleCode($roles);
        $activity      = array_retrieve($activity_list, 'activity_code');
        $this->session->set_userdata('user_activity', $activity);
        
        
        $sql      = "select  *  from nanx_user where user='" . $user . "'";
        $user_get = $this->db->query($sql)->row_array();
        
        $this->session->set_userdata('staff_name', $user_get['staff_name']);
        
        
        $sql        = "select  *  from nanx_who_is_who where user='" . $user . "'";
        $who_is_who = $this->db->query($sql)->result_array();
        $this->session->set_userdata('who_is_who', $who_is_who);
        
        
        $page_title   = $this->MSystempara->getCfgItem('PAGE_TITLE');
        $banner_title = $this->MSystempara->getCfgItem('BANNER_TITLE');
        $this->session->set_userdata('page_title', $page_title);
        $this->session->set_userdata('banner_title', $banner_title);
    }
    
    function ie6issue()
    {
        if ($this->uri->segment(3) === FALSE) {
            $lang = $this->i18n->get_session_lang();
            $this->i18n->load_language();
        } else {
            // $lang = $this->uri->segment(3);
            $lang='zh-cn' ;
            $this->i18n->set_current_locale($lang);
        }
        $this->load->view('ie6issue');
        
        
    }


    function logout()
    {
       $this->clear_sess();
       redirect('home/login?ts='.time(),'refresh');
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

    
    function clear_sess(){

         $this->session->unset_userdata('user_data');
         $this->session->sess_destroy();

    }

    
}
?>
