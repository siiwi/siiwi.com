<?php
class ControllerAccountLogin extends Controller {
	public function index() {
		$this->document->setTitle('账户登录 | 最好用的电商管理工具 - Siiwi.com');
		
		$this->document->addStyle('/assets/css/bootstrap.min.css');
		$this->document->addScript('/assets/plugins/light-gallery/lightGallery.min.js');

		
		
		$this->response->setOutput($this->load->view('account/login.html', $data=array()));
	}
	
	public function logout(){
		
	}
	
}