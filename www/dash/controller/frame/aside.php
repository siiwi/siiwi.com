<?php
class ControllerFrameAside extends Controller {
	public function index() {
		$data = array();
		return $this->load->view('frame/aside.html', $data);
	}
}