<?php

/**
 * Class ControllerProductUpdate
 *
 * 更新产品信息API接口
 */
class ControllerSkuUpdate extends \Siiwi\Api\Controller
{
    private $product_info = array();
    private $where_array = array();

    public function index()
    {
        $this->isPut();

        $this->load->model('global/token');
        $this->load->model('user/main');
        $this->load->model('product/sku');

        $this->verifyToken();

        $this->validate();

        $this->prepareProductData();

        if(!is_array($this->product_info) || empty($this->product_info)) {
            $this->response->jsonOutputExit('empty_update_product_info');
        }

        if(!$this->model_product_sku->update($this->product_info, $this->where_array)) {
            $this->response->jsonOutputExit('system_error');
        }

        $this->response->jsonOutput('success');
    }

    private function validate()
    {
        $parent_user_id = $this->getParentUserId();

        $sku  = ($this->request->getHttpGet('sku') === false) ? $this->response->jsonOutputExit('empty_product_sku') : $this->request->getHttpGet('sku');
        $sku_info = $this->model_product_sku->fetchAll(array('sku'=>$sku, 'user_id'=>$parent_user_id));
        if(!is_array($sku_info) || empty($sku_info) || (count($sku_info) > 1)) {
            $this->response->jsonOutputExit('invalid_product_sku');
        }

        $this->where_array['sku'] = $sku;
        $this->where_array['user_id']  = $parent_user_id;
    }

    private function prepareProductData()
    {
        if($this->request->getHttpPost('status') !== false) {
            $this->product_info['status'] = $this->request->getHttpPost('status');
        }

        if(($this->request->getHttpPost('stock') !== false) && ($this->request->getHttpPost('stock') >= 0)) {
            $this->product_info['stock'] = $this->request->getHttpPost('stock');
        }

        if(($this->request->getHttpPost('purchase_price') !== false) && ($this->request->getHttpPost('purchase_price') >= 0)) {
            $this->product_info['purchase_price'] = $this->request->getHttpPost('purchase_price');
        }
    }
}
