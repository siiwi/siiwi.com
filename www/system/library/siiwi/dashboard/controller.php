<?php

namespace Siiwi\Dashboard;

class Controller extends \Siiwi\Dashboard\BaseController
{
    public function __construct($registry)
    {
        parent::__construct($registry);

        $this->isLogin();
    }

    /**
     * @return bool
     * �ж��û��Ƿ��ѵ�¼��δ��¼����ת����¼ҳ��
     */
    private function isLogin()
    {
        $user_info = $this->session->get('user_info');

        if(is_array($user_info) && !empty($user_info)) {
            return true;
        } else {
            // cookie�Զ���¼
            $UIN = $this->request->cookie['UIN'];
            if($UIN) {
                $cookie_info = json_decode(base64_decode($UIN), true);
                if(is_array($cookie_info) && !empty($cookie_info)) {
                    $email = $cookie_info['email'];
                    $password = $cookie_info['password'];
                    $this->api->post('user/login', array('email' => $email, 'password' => $password));
                    if($this->api->getResponseStatus()) {
                        $user_info = $this->api->getResponseData();
                        $this->session->set('user_info', $user_info['user_info']);
                        return true;
                    }
                }
            }
        }

        $this->url->redirect('account/login');
    }
}