<?php

/**
 * Class ControllerSupplierGet
 *
 * 获取供应商列表API接口
 *
 * @method GET
 * @param int $supplier_id
 * @param int $status
 * @param int $page
 * @param int $page_size
 */
class ControllerSupplierGet extends \Siiwi\Api\Controller
{
    private $where_array    = array();
    private $supplier_list  = array();
    private $supplier_total = 0;

    public function index()
    {
        $this->isGet();

        $this->load->model('global/token');
        $this->load->model('user/main');
        $this->load->model('supplier/main');

        $this->verifyToken();

        $this->prepareWhereArr();

        $this->pagination();

        $this->supplier_list = $this->model_supplier_main->fetchAll($this->where_array, $this->limit_array);

        $this->supplier_total = $this->model_supplier_main->count($this->where_array);

        $this->response->jsonOutput('success', $this->setResponseData());
    }

    private function prepareWhereArr()
    {
        $this->where_array['user_id'] = $this->getParentUserId();

        if($this->request->getHttpGet('supplier_id') !== false) {
            $this->where_array['supplier_id'] = $this->request->getHttpGet('supplier_id');
        }

        if($this->request->getHttpGet('status') !== false) {
            $this->where_array['status'] = $this->request->getHttpGet('status');
        }
    }

    private function setResponseData()
    {
        return array(
            'supplier_total' => $this->supplier_total,
            'supplier_list' => $this->supplier_list
        );
    }
}