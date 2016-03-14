<?php

/**
 * Class ControllerProductUpdate
 *
 * 更新产品信息API接口
 */
class ControllerProductUpdate extends \Siiwi\Api\Controller
{
    private $product_info = array();
    private $where_array = array();

    public function index()
    {
        $this->isPut();

        $this->load->model('global/token');
        $this->load->model('user/main');
        $this->load->model('product/main');

        $this->verifyToken();

        $this->validate();

        $this->prepareProductData();

        if(!is_array($this->product_info) || empty($this->product_info)) {
            $this->response->jsonOutputExit('empty_update_product_info');
        }

        if(!$this->model_product_main->update($this->product_info, $this->where_array)) {
            $this->response->jsonOutputExit('system_error');
        }

        $this->response->jsonOutput('success');
    }

    private function validate()
    {
        $parent_user_id = $this->getParentUserId();

        $product_id   = ($this->request->getHttpGet('product_id') === false) ? $this->response->jsonOutputExit('empty_product_id') : $this->request->getHttpGet('product_id');
        $product_info = $this->model_product_main->fetchAll(array('product_id'=>$product_id, 'user_id'=>$parent_user_id));
        if(!is_array($product_info) || empty($product_info) || (count($product_info) > 1)) {
            $this->response->jsonOutputExit('invalid_product_id');
        }

        $this->where_array['product_id'] = $product_id;
        $this->where_array['user_id']    = $parent_user_id;
    }

    private function prepareProductData()
    {
        if($this->request->getHttpPost('status') !== false) {
            $this->product_info['status'] = $this->request->getHttpPost('status');
        }
    }
}
