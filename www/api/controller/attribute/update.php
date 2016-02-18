<?php
/**
 * Class ControllerAttributeUpdate
 *
 * 更新类别规格API
 *
 * @method POST
 *
 * @param int $category_id
 * @param string $name
 */
class ControllerAttributeUpdate extends \Siiwi\Api\Controller
{
    private $where_array = array();
    private $attribute_info = array();

    public function index()
    {
        $this->isPut();

        $this->load->model('global/token');
        $this->load->model('user/main');
        $this->load->model('attribute/main');

        $this->verifyToken();

        $this->validate();

        if(!$this->model_attribute_main->update($this->attribute_info, $this->where_array)) {
            $this->response->jsonOutputExit('system_error');
        }

        $this->response->jsonOutput('success');
    }

    private function validate()
    {
        // 规格名称
        $name = ($this->request->getHttpPost('name') === false) ? $this->response->jsonOutputExit('empty_name') : $this->request->getHttpPost('name');
        if((utf8_strlen($name) > 50) || (utf8_strlen($name) < 2)) {
            $this->response->jsonOutputExit('invalid_name_length');
        }

        // 规格ID
        $attribute_id   = ($this->request->getHttpGet('attribute_id') === false) ? $this->response->jsonOutputExit('empty_attribute_id') : $this->request->getHttpGet('attribute_id');
        $attribute_info = $this->model_attribute_main->fetchOne(array('attribute_id'=>$attribute_id, 'status'=>1, 'user_id'=>$this->getParentUserId()));
        if(!is_array($attribute_info) || empty($attribute_info)) {
            $this->response->jsonOutputExit('invalid_attribute_id');
        }

        $this->where_array['attribute_id'] = $attribute_id;
        $this->attribute_info['name'] = $name;
    }
}