<?php

class ControllerSkuGet extends \Siiwi\Api\Controller
{
    private $where_array = array();
    private $product_sku = array();

    public function index()
    {
        $this->isGet();

        $this->load->model('global/token');
        $this->load->model('user/main');
        $this->load->model('product/main');
        $this->load->model('product/sku');

        $this->verifyToken();

        $this->prepareWhereArr();

        $this->product_sku = $this->model_product_sku->fetchOne($this->where_array);
        if(!is_array($this->product_sku) || empty($this->product_sku)) {
            $this->response->jsonOutputExit('empty_product_sku_info');
        }

        $this->response->jsonOutput('success', $this->setResponseData());
    }

    private function prepareWhereArr()
    {
        $this->where_array['user_id'] = $this->getParentUserId();

        if($this->request->getHttpGet('sku') !== false) {
            $this->where_array['sku'] = $this->request->getHttpGet('sku');
        }

        if($this->request->getHttpGet('status') !== false) {
            $this->where_array['status'] = $this->request->getHttpGet('status');
        }
    }

    private function setResponseData()
    {
        $where['product_id'] = $this->product_sku['product_id'];
        $product_info = $this->model_product_main->fetchOne($where);

        return array(
            'product_sku_info' => array_merge($product_info, $this->product_sku)
        );
    }
}
