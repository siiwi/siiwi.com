<?php
class ControllerFrameHeader extends Controller {
	public function index() {
		$data = array();
		$data['logo'] = $this->load->controller('frame/header/logo');
		$data['language'] = $this->load->controller('frame/header/language');
		return $this->load->view('frame/header.html', $data);
	}
	public function logo(){
		$data = array();
		$data['title'] = 'Dashboard';
		$data['img'] = '/assets/img/logo.png';
		$data['url'] = '/';
		return $this->load->view('frame/header/logo.html', $data);
	}
	public function language(){
		$data = array();
		
		return $this->load->view('frame/header/language.html', $data);
	}
}