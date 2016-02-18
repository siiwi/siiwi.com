<?php

/**
 * Class ControllerSupplierUpdate
 *
 * 更新供应商信息API接口
 */
class ControllerSupplierUpdate extends \Siiwi\Api\Controller
{
    private $supplier_info = array();
    private $where_array = array();

    public function index()
    {
        $this->isPut();

        $this->load->model('global/token');
        $this->load->model('user/main');
        $this->load->model('supplier/main');

        $this->verifyToken();

        $this->validate();

        $this->prepareSupplierData();

        if(!is_array($this->supplier_info) || empty($this->supplier_info)) {
            $this->response->jsonOutputExit('empty_update_supplier_info');
        }

        if(!$this->model_supplier_main->update($this->supplier_info, $this->where_array)) {
            $this->response->jsonOutputExit('system_error');
        }

        $this->response->jsonOutput('success');
    }

    private function validate()
    {
        $parent_user_id = $this->getParentUserId();

        $supplier_id = ($this->request->getHttpGet('supplier_id') === false) ? $this->response->jsonOutputExit('empty_supplier_id') : $this->request->getHttpGet('supplier_id');
        $supplier_info = $this->model_supplier_main->fetchAll(array('supplier_id'=>$supplier_id, 'user_id'=>$parent_user_id));
        if(!is_array($supplier_info) || empty($supplier_info) || (count($supplier_info) > 1)) {
            $this->response->jsonOutputExit('invalid_supplier_id');
        }

        $this->where_array['supplier_id'] = $supplier_id;
        $this->where_array['user_id'] = $parent_user_id;
    }

    private function prepareSupplierData()
    {
        if($this->request->getHttpPost('name')) {
            $this->supplier_info['name'] = $this->request->getHttpPost('name');
        }

        if($this->request->getHttpPost('contact')) {
            $this->supplier_info['contact'] = $this->request->getHttpPost('contact');
        }

        if($this->request->getHttpPost('phone')) {
            $this->supplier_info['phone'] = $this->request->getHttpPost('phone');
        }

        if($this->request->getHttpPost('email')) {
            $this->supplier_info['email'] = $this->request->getHttpPost('email');
        }

        if($this->request->getHttpPost('url')) {
            $this->supplier_info['url'] = $this->request->getHttpPost('url');
        }

        if($this->request->getHttpPost('desc')) {
            $this->supplier_info['desc'] = $this->request->getHttpPost('desc');
        }

        if($this->request->getHttpPost('address')) {
            $this->supplier_info['address'] = $this->request->getHttpPost('address');
        }
    }
}