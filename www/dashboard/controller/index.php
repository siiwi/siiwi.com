<?php
class ControllerIndex extends Controller {
	public function index() {
		$data['lang'] = $this->language->get('test');
		
		$setting = array();
		$setting['id'] = time();
		$data['banner'] = $this->load->controller('component/banner/style', $setting);
		
		$this->response->setOutput($this->load->view('home.html', $data));
	}
}