<?php
class ControllerAccountForget extends Controller {
	public function index() {
		$data['title'] = '账户取回 | 最好用的电商管理工具 - Siiwi.com';
		$this->response->setOutput($this->load->view('account/forget.html', $data));
	}
	
}