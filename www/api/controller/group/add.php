<?php

/**
 * Class ControllerGroupAdd
 *
 * 添加用户组API接口
 *
 * @method POST
 *
 * @param string $name
 * @param int $user_id
 */
class ControllerGroupAdd extends \Siiwi\Api\Controller
{
    private $group_info = array();

    public function index()
    {
        $this->isPost();

        $this->load->model('global/token');
        $this->load->model('user/main');
        $this->load->model('group/main');

        $this->verifyToken();

        $this->verifySuperUser();

        $this->validate();

        $this->prepareGroupData();

        if(!$this->model_group_main->add($this->group_info)) {
            $this->response->jsonOutputExit('system_error');
        }

        $this->group_info['group_id'] = $this->model_group_main->getLastId();

        $this->response->jsonOutput('success', $this->setResponseData());
    }

    private function validate()
    {
        // name
        $name = (!$this->request->getHttpPost('name')) ? $this->response->jsonOutputExit('empty_name') : $this->request->getHttpPost('name');
        if((utf8_strlen($name) > 50) || (utf8_strlen($name) < 2)) {
            $this->response->jsonOutputExit('invalid_name_length');
        }

        // 判断组名是否已经存在
        $group_info = $this->model_group_main->fetchOne(array('user_id'=>$this->config->get('user_id'), 'name'=>$name));
        if(is_array($group_info) && !empty($group_info)) {
            $this->response->jsonOutputExit('group_already_exist');
        }
    }

    private function prepareGroupData()
    {
        $this->group_info['user_id'] = $this->config->get('user_id');
        $this->group_info['name'] = $this->request->getHttpPost('name');
        $this->group_info['desc'] = $this->request->getHttpPost('desc');
        $this->group_info['status'] = 1;
        $this->group_info['add_timestamp'] = time();
    }

    private function setResponseData()
    {
        return array(
            'group_info' => $this->group_info
        );
    }
}