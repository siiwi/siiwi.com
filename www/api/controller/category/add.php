<?php

/**
 * Class ControllerCategoryAdd
 *
 * 添加产品类别信息API
 *
 * @method POST
 *
 * @param string $name
 * @param int $parent_category_id
 */
class ControllerCategoryAdd extends \Siiwi\Api\Controller
{
    private $category_info = array();
    private $category_description_info = array();
    private $timestamp;

    public function index()
    {
        $this->isPost();

        $this->timestamp = time();

        $this->load->model('global/token');
        $this->load->model('user/main');
        $this->load->model('category/main');
        $this->load->model('category/description');

        $this->verifyToken();

        $this->category_info['user_id'] = $this->getParentUserId();

        $this->validate();

        $this->prepareCategoryData();

        if(!$this->model_category_main->add($this->category_info)) {
            $this->response->jsonOutputExit('system_error');
        }

        $this->category_info['category_id'] = $this->model_category_main->getLastId();

        $this->prepareCategoryDescriptionData();

        $this->model_category_description->add($this->category_description_info);

        $this->response->jsonOutput('success', $this->setResponseData());
    }

    private function validate()
    {
        // name
        $name = (!$this->request->getHttpPost('name')) ? $this->response->jsonOutputExit('empty_name') : $this->request->getHttpPost('name');
        if((utf8_strlen($name) > 50) || (utf8_strlen($name) < 2)) {
            $this->response->jsonOutputExit('invalid_name_length');
        }

        // 判断传入的父级分类是否有权限添加子分类
        if($this->request->getHttpPost('parent_category_id')) {
            $parent_category_info = $this->model_category_main->fetchOne(array('category_id'=>$this->request->getHttpPost('parent_category_id')));
            if(!is_array($parent_category_info) || empty($parent_category_info) || $parent_category_info['parent_category_id']) {
                $this->response->jsonOutputExit('invalid_parent_category_id');
            }

            if(($parent_category_info['type'] == 2) && ($this->category_info['user_id'] != $parent_category_info['user_id'])) {
                $this->response->jsonOutputExit('user_not_allowed');
            }
        }
    }

    private function prepareCategoryData()
    {
        $this->category_info['parent_category_id'] = $this->request->getHttpPost('parent_category_id', 0);
        $this->category_info['type'] = 2;
        $this->category_info['status'] = 1;
        $this->category_info['add_timestamp'] = $this->timestamp;
    }

    private function prepareCategoryDescriptionData()
    {
        $this->category_description_info['category_id'] = $this->category_info['category_id'];
        $this->category_description_info['language_id'] = 0;
        $this->category_description_info['name']        = $this->request->getHttpPost('name');
    }

    private function setResponseData()
    {
        $data                = $this->category_info;
        $data['name']        = $this->category_description_info['name'];
        $data['language_id'] = 0;

        return array(
                'category_info' => $data
            );
    }
}