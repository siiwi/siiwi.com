<?php

// Load Configuration
if (!is_file('config.php')) {
    exit('load config failed.');
}

require_once('config.php');

// Startup
require_once(DIR_SYSTEM . 'startup.php');

// Registry
$registry = new Registry();

// Loader
$loader = new Loader($registry);
$registry->set('load', $loader);

// Config
$config = new Config();
$config->load('message');
$registry->set('config', $config);
foreach ($_config as $key=>$value) {
    $config->set($key, $value);
}

// Database
$db = new \Siiwi\Api\DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$registry->set('db', $db);

// Request
$request = new \Siiwi\Api\Request();
$registry->set('request', $request);

// Response
$response = new \Siiwi\Api\Response();
$response->addHeader('Access-Control-Allow-Origin: *');
$response->addHeader('Content-Type: application/json; charset=utf-8');
$response->setCompression($config->get('config_compression'));
$response->setMessage($config->get('api'));
$response->setRequest($request->get['route']);
$registry->set('response', $response);

// Front Controller
$controller = new Front($registry);

// Signature
$controller->addPreAction(new Action('signature/verify'));

// Router
$route = isset($request->get['route']) ? $request->get['route'] : 'common/error';

$action = new Action($route);

// Dispatch
$controller->dispatch($action, new Action('common/error'));

// Output
$response->output();