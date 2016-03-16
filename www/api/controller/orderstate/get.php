<?php

/**
 * Class ControllerOrderstateGet
 *
 * 获取订单状态列表API接口
 *
 * @method GET
 *
 * @param $language_id
 */
class ControllerOrderstateGet extends \Siiwi\Api\Controller
{
    private $where_array = array();

    public function index()
    {
        $this->isGet();

        $this->load->model('global/token');
        $this->load->model('global/orderstate');

        $this->verifyToken();

        $this->prepareWhereArr();

        $this->orderstate_list = $this->model_global_orderstate->fetchAll($this->where_array);

        $this->response->jsonOutput('success', array('orderstate_list'=>$this->orderstate_list));
    }

    private function prepareWhereArr()
    {
        $this->where_array['language_id'] = $this->request->getHttpGet('language_id', 1);

        if($this->request->getHttpGet('status') !== false) {
            $this->where_array['status'] = $this->request->getHttpGet('status');
        }
    }
}
