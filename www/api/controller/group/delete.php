<?php

/**
 * Class ControllerGroupDelete
 * 删除用户组API接口
 *
 * @method DELETE
 * @param int $group_id
 */
class ControllerGroupDelete extends \Siiwi\Api\Controller
{
    public function index()
    {
        $this->isDelete();

        $this->load->model('global/token');
        $this->load->model('user/main');
        $this->load->model('group/main');

        $this->verifyToken();

        $this->verifySuperUser();

        $this->validate();

        if(!$this->model_group_main->delete(array('group_id'=>$this->request->getHttpGet('group_id'), 'user_id'=>$this->config->get('user_id')))) {
            $this->response->jsonOutputExit('system_error');
        }

        $this->response->jsonOutput('success');
    }

    private function validate()
    {
        $group_id   = ($this->request->getHttpGet('group_id') === false) ? $this->response->jsonOutputExit('empty_group_id') : $this->request->getHttpGet('group_id');
        $group_info = $this->model_group_main->fetchAll(array('group_id'=>$group_id, 'user_id'=>$this->config->get('user_id')));
        if(!is_array($group_info) || empty($group_info) || (count($group_info) > 1)) {
            $this->response->jsonOutputExit('invalid_group_id');
        }
    }
}
?>
