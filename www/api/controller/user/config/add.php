<?php

/**
 * Class ControllerUserConfigAdd
 * 添加用户配置信息API
 * 该接口仅超级用户才有权限访问
 *
 * @method POST
 * @param string $user_config_key
 * @param string|array|int $value
 */
class ControllerUserConfigAdd extends \Siiwi\Api\Controller
{
    private $allow_config_key = array('language_code');
    private $config_info = array();

    public function index()
    {
        $this->isPost();

        $this->load->model('global/token');
        $this->load->model('user/main');
        $this->load->model('user/config');

        $this->verifyToken();

        $this->verifySuperUser();

        $this->validate();

        $this->prepareConfigData();

        if(!$this->model_user_config->add($this->config_info)) {
            $this->response->jsonOutputExit('system_error');
        }

        $this->response->jsonOutput('success', $this->setResponseData());
    }

    private function validate()
    {
        $key = ($this->request->getHttpPost('user_config_key') !== false) ? $this->request->getHttpPost('user_config_key') : $this->response->jsonOutputExit('empty_user_config_key');

        if(!in_array($key, $this->allow_config_key)) {
            $this->response->jsonOutputExit('invalid_user_config_key');
        }

        $config_info = $this->model_user_config->fetchOne(array('user_id'=>$this->config->get('user_id'), 'client_id'=>$this->config->get('client_id'), 'key'=>$key));
        if(is_array($config_info) && !empty($config_info)) {
            $this->response->jsonOutputExit('user_config_key_already_exist');
        }
    }

    private function prepareConfigData()
    {
        $this->config_info['user_id'] = $this->config->get('user_id');
        $this->config_info['client_id'] = $this->config->get('client_id');
        $this->config_info['key'] = $this->request->getHttpPost('user_config_key');
        $this->config_info['value'] = json_encode($this->request->getHttpPost('value', ''));
        $this->config_info['status'] = 1;
    }

    private function setResponseData()
    {
        return array(
            'config_info' => $this->config_info
        );
    }
}