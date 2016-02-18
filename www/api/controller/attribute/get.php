<?php

/**
 * Class ControllerAttributeGet
 *
 * 获取分类规格列表API接口
 *
 * @method GET
 * @param int $category_id
 */
class ControllerAttributeGet extends \Siiwi\Api\Controller
{
    private $where_array = array();
    private $attribute_list = array();

    public function index()
    {
        $this->isGet();

        $this->load->model('global/token');
        $this->load->model('user/main');
        $this->load->model('attribute/main');

        $this->verifyToken();

        $this->prepareWhereArr();

        $this->pagination();

        $this->attribute_list = $this->model_attribute_main->fetchAll($this->where_array, $this->limit_array);

        $this->response->jsonOutput('success', $this->setResponseData());
    }

    private function prepareWhereArr()
    {
        $category_id = ($this->request->getHttpGet('category_id') === false) ? $this->response->jsonOutputExit('empty_category_id') : $this->request->getHttpGet('category_id');

        $this->where_array['category_id'] = $category_id;

        $this->where_array['user_id'] = $this->getParentUserId();
    }

    private function setResponseData()
    {
        return array(
            'attribute_list' => $this->attribute_list
        );
    }
}