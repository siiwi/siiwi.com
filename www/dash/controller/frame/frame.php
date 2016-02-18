<?php
class ControllerFrameFrame extends Controller {
	public function index() {
		
		$data = array();
		$data['header'] = $this->load->controller('frame/header');
		$data['footer'] = $this->load->controller('frame/footer');
		$data['frame_header'] = $this->load->controller('frame/frameheader');
		$data['frame_footer'] = $this->load->controller('frame/framefooter');
		$data['main_nav'] = $this->load->controller('frame/mainnav');
		$data['aside'] = $this->load->controller('frame/aside');
		
		$st_breadcrumb = array();
		$st_breadcrumb['items'] = array(array('url'=>'http://www.com/','text'=>'hhh2'),array('url'=>'http://www.com/','text'=>'hhh1'),array('url'=>'http://www.com/','text'=>'hhh3'));
		$data['breadcrumb'] = $this->load->controller('component/breadcrumb',$st_breadcrumb);
		$this->response->setOutput($this->load->view('frame/frame.html', $data));
	}
}