<?php

/**
 * Class ControllerCountryGet
 *
 * 获取国家列表API接口
 *
 * @method GET
 *
 * @param $language_id
 */
class ControllerCountryGet extends \Siiwi\Api\Controller
{
    private $where_array = array();

    public function index()
    {
        $this->isGet();

        $this->load->model('global/token');
        $this->load->model('global/country');

        $this->verifyToken();

        $this->prepareWhereArr();

        $this->country_list = $this->model_global_country->fetchAll($this->where_array);

        $this->response->jsonOutput('success', array('country_list'=>$this->country_list));
    }

    private function prepareWhereArr()
    {
        $this->where_array['language_id'] = $this->request->getHttpGet('language_id', 1);
    }
}
