<?php
defined('BASEPATH') OR exit('No direct script access allowed');



/*
缺省上传目录
default upload folder
*/

$config['default_upload_folder'] = 'uploads';
$config['default_js_upload_folder'] = 'js/upload';


/*
缺省临时目录
*/
$config['default_tmp_folder'] = 'tmp';

/*
是否启用日志
using application log
*/

$config['uselog'] =true;

/*
log_divide
日志分割方式
支持4种分割方式:
one/day/month/year
*/

// $config['log_divide'] ='one';
$config['log_divide'] ='day';
// $config['log_divide'] ='month';
// $config['log_divide'] ='year';

/*
日志文件位置
log file location
*/
$config['logdir'] ='logs' ;

/*
根据日志分割方式,文件名可为 nanx-2017-01-01 or nanx-2017 
*/
$config['logfilename'] ='nanx.log';

 
?>