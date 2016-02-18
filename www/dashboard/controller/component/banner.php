<?php
class ControllerComponentBanner extends Controller {
	public function index($setting) {
		
	}
    public function style($setting){
        $data['id'] = $setting['id'];
        return $this->load->view('component/banner/s-0.html',$data);
    }
}