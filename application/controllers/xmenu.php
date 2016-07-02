<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Xmenu extends CI_Controller {
    
     public $tree = null;
     public $html = '';



    function getChild()
    {  
          if ($this->uri->segment(3) === FALSE)
      {
          $menu_id = 0;
      }
      else
      {
          $menu_id = $this->uri->segment(3);
          $sql="select * from  nanx_activity where activity_code in (select activity_code from   nanx_menu where  parent='".$menu_id."')";
  
           
          $subitems=$this->db->query($sql)->result_array();
          $html='<div class="cpanel-left"><div class=cpanel>';

      //    print_r($subitems);
          foreach ($subitems as $key => $one_item) {
             $div=$this->getsubitemDiv($one_item);
             $html.=$div;
          }
          $html.='</div></div>';
          echo $html;

      }
      
    }  
    


    function getsubitemDiv($one_item){


        $bs= $this->config->base_url();
        $acode=$one_item['activity_code'];
        $onediv =" 
            <div class='icon'>  
              <a class='nanx-4-ext'  activity_type='table' id=$acode  href=#>
                <img src='{$bs}/imgs/{$one_item['pic_url']}'/>
                <span>{$one_item['grid_title']}</span>
              </a>
          </div>";
        
        return   $onediv;
    }
    
    function debug($arr){
      echo "<pre>";
      print_r($arr);
      echo "</pre>";
       
    }


    



 public function test22() {

        
        $sql=" select * from nanx_menu_copy where parent is null" ;
        $this->tree=$this->db->query($sql)->result_array();
        for ($i = 0; $i < count($this->tree); $i++) {
           $this->tree[$i]['child']= $this->setchild($this->tree[$i]['activity_code']);
        }
        $this->debug($this->tree);
 }



public function setchild($code){
          $sql=" select * from nanx_menu_copy where parent= '".$code."'" ;
          $res=$this->db->query($sql)->result_array();
          for ($i = 0; $i < count( $res); $i++) {
             $res[$i]['child']= $this->setchild($res[$i]['activity_code']);
          }
          return $res;
}


  
 public function testul() {

        
        $sql=" select * from    nanx_activity where activity_code in (select activity_code from   nanx_menu  where parent is null)" ;
        $this->tree=$this->db->query($sql)->result_array();
        
        $this->html.='<ul id="main-menu">';
        for ($i = 0; $i < count($this->tree); $i++) {
            $this->html.='<li class="parent">'.$this->tree[$i]['activity_code'].$this->setchildul($this->tree[$i]['activity_code']).'</li>';
        }
        $this->html.='</ul>'; 
        echo $this->html;
 }



public function setchildul($code){
          $sql=" select * from nanx_menu  where parent= '".$code."'" ;
          $res=$this->db->query($sql)->result_array();
          $tmp='<ul class="sub-menu">';
          for ($i = 0; $i < count( $res); $i++) {
              $tmp.='<li>'.$res[$i]['activity_code'].$this->setchildul($res[$i]['activity_code']).'</li>';
          }
          $tmp.='</ul>';
         
          if($tmp=='<ul class="sub-menu"></ul>'){
            $tmp='';
          }

          return $tmp;
}


  


   

 
 




}
?>