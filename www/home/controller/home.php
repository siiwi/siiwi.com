<?php
class ControllerHome extends Controller {
	public function index() {
		$data['lang'] = $this->language->get('test');
		
		echo $data['lang'];
		echo '----<a href="/dashboard/">控制台</a>';
	}
}