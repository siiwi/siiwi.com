<?php

/**
 * Class ControllerPlatformGet
 *
 * 获取国家列表API接口
 *
 * @method GET
 *
 * @param $language_id
 */
class ControllerPlatformGet extends \Siiwi\Api\Controller
{
    private $where_array = array();

    public function index()
    {
        $this->isGet();

        $this->load->model('global/token');
        $this->load->model('global/platform');

        $this->verifyToken();

        $this->prepareWhereArr();

        $this->platform_list = $this->model_global_platform->fetchAll($this->where_array);

        $this->response->jsonOutput('success', array('platform_list'=>$this->platform_list));
    }

    private function prepareWhereArr()
    {
        $this->where_array['language_id'] = $this->request->getHttpGet('language_id', 1);

        if($this->request->getHttpGet('status') !== false) {
            $this->where_array['status'] = $this->request->getHttpGet('status');
        }
    }
}
