<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//Add file in this array, if you want I18n library auto load them
$config['language']['file_prefix'] = array('messages');

//If user locale not found, set this valus as a defaul user locale
$config['language']['default_locale'] = 'en';

//Default language folder, if locale folder not found
$config['language']['locale']['default'] = 'en';

$config['language']['locale']['zh'] = 'zh';

//zh-TW locale mapped to tchinese folder
$config['language']['locale']['zh-TW'] = 'zh-TW';

$config['language']['locale']['english'] = 'en';
$config['language']['locale']['en'] = 'en';


/* End of file i18n.php */
/* Location: ./application/config/i18n.php */