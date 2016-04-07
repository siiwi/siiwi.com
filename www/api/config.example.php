<?php

error_reporting(0);
date_default_timezone_set('Asia/Shanghai');

// HTTP
define('HTTP_SERVER', 'http://api.siiwi.com/');

// HTTPS
define('HTTPS_SERVER', 'https://api.siiwi.com/');

// DIR
define('DIR_ROOT', dirname(__DIR__) . '/');
define('DIR_APPLICATION', DIR_ROOT . 'api/');
define('DIR_SYSTEM', DIR_ROOT . 'system/');
define('DIR_LANGUAGE', DIR_APPLICATION . 'language/');
define('DIR_TEMPLATE', DIR_APPLICATION . 'view/theme/');
define('DIR_CONFIG', DIR_SYSTEM . 'config/');
define('DIR_IMAGE', DIR_ROOT . 'image/');
define('DIR_CACHE', DIR_SYSTEM . 'cache/');
define('DIR_DOWNLOAD', DIR_SYSTEM . 'download/');
define('DIR_UPLOAD', DIR_SYSTEM . 'upload/');
define('DIR_MODIFICATION', DIR_SYSTEM . 'modification/');
define('DIR_LOGS', DIR_SYSTEM . 'logs/');

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'sql123');
define('DB_DATABASE', 'siiwi');
define('DB_PREFIX', 'si_');

// config
$_config['config_img_url'] = 'http://www.siiwi.com';
$_config['config_url'] = HTTP_SERVER;
$_config['config_ssl'] = HTTPS_SERVER;
$_config['config_secure'] = 0;

$_config['config_compression'] = 0;
$_config['config_token_deadline'] = 3600;

$_config['page_size'] = 10;
$_config['regex_email'] = '/^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/';
