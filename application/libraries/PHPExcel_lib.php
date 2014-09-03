<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class PHPExcel_lib { 
    function __construct()
    {
        $syspath=ini_get('include_path');
        $excel_lib_path=FCPATH.'excel/Classes';
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
        {$spliter=';'; }
        else
        {
        $spliter=':';
        }


        $new_include=$syspath.$spliter.$excel_lib_path;
        ini_set('include_path', $new_include );
        include 'PHPExcel.php';
        include 'PHPExcel/IOFactory.php';
        include 'PHPExcel/Writer/Excel5.php';
    }
}
?>