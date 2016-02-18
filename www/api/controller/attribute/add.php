<?php
/**
 * Class ControllerAttributeAdd
 *
 * 添加类别规格API
 *
 * @method POST
 *
 * @param int $category_id
 * @param array $name
 */
class ControllerAttributeAdd extends \Siiwi\Api\Controller
{
    private $attribute_info = array();

    public function index()
    {
        $this->isPost();

        $this->load->model('global/token');
        $this->load->model('user/main');
        $this->load->model('category/main');
        $this->load->model('attribute/main');

        $this->verifyToken();

        $this->attribute_info['user_id'] = $this->getParentUserId();

        $this->validate();

        $this->prepareAttributeData();

        if(!$this->model_attribute_main->add($this->attribute_info)) {
            $this->response->jsonOutputExit('system_error');
        }

        $this->attribute_info['attribute_id'] = $this->model_attribute_main->getLastId();

        $this->response->jsonOutput('success', $this->setResponseData());
    }

    private function validate()
    {
        // 分类ID
        $category_id = ($this->request->getHttpPost('category_id') === false) ? $this->response->jsonOutputExit('empty_category_id') : $this->request->getHttpPost('category_id');

        // 判断用户是否有权限向该分类中添加规格
        $this->checkUserCategory($this->attribute_info['user_id'], $category_id);

        // 规格名称
        $name = (!$this->request->getHttpPost('name')) ? $this->response->jsonOutputExit('empty_name') : $this->request->getHttpPost('name');
        if((utf8_strlen($name) > 50) || (utf8_strlen($name) < 2)) {
            $this->response->jsonOutputExit('invalid_name_length');
        }

        // 判断规格名称是否已经存在
        $attribute_info = $this->model_attribute_main->fetchOne(array('user_id'=>$this->attribute_info['user_id'], 'name'=>$name, 'category_id'=>$category_id));
        if(is_array($attribute_info) && !empty($attribute_info)) {
            $this->response->jsonOutputExit('attribute_already_exist');
        }
    }

    private function prepareAttributeData()
    {
        $this->attribute_info['category_id'] = $this->request->getHttpPost('category_id');
        $this->attribute_info['name'] = $this->request->getHttpPost('name');
        $this->attribute_info['status'] = 1;
        $this->attribute_info['add_timestamp'] = time();
    }

    private function setResponseData()
    {
        return array(
                'attribute_info' => $this->attribute_info
            );
    }
}