<?php
class ControllerComponentBreadCrumb extends Controller {
	public function index($setting) {
		if(isset($setting['id'])){
			$data['id'] = 'breadcrumb_'.$setting['id'];
		}else{
			$data['id'] = 'breadcrumb_'.time();
		}
		if(isset($setting['items'])){
			$data['items'] = $setting['items'];
		}else{
			echo 'error';
			return;
		}
        return $this->load->view('component/breadcrumb/s-0.html',$data);
	}
    
}