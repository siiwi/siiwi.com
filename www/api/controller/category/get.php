<?php

/**
 * Class ControllerCategoryGet
 *
 * 获取产品类别列表API接口
 *
 * @method GET
 *
 * @param $parent_category_id
 * @param $category_id
 * @param $type
 * @param $status
 * @param $page
 * @param $page_size
 */

class ControllerCategoryGet extends \Siiwi\Api\Controller
{
    private $where_array = array();
    private $category_list = array();
    private $category_total = 0;

    public function index()
    {
        $this->isGet();

        $this->load->model('global/token');
        $this->load->model('user/main');
        $this->load->model('category/main');
        $this->load->model('category/description');

        $this->verifyToken();

        $this->prepareWhereArr();

        $this->pagination();

        $this->category_list = $this->model_category_main->fetchAll($this->where_array, $this->limit_array);

        $this->category_total = $this->model_category_main->count($this->where_array);

        $this->prepareCategoryDescriptionData();

        $this->response->jsonOutput('success', $this->setResponseData());
    }

    private function prepareWhereArr()
    {
        if($this->request->getHttpGet('parent_category_id') !== false) {
            $this->where_array['parent_category_id'] = $this->request->getHttpGet('parent_category_id');
        }
        
        if($this->request->getHttpGet('category_id') !== false) {
            $this->where_array['category_id'] = $this->request->getHttpGet('category_id');
        }

        if($this->request->getHttpGet('type') !== false) {
            $this->where_array['type'] = $this->request->getHttpGet('type');
        }

        if($this->request->getHttpGet('status') !== false) {
            $this->where_array['status'] = $this->request->getHttpGet('status');
        }

        if(($this->request->getHttpGet('type') != 1) && !$this->request->getHttpGet('category_id')) {
            $this->where_array['user_id'] = $this->getParentUserId();
        }
    }

    private function prepareCategoryDescriptionData()
    {
        if(is_array($this->category_list) || !empty($this->category_list)) {
            foreach($this->category_list as $key=>$value) {
                $language_id = ($value['type'] == 1) ? $this->request->getHttpGet('language_id', 1) : 0; // 自定义分类名称language_id = 0
                $category_description_info = $this->model_category_description->fetchOne(array('category_id'=>$value['category_id'], 'language_id'=>$language_id));
                $this->category_list[$key]['name'] = $category_description_info['name'];
                if($value['parent_category_id']) {
                    $language_id = $this->request->getHttpGet('language_id', 1); // 父级分类名称language_id != 0
                    $parent_category_description_info = $this->model_category_description->fetchOne(array('category_id'=>$value['parent_category_id'], 'language_id'=>$language_id));
                    $this->category_list[$key]['parent_category_name'] = $parent_category_description_info['name'];
                } else {
                    $this->category_list[$key]['parent_category_name'] = '-';
                }
            }
        }
    }

    private function setResponseData()
    {
        return array(
                'category_total' => $this->category_total,
                'category_list' => $this->category_list
            );
    }
}