<?php

/**
 * Class ControllerCategoryDelete
 *
 * 删除一个自定义分类API接口
 * 该接口仅超级用户才有权限访问
 *
 * @method DELETE
 *
 * @param $category_id
 */

class ControllerCategoryDelete extends \Siiwi\Api\Controller
{
    public function index()
    {
        $this->isDelete();

        $this->load->model('global/token');
        $this->load->model('user/main');
        $this->load->model('category/main');

        $this->verifyToken();

        $this->verifySuperUser();

        $this->validate();

        if(!$this->model_category_main->delete(array('category_id'=>$this->request->getHttpGet('category_id'), 'user_id'=>$this->config->get('user_id'), 'type'=>2))) {
            $this->response->jsonOutputExit('system_error');
        }

        $this->response->jsonOutput('success');
    }

    private function validate()
    {
        $category_id = ($this->request->getHttpGet('category_id') === false) ? $this->response->jsonOutputExit('empty_category_id') : $this->request->getHttpGet('category_id');
        $category_info = $this->model_category_main->fetchAll(array('category_id'=>$category_id, 'user_id'=>$this->config->get('user_id'), 'type'=>2));
        if(!is_array($category_info) || empty($category_info) || (count($category_info) > 1)) {
            $this->response->jsonOutputExit('invalid_category_id');
        }
    }
}