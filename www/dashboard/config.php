<?php

// DIR
define('DIR_ROOT', dirname(__DIR__) . '/');
define('DIR_APPLICATION', DIR_ROOT . 'dashboard/');
define('DIR_ASSETS', DIR_ROOT . 'assets/');
define('DIR_SYSTEM', DIR_ROOT . 'system/');
define('DIR_UPLOAD', DIR_ROOT . 'upload/');
define('DIR_LANGUAGE', DIR_APPLICATION . 'language/');
define('DIR_TEMPLATE', DIR_APPLICATION . 'view/theme/');
define('DIR_CONFIG', DIR_SYSTEM . 'config/');
define('DIR_IMAGE', DIR_ROOT . 'image/');
define('DIR_CACHE', DIR_SYSTEM . 'cache/');
define('DIR_DOWNLOAD', DIR_SYSTEM . 'download/');
define('DIR_MODIFICATION', DIR_SYSTEM . 'modification/');
define('DIR_LOGS', DIR_SYSTEM . 'logs/');

// url
$_config['config_url']            = 'http://www.local.siiwi.com/';
$_config['config_app_url']        = 'http://www.local.siiwi.com/dashboard/';
$_config['config_api_url']        = 'http://api.local.siiwi.com/';

$_config['config_app_path']       = '/dash';

$_config['config_app_logo']       = '/assets/img/logo.png';

// API请求
$_config['config_client_key']     = '1357876052594';
$_config['config_client_secret']  = '9fdfdb04df2c2659c6179874482';

// 默认语言
$_config['config_language']       = 'zh-CN';

$_config['config_compression']    = 0;
$_config['config_token_deadline'] = 7200;

$_config['config_page_size']      = 10;
$_config['config_regex_email']    = '/^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/';
