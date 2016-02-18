<?php

/**
 * Class ControllerBrandGet
 *
 * 获取品牌列表或品牌信息API接口
 *
 * @method GET
 *
 * @param int $brand_id
 * @param int $status
 */
class ControllerBrandGet extends \Siiwi\Api\Controller
{
    private $where_array = array();
    private $brand_list = array();
    private $brand_total = 0;

    public function index()
    {
        $this->isGet();

        $this->load->model('global/token');
        $this->load->model('user/main');
        $this->load->model('brand/main');

        $this->verifyToken();

        $this->prepareWhereArr();

        $this->pagination();

        $this->brand_list = $this->model_brand_main->fetchAll($this->where_array, $this->limit_array);

        $this->brand_total = $this->model_brand_main->count($this->where_array);

        $this->response->jsonOutput('success', $this->setResponseData());
    }

    private function prepareWhereArr()
    {
        $this->where_array['user_id'] = $this->getParentUserId();

        if($this->request->getHttpGet('brand_id') !== false) {
            $this->where_array['brand_id'] = $this->request->getHttpGet('brand_id');
        }

        if($this->request->getHttpGet('status') !== false) {
            $this->where_array['status'] = $this->request->getHttpGet('status');
        }
    }

    private function setResponseData()
    {
        return array(
            'brand_list' => $this->brand_list,
            'brand_total' => $this->brand_total
        );
    }
}
