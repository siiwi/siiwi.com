<?php

/**
 * Class ControllerCategoryUpdate
 *
 * 更新分类信息API接口
 *
 * @method PUT
 *
 * @param int $category_id
 * @param string $name
 */
class ControllerCategoryUpdate extends \Siiwi\Api\Controller
{
    private $where_array = array();
    private $category_description_array = array();

    public function index()
    {
        $this->isPut();

        $this->load->model('global/token');
        $this->load->model('user/main');
        $this->load->model('category/main');
        $this->load->model('category/description');

        $this->verifyToken();

        $this->validate();

        $this->prepareCategoryDescriptionData();

        if(!$this->model_category_description->update($this->category_description_array, $this->where_array)) {
            $this->response->jsonOutputExit('system_error');
        }

        $this->response->jsonOutput('success');
    }

    private function validate()
    {
        // name
        $name = (!$this->request->getHttpPost('name')) ? $this->response->jsonOutputExit('empty_name') : $this->request->getHttpPost('name');
        if((utf8_strlen($name) > 50) || (utf8_strlen($name) < 2)) {
            $this->response->jsonOutputExit('invalid_name_length');
        }

        $parent_user_id = $this->getParentUserId();

        $category_id = ($this->request->getHttpGet('category_id') === false) ? $this->response->jsonOutputExit('empty_category_id') : $this->request->getHttpGet('category_id');
        $category_info = $this->model_category_main->fetchOne(array('user_id'=>$parent_user_id, 'category_id'=>$category_id, 'type'=>2, 'status'=>1));
        if(!is_array($category_info) || empty($category_info)) {
            $this->response->jsonOutputExit('invalid_category_id');
        }

        $this->where_array['category_id'] = $category_id;
        $this->where_array['language_id'] = 0;
    }

    private function prepareCategoryDescriptionData()
    {
        $this->category_description_array['name'] = $this->request->getHttpPost('name');
    }
}