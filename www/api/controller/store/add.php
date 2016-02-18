<?php

/**
 * Class ControllerStoreAdd
 * 添加店铺API接口
 * 该接口仅超级用户才有权限访问
 *
 * @method POST
 * @param string $name
 * @param string $desc
 * @param string $url
 * @param string $logo
 */
class ControllerStoreAdd extends \Siiwi\Api\Controller
{
    private $store_info = array();
    private $user_store_info = array();
    private $timestamp;

    public function index()
    {
        $this->isPost();

        $this->timestamp = time();

        $this->load->model('global/token');
        $this->load->model('user/main');
        $this->load->model('user/store');
        $this->load->model('store/main');

        $this->verifyToken();

        $this->verifySuperUser();

        $this->validate();

        $this->prepareStoreData();

        if(!$this->model_store_main->add($this->store_info)) {
            $this->response->jsonOutputExit('system_error');
        }

        $this->store_info['store_id'] = $this->model_store_main->getLastId();

        $this->prepareUserStoreData();

        $this->model_user_store->add($this->user_store_info);

        $this->response->jsonOutput('success', $this->setResponseData());
    }

    private function validate()
    {
        // name
        $name = (!$this->request->getHttpPost('name')) ? $this->response->jsonOutputExit('empty_name') : $this->request->getHttpPost('name');
        if((utf8_strlen($name) > 50) || (utf8_strlen($name) < 2)) {
            $this->response->jsonOutputExit('invalid_name_length');
        }

        // 判断店铺名称是否已经存在
        $store_info = $this->model_store_main->fetchOne(array('user_id'=>$this->config->get('user_id'), 'name'=>$name));
        if(is_array($store_info) && !empty($store_info)) {
            $this->response->jsonOutputExit('store_already_exist');
        }
    }

    private function prepareStoreData()
    {
        $this->store_info['user_id'] = $this->config->get('user_id');
        $this->store_info['name'] = $this->request->getHttpPost('name');
        $this->store_info['desc'] = $this->request->getHttpPost('desc', '');
        $this->store_info['url'] = $this->request->getHttpPost('url', '');
        $this->store_info['logo'] = $this->request->getHttpPost('logo', '');
        $this->store_info['status'] = 1;
        $this->store_info['add_timestamp'] = $this->timestamp;
    }

    private function prepareUserStoreData()
    {
        $this->user_store_info['user_id'] = $this->config->get('user_id');
        $this->user_store_info['store_id'] = $this->store_info['store_id'];
        $this->user_store_info['status'] = 1;
        $this->user_store_info['add_timestamp'] = $this->timestamp;
    }

    private function setResponseData()
    {
        return array(
                'store_info' => $this->store_info
            );
    }
}