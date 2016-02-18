<?php
/**
 * Class ControllerAttributeDelete
 *
 * 删除一个分类规格API接口
 * 该接口仅超级用户才有权限访问
 *
 * @method DELETE
 *
 * @param int $category_id
 * @param string $name
 */
class ControllerAttributeDelete extends \Siiwi\Api\Controller
{
    public function index()
    {
        $this->isDelete();

        $this->load->model('global/token');
        $this->load->model('user/main');
        $this->load->model('category/main');
        $this->load->model('attribute/main');

        $this->verifyToken();

        $this->verifySuperUser();

        $this->validate();

        if(!$this->model_attribute_main->delete(array('category_id'=>$this->request->getHttpGet('category_id'), 'name'=>$this->request->getHttpGet('name'), 'user_id'=>$this->config->get('user_id')))) {
            $this->response->jsonOutputExit('system_error');
        }

        $this->response->jsonOutput('success');
    }

    private function validate()
    {
        $category_id = ($this->request->getHttpGet('category_id') === false) ? $this->response->jsonOutputExit('empty_category_id') : $this->request->getHttpGet('category_id');
        $category_info = $this->model_category_main->fetchAll(array('category_id'=>$category_id, 'user_id'=>$this->config->get('user_id')));
        if(!is_array($category_info) || empty($category_info) || (count($category_info) > 1)) {
            $this->response->jsonOutputExit('invalid_category_id');
        }

        $name = ($this->request->getHttpGet('name') === false) ? $this->response->jsonOutputExit('empty_name') : $this->request->getHttpGet('name');
        $attribute_info = $this->model_attribute_main->fetchAll(array('category_id'=>$category_id, 'name'=>$name, 'user_id'=>$this->config->get('user_id')));
        if(!is_array($attribute_info) || empty($attribute_info) || (count($attribute_info) > 1)) {
            $this->response->jsonOutputExit('invalid_name');
        }
    }
}