<?php
class ControllerAccountRegister extends Controller {
	public function index() {
		$data['title'] = '账户注册 | 最好用的电商管理工具 - Siiwi.com';
		$this->response->setOutput($this->load->view('account/register.html', $data));
	}
	
	
	
}