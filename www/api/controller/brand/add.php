<?php

/**
 * Class ControllerBrandAdd
 *
 * 添加品牌API接口
 *
 * @method POST
 * @param string $name
 */
class ControllerBrandAdd extends \Siiwi\Api\Controller
{
    private $brand_info = array();

    public function index()
    {
        $this->isPost();

        $this->load->model('global/token');
        $this->load->model('user/main');
        $this->load->model('brand/main');

        $this->verifyToken();

        $this->brand_info['user_id'] = $this->getParentUserId();

        $this->validate();

        $this->prepareBrandData();

        if(!$this->model_brand_main->add($this->brand_info)) {
            $this->response->jsonOutputExit('system_error');
        }

        $this->brand_info['brand_id'] = $this->model_brand_main->getLastId();

        $this->response->jsonOutput('success', $this->setResponseData());
    }

    private function validate()
    {
        $name = ($this->request->getHttpPost('name') === false) ? $this->response->jsonOutputExit('empty_name') : $this->request->getHttpPost('name');
        if((utf8_strlen($name) > 50) || (utf8_strlen($name) < 2)) {
            $this->response->jsonOutputExit('invalid_name_length');
        }
        
        $brand_info = $this->model_brand_main->fetchOne(array('name'=>$name, 'status'=>1, 'user_id'=>$this->config->get('user_id')));
        if(is_array($brand_info) && !empty($brand_info)) {
            $this->response->jsonOutputExit('brand_already_exist');
        }
    }

    private function prepareBrandData()
    {
        $this->brand_info['name'] = $this->request->getHttpPost('name');
        $this->brand_info['status'] = 1;
        $this->brand_info['add_timestamp'] = time();
    }

    private function setResponseData()
    {
        return array(
                'brand_info' => $this->brand_info
        );
    }
}
