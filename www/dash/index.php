<?php
// Config
require_once('config.php');

// Startup
require_once(DIR_SYSTEM . 'startup.php');

// Registry
$registry = new Registry();

// Config
$config = new Config();
$registry->set('config', $config);
foreach ($_config as $key => $value) {
    $config->set($key, $value);
}

// Loader
$loader = new Loader($registry);
$registry->set('load', $loader);

// Url
$url = new \Siiwi\Dashboard\Url($config->get('config_app_url'));
$registry->set('url', $url);

// Request
$request = new \Siiwi\Dashboard\Request();
$registry->set('request', $request);

// Response
$response = new \Siiwi\Dashboard\Response();
$response->addHeader('Content-Type: text/html; charset=utf-8');
$response->setCompression($config->get('config_compression'));
$registry->set('response', $response);

// Api
$api = new \Siiwi\Dashboard\HttpClient();
$api->host = $config->get('config_api_url');
$api->client_key = $config->get('config_client_key');
$api->client_secret = $config->get('config_client_secret');
$api->signature();
$registry->set('api', $api);

// Session
$session = new Session();
$registry->set('session', $session);

// 获取语言配置
$api->get('language/get');
if(!$api->getResponseStatus()) {
    $language_list = $config->get('language');
} else {
    foreach ($api->getResponseData() as $result) {
        $language_list[$result['code']] = $result;
    }
}

// 配置语言项
if (isset($request->cookie['language']) && array_key_exists($request->cookie['language'], $language_list)) {
    $language = $request->cookie['language'];
} else {
    $detect = '';
    if (isset($request->server['HTTP_ACCEPT_LANGUAGE']) && $request->server['HTTP_ACCEPT_LANGUAGE']) {
        $browser_languages = explode(',', $request->server['HTTP_ACCEPT_LANGUAGE']);
        foreach ($browser_languages as $browser_language) {
            foreach ($language_list as $key => $value) {
                if ($value['status']) {
                    $locale = explode(',', $value['locale']);

                    if (in_array($browser_language, $locale)) {
                        $detect = $value['code'];
                        break 2;
                    }
                }
            }
        }
    }
    $language = $detect ? $detect : $config->get('config_language');
}

if (!$request->cookie['language']) {
    setcookie('language', $language, time() + 60 * 60 * 24 * 30, $config->get('config_app_path'), $request->server['HTTP_HOST']);
    $request->cookie['language'] = $language;
}

$config->set('language_list', $language_list);

// Lang
$lang = new Language($language_list[$language]['directory']);
$lang->load($language_list[$language]['directory']);
$registry->set('language', $lang);

// Front Controller
$controller = new Front($registry);

// Router
if (isset($request->get['route'])) {
    $action = new Action($request->get['route']);
} else {
    $action = new Action('home/home');
}

// Dispatch
$controller->dispatch($action, new Action('home/home'));

// Output
$response->output();