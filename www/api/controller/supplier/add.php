<?php

/**
 * Class ControllerSupplierAdd
 *
 * 添加供应商API接口
 *
 * @method POST
 * @param string $name
 * @param string $phone
 * @param string $contact
 * @param string $address
 * @param string $url
 * @param string $desc
 */
class ControllerSupplierAdd extends \Siiwi\Api\Controller
{
    private $supplier_info = array();

    public function index()
    {
        $this->isPost();

        $this->load->model('global/token');
        $this->load->model('user/main');
        $this->load->model('supplier/main');

        $this->verifyToken();

        $this->supplier_info['user_id'] = $this->getParentUserId();

        $this->validate();

        $this->prepareSupplierData();

        if(!$this->model_supplier_main->add($this->supplier_info)) {
            $this->response->jsonOutputExit('system_error');
        }

        $this->supplier_info['supplier_id'] = $this->model_supplier_main->getLastId();

        $this->response->jsonOutput('success', $this->setResponseData());
    }

    private function validate()
    {
        $name = ($this->request->getHttpPost('name') === false) ? $this->response->jsonOutputExit('empty_name') : $this->request->getHttpPost('name');
        if((utf8_strlen($name) > 50) || (utf8_strlen($name) < 2)) {
            $this->response->jsonOutputExit('invalid_name_length');
        }

        // 判断该供应商是否已存在
        $supplier_info = $this->model_supplier_main->fetchOne(array('user_id'=>$this->supplier_info['user_id'], 'name'=>$name));
        if(is_array($supplier_info) && !empty($supplier_info)) {
            $this->response->jsonOutputExit('supplier_already_exist');
        }

        $contact = ($this->request->getHttpPost('contact') === false) ? $this->response->jsonOutputExit('empty_contact') : $this->request->getHttpPost('contact');
        if((utf8_strlen($contact) > 50) || (utf8_strlen($contact) < 2)) {
            $this->response->jsonOutputExit('invalid_contact_length');
        }

        $phone = ($this->request->getHttpPost('phone') === false) ? $this->response->jsonOutputExit('empty_phone') : $this->request->getHttpPost('phone');
        if((utf8_strlen($phone) > 50) || (utf8_strlen($phone) < 2)) {
            $this->response->jsonOutputExit('invalid_phone_length');
        }
    }

    private function prepareSupplierData()
    {
        $this->supplier_info['name'] = $this->request->getHttpPost('name');
        $this->supplier_info['contact'] = $this->request->getHttpPost('contact');
        $this->supplier_info['phone'] = $this->request->getHttpPost('phone');
        $this->supplier_info['email'] = $this->request->getHttpPost('email', '');
        $this->supplier_info['url'] = $this->request->getHttpPost('url', '');
        $this->supplier_info['desc'] = $this->request->getHttpPost('desc', '');
        $this->supplier_info['address'] = $this->request->getHttpPost('address', '');
        $this->supplier_info['status'] = 1;
        $this->supplier_info['add_timestamp'] = time();
    }

    private function setResponseData()
    {
        return array(
            'supplier_info' => $this->supplier_info
        );
    }
}