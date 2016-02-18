<?php
class ControllerFrameFrameHeader extends Controller {
	public function index() {
		$data['title'] = $this->document->getTitle();
		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');
		$data['styles'] = $this->document->getStyles();
		
		return $this->load->view('frame/frame_header.html', $data);
	}
}