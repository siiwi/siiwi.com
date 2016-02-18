<?php
class ControllerFrameFrameFooter extends Controller {
	public function index() {
		$data['scripts'] = $this->document->getScripts();
		return $this->load->view('frame/frame_footer.html', $data);
	}
}