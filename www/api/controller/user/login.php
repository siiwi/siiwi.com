<?php

/**
 * Class ControllerUserGet
 * 用户登录API
 *
 * @method POST
 *
 * @param email || user_id
 * @param password
 */
class ControllerUserLogin extends \Siiwi\Api\Controller
{
    private $user_info = array();
    private $user_credentials_info = array();

    public function index()
    {
        $this->isPost();

        $this->load->model('user/main');
        $this->load->model('user/credentials');

        $this->validate();

        $this->prepareUserCredentialsData();

        $this->response->jsonOutput('success', $this->setResponseData());
    }

    private function validate()
    {
        // email
        $email = (!$this->request->getHttpPost('email')) ? $this->response->jsonOutputExit('empty_email') : $this->request->getHttpPost('email');
        if(!$this->request->isEmail($email)) {
            $this->response->jsonOutputExit('invalid_email_format');
        }

        // password
        $password = (!$this->request->getHttpPost('password')) ? $this->response->jsonOutputExit('empty_password') : $this->request->getHttpPost('password');
        if((utf8_strlen($password) > 22) || (utf8_strlen($password) < 6)) {
            $this->response->jsonOutputExit('invalid_password_length');
        }

        // 判断email是否正确
        $this->user_info = $this->model_user_main->fetchOne(array('email'=>$email));
        if(!is_array($this->user_info) || empty($this->user_info)) {
            $this->response->jsonOutputExit('invalid_email');
        }

        // 判断密码是否正确
        if($this->user_info['password'] != $this->model_user_main->getUserPassword($password, $this->user_info['salt'])) {
            $this->response->jsonOutputExit('invalid_password');
        }

        // 判断用户状态，0-不可用，1-可用
        if($this->user_info['status'] == 0) {
            $this->response->jsonOutputExit('invalid_user_status');
        }
    }

    private function prepareUserCredentialsData()
    {
        $this->user_credentials_info = $this->model_user_credentials->fetchOne(array('user_id'=>$this->user_info['user_id'], 'client_id'=>$this->config->get('client_id'), 'status'=>1));

        if(!is_array($this->user_credentials_info) || empty($this->user_credentials_info)) {
            $this->user_credentials_info['user_id'] = $this->user_info['user_id'];
            $this->user_credentials_info['client_id'] = $this->config->get('client_id');
            $this->user_credentials_info['user_key'] = $this->model_user_main->getUserKey();
            $this->user_credentials_info['user_secret'] = $this->model_user_main->getUserSecret();
            $this->user_credentials_info['status'] = 1;
            $this->user_credentials_info['add_timestamp'] = time();

            $this->model_user_credentials->add($this->user_credentials_info);
        }
    }

    private function setResponseData()
    {
        return array(
            'user_info' => array(
                'user_id' => $this->user_credentials_info['user_id'],
                'name' => $this->user_info['name'],
                'email' => $this->user_info['email'],
                'parent_user_id' => $this->user_info['parent_user_id'],
                'group_id' => $this->user_info['group_id'],
                'role' => $this->user_info['role'],
                'user_key' => $this->user_credentials_info['user_key'],
                'user_secret' => $this->user_credentials_info['user_secret']
            )
        );
    }
}