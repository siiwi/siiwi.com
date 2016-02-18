<?php

/**
 * Class ControllerUserStoreAdd
 * 为子账户添加授权店铺API接口
 *
 * @method POST
 * @param int $user_id
 * @param int $store_id
 */
class ControllerUserStoreAdd extends \Siiwi\Api\Controller
{
    private $user_store_info = array();

    public function index()
    {
        $this->isPost();

        $this->load->model('global/token');
        $this->load->model('user/main');
        $this->load->model('user/store');
        $this->load->model('store/main');

        $this->verifyToken();

        $this->verifySuperUser();

        $this->validate();

        $this->prepareUserStoreData();

        if(!$this->model_user_store->add($this->user_store_info)) {
            $this->response->jsonOutputExit('system_error');
        }

        $this->response->jsonOutput('success', $this->setResponseData());
    }

    private function validate()
    {
        // 判断子账户是否属于当前超级用户
        $user_id = ($this->request->getHttpPost('user_id') === false) ? $this->response->jsonOutputExit('empty_sub_account') : $this->request->getHttpPost('user_id');
        $user_info = $this->model_user_main->fetchOne(array('user_id'=>$user_id));
        if(!is_array($user_info) || empty($user_info)) {
            $this->response->jsonOutputExit('invalid_sub_account');
        }

        if(($user_info['role'] != 2) || ($user_info['parent_user_id'] != $this->config->get('user_id'))) {
            $this->response->jsonOutputExit('user_not_allowed');
        }

        // 判断店铺是否属于当前超级用户
        $store_id = ($this->request->getHttpPost('store_id') === false) ? $this->response->jsonOutputExit('empty_store_id') : $this->request->getHttpPost('store_id');
        $store_info = $this->model_store_main->fetchOne(array('user_id'=>$this->config->get('user_id'), 'store_id'=>$store_id));
        if(!is_array($store_info) || empty($store_info)) {
            $this->response->jsonOutputExit('invalid_store_id');
        }
    }

    private function prepareUserStoreData()
    {
        $this->user_store_info['user_id'] = $this->request->getHttpPost('user_id');
        $this->user_store_info['store_id'] = $this->request->getHttpPost('store_id');
        $this->user_store_info['status'] = 1;
        $this->user_store_info['add_timestamp'] = time();
    }

    private function setResponseData()
    {
        return array(
            'user_store_info' => $this->user_store_info
        );
    }
}