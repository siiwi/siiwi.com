<?php

/**
 * Class ControllerGroupGet
 *
 * 获取用户组列表API接口
 * 该接口仅超级用户才有权限访问
 *
 * @method GET
 *
 * @param $group_id
 * @param $name
 * @param $status
 * @param $page
 * @param $page_size
 */
class ControllerGroupGet extends \Siiwi\Api\Controller
{
    private $where_array = array();
    private $group_list = array();

    public function index()
    {
        $this->isGet();

        $this->load->model('global/token');
        $this->load->model('user/main');
        $this->load->model('group/main');

        $this->verifyToken();

        $this->verifySuperUser();

        $this->prepareWhereArr();

        $this->pagination();

        $this->group_list = $this->model_group_main->fetchAll($this->where_array, $this->limit_array);

        $this->response->jsonOutput('success', $this->setResponseData());
    }

    private function prepareWhereArr()
    {
        $this->where_array['user_id'] = $this->config->get('user_id');

        if($this->request->getHttpGet('group_id') !== false) {
            $this->where_array['group_id'] = $this->request->getHttpGet('group_id');
        }

        if($this->request->getHttpGet('name') !== false) {
            $this->where_array['name'] = $this->request->getHttpGet('name');
        }

        if($this->request->getHttpGet('status') !== false) {
            $this->where_array['status'] = $this->request->getHttpGet('status');
        }
    }

    private function setResponseData()
    {
        $data = array();

        if(is_array($this->group_list) && !empty($this->group_list)) {
            foreach($this->group_list as $key=>$group_info) {
                $data[$key]['group_id'] =  $group_info['group_id'];
                $data[$key]['name'] =  $group_info['name'];
                $data[$key]['desc'] =  $group_info['desc'];
            }
        }

        return array('group_list' => $data);
    }
}