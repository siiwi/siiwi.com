<?php

/**
 * Class ControllerSupplierDelete
 * 删除供应商API接口
 *
 * @method DELETE
 * @param int $supplier_id
 */
class ControllerSupplierDelete extends \Siiwi\Api\Controller
{
    public function index()
    {
        $this->isDelete();

        $this->load->model('global/token');
        $this->load->model('user/main');
        $this->load->model('supplier/main');

        $this->verifyToken();

        $this->verifySuperUser();

        $this->validate();

        if(!$this->model_supplier_main->delete(array('supplier_id'=>$this->request->getHttpGet('supplier_id'), 'user_id'=>$this->config->get('user_id')))) {
            $this->response->jsonOutputExit('system_error');
        }

        $this->response->jsonOutput('success');
    }

    private function validate()
    {
        $supplier_id = ($this->request->getHttpGet('supplier_id') === false) ? $this->response->jsonOutputExit('empty_supplier_id') : $this->request->getHttpGet('supplier_id');
        $supplier_info = $this->model_supplier_main->fetchAll(array('supplier_id'=>$supplier_id, 'user_id'=>$this->config->get('user_id')));
        if(!is_array($supplier_info) || empty($supplier_info) || (count($supplier_info) > 1)) {
            $this->response->jsonOutputExit('invalid_supplier_id');
        }
    }
}