<?php

/**
 * Class ControllerStoreGet
 *
 * 获取店铺列表API接口
 *
 * @method GET
 *
 * @param $store_id
 * @param $name
 * @param $status
 * @param $page
 * @param $page_size
 */
class ControllerStoreGet extends \Siiwi\Api\Controller
{
    private $where_array = array();
    private $store_lists = array();

    public function index()
    {
        $this->isGet();

        $this->load->model('global/token');
        $this->load->model('user/main');
        $this->load->model('store/main');
        $this->load->model('user/store');

        $this->verifyToken();

        $this->prepareWhereArr();

        $this->pagination();

        $this->store_lists = $this->model_user_store->fetchAll($this->where_array, $this->limit_array);

        $this->response->jsonOutput('success', $this->setResponseData());
    }

    private function prepareWhereArr()
    {
        $this->where_array['user_id'] = $this->config->get('user_id');

        if($this->request->getHttpGet('store_id') !== false) {
            $this->where_array['store_id'] = $this->request->getHttpGet('store_id');
        }

        if($this->request->getHttpGet('status') !== false) {
            $this->where_array['status'] = $this->request->getHttpGet('status');
        }
    }

    private function setResponseData()
    {
        $data = array();

        if(is_array($this->store_lists) && !empty($this->store_lists)) {
            foreach($this->store_lists as $key=>$value) {
                $store_info = $this->model_store_main->fetchOne(array('store_id'=>$value['store_id']));
                $data[$key]['store_id'] =  $store_info['store_id'];
                $data[$key]['name'] =  $store_info['name'];
                $data[$key]['desc'] =  $store_info['desc'];
                $data[$key]['url'] =  $store_info['url'];
                $data[$key]['logo'] =  $store_info['logo'];
            }
        }

        return array('store_list' => $data);
    }
}