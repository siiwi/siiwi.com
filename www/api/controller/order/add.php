<?php

/**
 * Class ControllerOrderAdd
 * 添加订单API接口
 *
 * @method POST
 */
class ControllerOrderAdd extends \Siiwi\Api\Controller
{
    private $user_id;
    private $order_info = array();

    public function index()
    {
        $this->isPost();

        $this->load->model('global/token');
        $this->load->model('user/main');
        $this->load->model('global/platform');
        $this->load->model('order/main');

        $this->verifyToken();

        $this->user_id = $this->getParentUserId();

        $this->validate();

        $this->prepareOrderData();

        $result = $this->model_order_main->add($this->order_info);

        $this->response->jsonOutput('success', $result);
    }

    private function validate()
    {
        // 订单编号
        $order_sn = $this->request->getHttpPost('order_sn');
        if($order_sn === false || !$order_sn) {
            $this->response->jsonOutputExit('empty_order_sn');
        }

        // 订单平台
        $order_platform = $this->request->getHttpPost('order_platform');
        if($order_platform === false || !$order_platform) {
            $this->response->jsonOutputExit('empty_order_platform');
        }

        // 判断订单平台是否存在
        $platform_info = $this->model_global_platform->fetchOne(array('id'=>$order_platform, 'status'=>1));
        if(!is_array($platform_info) || empty($platform_info)) {
            $this->response->jsonOutputExit('invalid_order_platform');
        }

        // 判断订单号是否已存在
        $order_sn_exist = $this->model_order_main->count(array('user_id'=>$this->user_id, 'order_sn'=>$order_sn, 'order_platform'=>$order_platform));
        if($order_sn_exist) {
            $this->response->jsonOutputExit('order_sn_already_exist');
        }

        // 判断订单来源
        $order_from = $this->request->getHttpPost('order_from');
        if($order_from === false || !$order_from) {
            $this->response->jsonOutputExit('empty_order_from');
        }

        // 判断订单状态
        $order_status = $this->request->getHttpPost('order_status');
        if($order_status === false || !$order_status) {
            $this->response->jsonOutputExit('empty_order_status');
        }

        // 判断订单总价
        $total_cost = $this->request->getHttpPost('total_cost');
        if($total_cost === false) {
            $this->response->jsonOutputExit('empty_total_cost');
        }

        if(!is_numeric($total_cost) || $total_cost < 0) {
            $this->response->jsonOutputExit('invalid_total_cost');
        }

        // 判断快递总价
        $express_cost = $this->request->getHttpPost('express_cost');
        if($express_cost === false) {
            $this->response->jsonOutputExit('empty_express_cost');
        }

        if(!is_numeric($express_cost) || $express_cost < 0) {
            $this->response->jsonOutputExit('invalid_express_cost');
        }

        // 判断买家名称
        $buyer_name = $this->request->getHttpPost('buyer_name');
        if($buyer_name === false) {
            $this->response->jsonOutputExit('empty_buyer_name');
        }

        // 判断买家联系方式
        $buyer_contact = $this->request->getHttpPost('buyer_contact');
        if($buyer_contact === false) {
            $this->response->jsonOutputExit('empty_buyer_contact');
        }

        // 判断买家地址
        $buyer_address = $this->request->getHttpPost('buyer_address');
        if($buyer_address === false) {
            $this->response->jsonOutputExit('empty_buyer_address');
        }

        // 判断订单日期
        $order_date = $this->request->getHttpPost('order_date');
        if($buyer_address === false) {
            $this->response->jsonOutputExit('empty_order_date');
        }
    }

    private function prepareOrderData()
    {
        $this->order_info['order_sn']       = $this->request->getHttpPost('order_sn');
        $this->order_info['user_id']        = $this->user_id;
        $this->order_info['store_id']       = 0;
        $this->order_info['order_date']     = strtotime($this->request->getHttpPost('order_date'));
        $this->order_info['order_from']     = $this->request->getHttpPost('order_from');
        $this->order_info['order_platform'] = $this->request->getHttpPost('order_platform');
        $this->order_info['total_cost']     = $this->request->getHttpPost('total_cost');
        $this->order_info['total_cost']     = $this->request->getHttpPost('total_cost');
        $this->order_info['express_cost']   = $this->request->getHttpPost('express_cost');
        $this->order_info['buyer_name']     = $this->request->getHttpPost('buyer_name');
        $this->order_info['buyer_address']  = $this->request->getHttpPost('buyer_address');
        $this->order_info['buyer_contact']  = $this->request->getHttpPost('buyer_contact');
        $this->order_info['status']         = 1;
        $this->order_info['add_timestamp']  = time();
    }
}
