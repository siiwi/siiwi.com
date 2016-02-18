<?php
/**
 * 注册控制器
 */
class ControllerAccountRegister extends \Siiwi\Dashboard\BaseController
{
    public function index()
    {
        // 加载页面框架
        $this->data['frame']['header'] = $this->load->controller('frame/header', $this->language->get('account_register_index')->title);
        $this->data['frame']['footer'] = $this->load->controller('frame/footer');

        // 邮箱正则
        $this->data['account_register_index']['regex_email'] = $this->config->get('config_regex_email');

        $this->response->setOutput($this->load->view('account/register.html', $this->data));
    }

    /**
     * 注册验证
     * @method POST | AJAX
     */
    public function check()
    {
        if($this->request->isPost() && $this->request->isAjax()) {
            $name       = $this->request->getHttpPost('name');
            $email      = $this->request->getHttpPost('email');
            $password   = $this->request->getHttpPost('password');

            $this->api->post('user/add', array('email'=>$email, 'password'=>$password, 'name'=>$name));

            if($this->api->getResponseStatus()) {
                $response['status'] = true;
                $user_info = $this->api->getResponseData();
                $this->session->set('user_info', $user_info['user_info']);
            } else {
                $response['status'] = false;
            }

            $response['message'] = $this->language->get('account_register_check')->message[$this->api->getResponseMessage()];
            $this->response->outputJson($response);
        }
    }
}
