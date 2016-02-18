<?php

/**
 * Class ControllerUserAdd
 *
 * 添加用户基本信息与证书信息API
 *
 * @method POST
 *
 * @param email
 * @param password
 * @param name
 * @param role
 * @param group_id
 * @param parent_user_id
 */
class ControllerUserAdd extends \Siiwi\Api\Controller
{
    private $user_info = array();
    private $user_credentials_info = array();
    private $timestamp;

    public function index()
    {
        $this->isPost();

        $this->load->model('user/main');
        $this->load->model('user/credentials');
        $this->load->model('group/main');

        $this->timestamp = time();

        $this->validate();

        $this->prepareUserData();

        if(!$this->model_user_main->add($this->user_info)) {
            $this->response->jsonOutputExit('system_error');
        }

        $user_id = $this->model_user_main->getLastId();

        $this->prepareUserCredentialsData();

        $this->user_credentials_info['user_id'] = $user_id;

        $this->model_user_credentials->add($this->user_credentials_info);

        $this->response->jsonOutput('success', $this->setResponseData());
    }

    private function validate()
    {
        // email
        $email = (!$this->request->getHttpPost('email')) ? $this->response->jsonOutputExit('empty_email') : $this->request->getHttpPost('email');
        if(!$this->request->isEmail($email)) {
            $this->response->jsonOutputExit('invalid_email');
        }

        // 判断email是否已存在
        $user_info = $this->model_user_main->fetchOne(array('email'=>$email));
        if(is_array($user_info) && !empty($user_info)) {
            $this->response->jsonOutputExit('email_already_exist');
        }

        // password
        $password = (!$this->request->getHttpPost('password')) ? $this->response->jsonOutputExit('empty_password') : $this->request->getHttpPost('password');
        if((utf8_strlen($password) > 30) || (utf8_strlen($password) < 6)) {
            $this->response->jsonOutputExit('invalid_password_length');
        }

        // name
        if($this->request->getHttpPost('name') && ((utf8_strlen($this->request->getHttpPost('name')) > 50) || (utf8_strlen($this->request->getHttpPost('name')) < 2))) {
            $this->response->jsonOutputExit('invalid_name_length');
        }

        // group_id
        if($this->request->getHttpPost('group_id') !== false) {
            $this->checkUserGroup($this->request->getHttpPost('parent_user_id'), $this->request->getHttpPost('group_id'));
        }
    }

    private function prepareUserData()
    {
        $this->user_info['email'] = $this->request->getHttpPost('email');
        $this->user_info['name'] = $this->request->getHttpPost('name');
        $this->user_info['parent_user_id'] = $this->request->getHttpPost('parent_user_id', 0);
        $this->user_info['group_id'] = $this->request->getHttpPost('group_id', 1);
        $this->user_info['salt'] = $this->model_user_main->getUserSalt();
        $this->user_info['password'] = $this->model_user_main->getUserPassword($this->request->getHttpPost('password'), $this->user_info['salt']);
        $this->user_info['role'] = $this->request->getHttpPost('role', 1);
        $this->user_info['status'] = 1;
        $this->user_info['add_timestamp'] = $this->timestamp;
    }

    private function prepareUserCredentialsData()
    {
        $this->user_credentials_info['client_id'] = $this->config->get('client_id');
        $this->user_credentials_info['user_key'] = $this->model_user_main->getUserKey();
        $this->user_credentials_info['user_secret'] = $this->model_user_main->getUserSecret();
        $this->user_credentials_info['status'] = 1;
        $this->user_credentials_info['add_timestamp'] = $this->timestamp;
    }

    private function setResponseData()
    {
        return array(
            'user_info' => array(
                'user_id' => $this->user_credentials_info['user_id'],
                'name' => $this->user_info['name'],
                'email' => $this->user_info['email'],
                'parent_user_id' => $this->user_info['parent_user_id'],
                'client_id' => $this->user_credentials_info['client_id'],
                'group_id' => $this->user_info['group_id'],
                'role' => $this->user_info['role'],
                'user_key' => $this->user_credentials_info['user_key'],
                'user_secret' => $this->user_credentials_info['user_secret']
            )
        );
    }
}
