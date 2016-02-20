<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

class Dbdocu extends CI_Controller {


    function index()
    {
       
  
       
        echo '<a href=http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'/lang_js'.">lang_js </a>"  ;
      
        echo "<br/>";
      
        echo '<a href=http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'/lang_php'.">lang_php </a>"  ;

        echo "<br/>";

        echo '<a href=http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'/help_html'.">help_html </a>"  ;
      
      
      
    }

    function help_html(){

 
    include "nanx.php" ;
    
    $nanx=new Nanx;
    $cfg=$nanx->actionCfg();

    $keys=array_keys($cfg);
    $DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT'];

    
    $help_dir=$DOCUMENT_ROOT.'/standx/application/language/zh-cn/';
    

    echo "help dir is ".$help_dir.'<br/>';
    echo "下列帮助文件没有生成:<br/>" ;

    foreach ($keys as $key => $one_code) {
    	$one_html=$help_dir.$one_code.".html";
          
    	if (!file_exists($one_html)){
	      echo $one_html."<br/>";
    	}

     
     	# code...
     } 


    }

	function print_table($tab) {
				echo '
		  	<style type="text/css">
		table{
			width:700px;
			margin:0px auto;
			font:Georgia 11px;
			color:#333333;
			text-align:left;
			border-collapse:collapse;
		}
		table td{
			border:1px solid blue;
		//	width:100px;
			height:30px;
		}
		</style>

		';

		echo '<table  border="1" cellspacing="0" cellpadding="0">';
		echo "<tr><td colspan=2 style='font-size:18px; font-weight:bold;'>" . $tab['name'] . '&nbsp;&nbsp;(' . $tab['comm'] . ")</td></tr>";

		foreach ($tab['cols'] as $onecol) {
			echo "<tr><td style='width:30%;'>" . $onecol['COLUMN_NAME'] . "</td><td>" . $onecol['COLUMN_COMMENT'] . "</td></tr>";
		}

		echo "</table>";
		echo "<br/>";

	}

  

   function  check_function(){
   	if (function_exists('mysql_real_escape_string'))
   	{
   		echo "found mysql_real_escape_string" ;

   	}

   }

	function test() {

		$tables = $this->db->list_tables();

		foreach ($tables as $table) {
			$tab_info         = array();
			$tab_info['name'] = $table;

			$sql1 = "select table_name,table_comment FROM information_schema.TABLES T where  table_name='$table'  and  table_schema='kx1000' ";
			$comm = $this->db->query($sql1)->result_array();

			$tab_info['comm'] = $comm[0]['table_comment'];

			$sql2             = "SELECT  C.`COLUMN_NAME`, C.`COLUMN_COMMENT`  FROM information_schema.`COLUMNS` C where  table_schema='kx1000'  and  table_name='$table'";
			$col              = $this->db->query($sql2)->result_array();
			$tab_info['cols'] = $col;

			$this->print_table($tab_info);

		}

	}

	function help_generator() {
		$post = file_get_contents('php://input');
		$para = (array ) json_decode($post);
		$this->write($para);
	}


    function  get_eid_os_dir(){

        $DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT'] ;
        $eid = $this->config->item('eidfolder');    
        return $DOCUMENT_ROOT.'/'.$eid.'/';

    }


	function lang_js() {

		$this->load->helper('file');
		echo "/js/language/en/i18n.js  与 /js/language/zh-cn/i18n.js 比较: <br/>";
        
        $eid_os_dir=$this->get_eid_os_dir();

     	$ejs     = $eid_os_dir.'js/language/en/i18n.js';
		$e     = fopen($ejs, 'r');
		$e_arr = array();
		while (!feof($e)) {
			$line = fgets($e);
			$line = str_replace('{', '', $line);
			$line = str_replace('}', '', $line);
			if (strpos($line, ':') == true) {
				$kv      = explode(":", $line);
				$e_arr[] = $kv[0];
			}
		}

		$cjs = $eid_os_dir . '/js/language/zh-cn/i18n.js';

		$c     = fopen($cjs, 'r');
		$c_arr = array();
		while (!feof($c)) {
			$line = fgets($c);
			$line = str_replace('{', '', $line);
			$line = str_replace('}', '', $line);
			if (strpos($line, ':') == true) {
				$kv      = explode(":", $line);
				$c_arr[] = $kv[0];
			}
		}

		debug($e_arr);
		debug($c_arr);
		$diff = array_diff($e_arr, $c_arr);

		echo "中文缺少:<br/>";
        foreach ($diff as $one ) {
        	echo "'$one':'',<br/>";
        }

		
        echo "英文缺少:<br/>";

		$diff = array_diff($c_arr, $e_arr);
		//debug($diff);

        foreach ($diff as $one ) {
        	echo "$one:'',<br/>";
        }

		$sql = "select  concat('cp  en/i18n.js   ',id,'/i18n.js   ' ) as vv from  nanx_country where id not in ('en','zh-cn');";
		echo $sql.'<br/><br/>';


        echo '<br/>拷贝下面的到jjs/language目录,执行<br/><br/>';

		$bat = $this->db->query($sql)->result_array();
		foreach ($bat as $cp) {
			echo $cp['vv'] . "<br/>";
		}
		return;
	}


    

	function lang_php() {

		echo " /application/language/en/messages_lang.php  与 /application/language/zh-cn/messages_lang.php 比较: <br/>";

		$eid_os_dir=$this->get_eid_os_dir();

        require( $eid_os_dir . '/application/language/en/messages_lang.php' );
        $e_config=$lang;
        $e_arr=array_keys($e_config);
        debug($e_arr);
        unset($lang);
        
        require( $eid_os_dir . '/application/language/zh-cn/messages_lang.php' );
        $c_config=$lang;
        $c_arr=array_keys($c_config);
        debug($c_arr);

		$diff = array_diff($e_arr, $c_arr);
        echo "中文缺少:<br/>";
        foreach ($diff as $one ) {
         echo "\$lang['$one']='';  "."<br/>"  ;
        }
        
        $diff = array_diff($c_arr, $e_arr);
        echo "英文缺少:<br/>";
       
        foreach ($diff as $one ) {
         echo "\$lang['$one']='';  "."<br/>"  ;
        }

		
		$sql = "select  concat('cp  en/messages_lang.php   ',id,'/messages_lang.php   ' ) as vv from  nanx_country where id not in ('en','zh-cn');";
		$bat = $this->db->query($sql)->result_array();
		foreach ($bat as $cp) {
			echo $cp['vv'] . "<br/>";
		}
		return;

	}


	 function lang_help()
    {

    	$sql = "select  concat('cp  en/*.html   ',id,'/   ' ) as vv from  nanx_country where id not in ('en','zh-cn');";
		$bat = $this->db->query($sql)->result_array();
		foreach ($bat as $cp) {
			echo $cp['vv'] . "<br/>";
		}
    }

	function write($cfg) {

		printjson_encode($cfg, JSON_UNESCAPED_UNICODE);
		$this->load->helper('file');
		$fname = 'c:/wamp/www/newoss/helps/' . $cfg['opcode'] . ".html";

		$doc_operation  = $this->lang->line('doc_operation');
		$doc_items_desc = $this->lang->line('doc_items_desc');
		$doc_notice     = $this->lang->line('doc_notice');

		$content = "<div class=back_help>\n<h1>$doc_operation:_OPERATION</h1>\n<div class=operation_desc>deschere</div>\n<div class=back_item_list>_ITEMS</div>\n<div class=back_demo></div>\n<div class=back_notice>$doc_notice</div>\n</div>";
		$op      = $cfg['title'];
		$ul      = "<h1 class=back_items>$doc_items_desc</h1><table class=docu_table>";
		for ($i = 0; $i < count($cfg['items']); $i++) {
			$ul .= '<tr><td>' . $cfg['items'][$i] . '</td><td><div clsss=field_desc>xxxxxx</div></td></tr>';
		}
		$ul .= '</table>';
		$content = str_replace('_OPERATION', $op, $content);
		$content = str_replace('_ITEMS', $ul, $content);
		$content .= "<div class=operation_notice></div>";
		write_file($fname, $content, 'w+');
	}


    
    function  check_operation_code_help(){

    }


	function gethelp() {
		$code = $this->uri->segment(3);
		$lang = $this->i18n->get_current_locale();
		if ($code == 'set_biz_field_combo_resorce,set_biz_field_combo_follow') {
			$code = 'set_biz_field_combo_and_follow';
		}
        $baseurl=config_item('base_url');
        $rand=time();
		$v = $baseurl."/application/language/" . $lang . "/" . $code . '.html?rand='.$rand;
	    redirect($v, 'location', 301);
	}
}
?>
