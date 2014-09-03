<?php
//权限列表  acl_list.php

$config['acl']['PURCHASE'] =
array(    ''=>array('index'),//首页  
      'res'=>array('add','listing'),
      );
      
      
$config['acl']['NETADM'] =
array(    ''=>array('index'),//首页  
      'direct'=>array('listing','add'),
      'system'=>array('login','logout','checklogin','show_info'),
      );
      

$config['acl']['visitor'] =
array(    ''=>array('index'),//首页  
'system'=>array('login','logout','checklogin','show_info'),
      );

$config['acl']['ADMIN'] =array();



?>