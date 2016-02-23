<?php

Class ControllerAccountLogin extends \Siiwi\Dashboard\BaseController
{
    /**
     * 渲染登录页面
     * @method GET
     */
    public function index()
    {
        $this->session->destroy();

        // 加载页面框架
        $this->data['frame']['header'] = $this->load->controller('frame/header', $this->language->get('account_login_index')->title);
        $this->data['frame']['footer'] = $this->load->controller('frame/footer');

        // 邮箱正则
        $this->data['account_login_index']['regex_email'] = $this->config->get('config_regex_email');

        $this->response->setOutput($this->load->view('account/login.html', $this->data));
    }

    /**
     * 验证用户名与密码
     * @method POST | AJAX
     */
    public function check()
    {
        if($this->request->isPost() && $this->request->isAjax()) {
            $email      = $this->request->getHttpPost('email');
            $password   = $this->request->getHttpPost('password');
            $remember   = $this->request->getHttpPost('remember');

            $this->api->post('user/login', array('email' => $email, 'password' => $password));

            if($this->api->getResponseStatus()) {
                if($remember) {
                    $cookie['email']    = $email;
                    $cookie['password'] = $password;
                    $cookie             = base64_encode(json_encode($cookie));
                    setcookie('UIN', $cookie, time() + 60 * 60 * 24 * 30, $this->config->get('config_app_path'), $this->request->server['HTTP_HOST']);
                }
                $user_info          = $this->api->getResponseData();
                $this->session->set('user_info', $user_info['user_info']);
                $response['status'] = true;
            } else {
                $response['status']  = false;
            }

            $response['message'] = $this->language->get('account_login_check')->message[$this->api->getResponseMessage()];
            $this->response->outputJson($response);
        }
    }
}