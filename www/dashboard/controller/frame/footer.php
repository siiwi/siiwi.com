<?php
class ControllerFrameFooter extends Controller {
	public function index() {
		$data = array();
		return $this->load->view('frame/footer.html', $data);
	}
}