<?php
class ControllerHelpFqa extends Controller {
	public function index() {
		$this->document->setTitle('FAQ - 最好用的电商服务平台');

		$data['content'] = $this->load->controller('help/fqa/content');
		
		$this->response->setOutput($this->load->view('help/fqa.html', $data));
	}
	public function content() {
		return $this->load->view('help/fqa/content.html', $data=array());
	}
	public function upc(){
		echo 'upc';
	}
	
}