<?php

/**
 * Class ControllerUserStoreDelete
 * 删除店铺授权API接口
 * 该接口仅超级用户才有权限访问
 *
 * @method DELETE
 * @param int $user_id
 * @param int $store_id
 */
class ControllerUserStoreDelete extends \Siiwi\Api\Controller
{
    private $user_store_info = array();

    public function index()
    {
        $this->isDelete();

        $this->load->model('global/token');
        $this->load->model('user/main');
        $this->load->model('user/store');
        $this->load->model('store/main');

        $this->verifyToken();

        $this->verifySuperUser();

        $this->validate();

        $this->prepareUserStoreData();

        if(!$this->model_user_store->delete($this->user_store_info)) {
            $this->response->jsonOutputExit('system_error');
        }

        $this->response->jsonOutput('success');
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

        // 判断记录是否存在
        $user_store_info = $this->model_user_store->fetchAll(array('user_id'=>$user_id, 'store_id'=>$store_id));
        if(!is_array($store_info) || empty($store_info) || (count($user_store_info) > 1)) {
            $this->response->jsonOutputExit('user_not_allowed');
        }
    }

    private function prepareUserStoreData()
    {
        $this->user_store_info['user_id'] = $this->request->getHttpPost('user_id');
        $this->user_store_info['store_id'] = $this->request->getHttpPost('store_id');
    }
}