<?php
class ControllerAccountLogin extends Controller {
	public function index() {
		if(!$this->logout()){
			echo '登出失败';
		}
		$data['title'] = '账户登录 | 最好用的电商管理工具 - Siiwi.com';
		$this->response->setOutput($this->load->view('account/login.html', $data));
	}
	
	public function logout(){
		return true;
	}
	
}