<?php

/**
 * Class ControllerBrandUpdate
 *
 * 更新品牌信息API接口
 */
class ControllerBrandUpdate extends \Siiwi\Api\Controller
{
    private $brand_info = array();
    private $where_array = array();

    public function index()
    {
        $this->isPut();

        $this->load->model('global/token');
        $this->load->model('user/main');
        $this->load->model('brand/main');

        $this->verifyToken();

        $this->validate();

        $this->prepareBrandData();

        if(!is_array($this->brand_info) || empty($this->brand_info)) {
            $this->response->jsonOutputExit('empty_update_brand_info');
        }

        if(!$this->model_brand_main->update($this->brand_info, $this->where_array)) {
            $this->response->jsonOutputExit('system_error');
        }

        $this->response->jsonOutput('success');
    }

    private function validate()
    {
        $parent_user_id = $this->getParentUserId();

        $brand_id   = ($this->request->getHttpGet('brand_id') === false) ? $this->response->jsonOutputExit('empty_brand_id') : $this->request->getHttpGet('brand_id');
        $brand_info = $this->model_brand_main->fetchAll(array('brand_id'=>$brand_id, 'user_id'=>$parent_user_id));
        if(!is_array($brand_info) || empty($brand_info) || (count($brand_info) > 1)) {
            $this->response->jsonOutputExit('invalid_brand_id');
        }

        $this->where_array['brand_id'] = $brand_id;
        $this->where_array['user_id']  = $parent_user_id;
    }

    private function prepareBrandData()
    {
        if($this->request->getHttpPost('name')) {
            $name = $this->request->getHttpPost('name');
            $brand_info = $this->model_brand_main->fetchOne(array('name'=>$name, 'user_id'=>$this->where_array['user_id']));
            if(is_array($brand_info) && !empty($brand_info)) {
                $this->response->jsonOutputExit('brand_already_exist');
            }
            $this->brand_info['name'] = $name;
        }

        if($this->request->getHttpPost('status') !== false) {
            $this->brand_info['status'] = $this->request->getHttpPost('status');
        }
    }
}
