<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tcpdf_lib { 
    function __construct()
    { 
        require_once(FCPATH.'pdflib/tcpdf/config/lang/eng.php');
        require_once(FCPATH.'pdflib/tcpdf/tcpdf.php');
    } 
}

?>