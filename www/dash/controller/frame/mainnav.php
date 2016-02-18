<?php
class ControllerFrameMainNav extends Controller {
	public function index($setting) {
		
		$data = array();
		return $this->load->view('frame/main_nav.html', $data);
	}
	public function item(){
		
	}
}