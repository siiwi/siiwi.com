<?php

/**
 * Class ControllerBrandDelete
 *
 * 删除品牌API接口
 * 该接口仅超级用户才有权限访问
 *
 * @method DELETE
 * @param int $brand_id
 */
class ControllerBrandDelete extends \Siiwi\Api\Controller
{
    public function index()
    {
        $this->isDelete();

        $this->load->model('global/token');
        $this->load->model('user/main');
        $this->load->model('brand/main');

        $this->verifyToken();

        $this->verifySuperUser();

        $this->validate();

        if(!$this->model_brand_main->delete(array('brand_id'=>$this->request->getHttpGet('brand_id'), 'user_id'=>$this->config->get('user_id')))) {
            $this->response->jsonOutputExit('system_error');
        }

        $this->response->jsonOutput('success');
    }

    private function validate()
    {
        $brand_id =($this->request->getHttpGet('brand_id') === false) ? $this->response->jsonOutputExit('empty_brand_id') : $this->request->getHttpGet('brand_id');
        $brand_info = $this->model_brand_main->fetchAll(array('brand_id'=>$brand_id, 'user_id'=>$this->config->get('user_id')));
        if(!is_array($brand_info) || empty($brand_info) || (count($brand_info) > 1)) {
            $this->response->jsonOutputExit('invalid_brand_id');
        }
    }
}