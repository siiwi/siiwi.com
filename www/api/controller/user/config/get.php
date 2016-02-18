<?php

/**
 * Class ControllerUserConfigGet
 * 获取用户配置信息API接口
 *
 * @method GET
 * @param string $user_config_key
 * @param int $status
 */
class ControllerUserConfigGet extends \Siiwi\Api\Controller
{
    private $where_array = array();
    private $config_list = array();

    public function index()
    {
        $this->isGet();

        $this->load->model('global/token');
        $this->load->model('user/main');
        $this->load->model('user/config');

        $this->verifyToken();

        $this->prepareWhereArr();

        $this->pagination();

        $this->config_list = $this->model_user_config->fetchAll($this->where_array);

        $this->response->jsonOutput('success', $this->setResponseData());
    }

    private function prepareWhereArr()
    {
        $this->where_array['user_id'] = $this->getParentUserId();

        $this->where_array['client_id'] = $this->config->get('client_id');

        if($this->request->getHttpGet('user_config_key') !== false) {
            $this->where_array['key'] = $this->request->getHttpGet('user_config_key');
        }

        if($this->request->getHttpGet('status') !== false) {
            $this->where_array['status'] = $this->request->getHttpGet('status');
        }
    }

    private function setResponseData()
    {
        $data = array();

        if(is_array($this->config_list) && !empty($this->config_list)) {
            foreach($this->config_list as $config_info) {
                $data[$config_info['key']] = json_decode($config_info['value'], true);
            }
        }

        return array(
            'config_list' => $data
        );
    }
}