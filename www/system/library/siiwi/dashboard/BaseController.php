<?php

namespace Siiwi\Dashboard;

class BaseController extends \Controller
{
    // 初始化视图输出数据
    public $data;

    public function __construct($registry)
    {
        parent::__construct($registry);

        $this->setAccessToken();

        // 加载语言包
        $this->data['language'] = $this->language;

        // URL
        $this->data['url'] = $this->url;
    }

    /**
     * @return bool
     * 在用户已登录的前提下，判断access_token是否有效，如果无效则重新申请新的access_token
     */
    protected function setAccessToken()
    {
        $user_info = $this->session->get('user_info');
        if(!isset($user_info['access_token']) || !isset($user_info['expires']) || ($user_info['expires'] < time())) {
            $this->api->get('auth/token', array('user_key'=>$user_info['user_key']));
            if($this->api->getResponseStatus()) {
                $token_info = $this->api->getResponseData();
                $user_info['access_token'] = $token_info['token_info']['access_token'];
                $user_info['expires'] = $token_info['token_info']['expires'];
                $this->session->set('user_info', $user_info);
            }
        }
        $this->api->access_token = $user_info['access_token'];

        return true;
    }
}