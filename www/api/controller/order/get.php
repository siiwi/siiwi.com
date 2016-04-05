<?php

class ControllerOrderGet extends \Siiwi\Api\Controller
{
    private $where_array = array();
    private $order_list = array();

    public function index()
    {
        $this->isGet();

        $this->load->model('global/token');
        $this->load->model('user/main');
        $this->load->model('order/main');
        $this->load->model('order/sku');
        $this->load->model('product/sku');
        $this->load->model('product/resource');
        $this->load->model('product/main');
        $this->load->model('global/country');
        $this->load->model('global/orderstate');
        $this->load->model('global/platform');

        $this->verifyToken();

        $this->user_id = $this->getParentUserId();

        $this->prepareWhereArr();

        $this->pagination();

        $this->order_total = $this->model_order_main->count($this->where_array);

        if(!$this->order_total) {
            $this->response->jsonOutputExit('empty_order_list');
        }

        $this->order_list = $this->model_order_main->fetchAll($this->where_array, $this->limit_array);

        $this->response->jsonOutput('success', $this->setResponseData());
    }

    private function prepareWhereArr()
    {
        $this->where_array['user_id'] = $this->getParentUserId();

        if($this->request->getHttpGet('status') !== false) {
            $this->where_array['status'] = $this->request->getHttpGet('status');
        }
    }

    private function setResponseData()
    {
        if(is_array($this->order_list) && !empty($this->order_list)) {
            foreach($this->order_list as $k=>$order) {
                // 来源
                $order_from_name = $this->model_global_country->fetchOne(array('id'=>$order['order_from']));
                $this->order_list[$k]['order_from_name'] = $order_from_name['name'];

                // 平台
                $order_platform_name = $this->model_global_platform->fetchOne(array('id'=>$order['order_platform']));
                $this->order_list[$k]['order_platform_name'] = $order_platform_name['name'];

                // 状态
                $order_orderstate_name = $this->model_global_orderstate->fetchOne(array('id'=>$order['order_status'], 'language_id'=>1));
                $this->order_list[$k]['order_status_name'] = $order_orderstate_name['name'];

                $order_sku_info = $this->model_order_sku->fetchAll(array('order_id'=>$order['id'], 'status'=>1));
                if(is_array($order_sku_info) && !empty($order_sku_info)) {
                    foreach($order_sku_info as $key=>$value) {
                        $sku_info = $this->model_product_sku->fetchOne(array('sku'=>$value['sku']));
                        $resource_info = $this->model_product_resource->fetchAll(array('product_id'=>$sku_info['product_id']));
                        $product_info = $this->model_product_main->fetchOne(array('product_id'=>$sku_info['product_id']));

                        $order_sku_info[$key]['name'] = $product_info['name'];
                        $order_sku_info[$key]['resource'] = $resource_info;
                    }
                }

                $this->order_list[$k]['sku'] = $order_sku_info;
            }
        }

        return array(
            'order_total' => $this->order_total,
            'order_list' => $this->order_list
        );
    }
}
