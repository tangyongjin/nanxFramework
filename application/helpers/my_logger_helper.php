<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 
function logtext($txt)
{
    $log = fopen( get_log_name(), "a+");
    fwrite($log, $txt);
    fwrite($log, "\n" );
    fclose($log);



}

function get_log_name()
{

 
    $XCI = &get_instance();
    $logpath=$_SERVER['DOCUMENT_ROOT'].'/'.'/logs/';
    $callstack = debug_backtrace();
    $clsname='';
    foreach ($callstack as $key => $row) {
       if( array_key_exists('class', $row)  ){
        $clsname=strtolower ( $row['class']);

       }
    }

    $logname         = $clsname.'_'. @date('Ymd', time());
    $date_based_file = $logpath . $logname;
    return $date_based_file;
}

?>