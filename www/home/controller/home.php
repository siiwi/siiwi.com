<?php
class ControllerHome extends Controller {
	public function index() {
		$data['lang'] = $this->language->get('test');
		
		echo $data['lang'];
	}
}