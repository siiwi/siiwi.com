<?php
class ControllerHomeHome extends Controller {
	public function index() {
		
		$this->document->setTitle('控制台 - 电商服务平台');
		$this->document->addScript('http://echarts.baidu.com/build/dist/echarts-all.js');
		
		$data['header'] = $this->load->controller('frame/header');
		$data['footer'] = $this->load->controller('frame/footer');
		$data['frame_header'] = $this->load->controller('frame/frameheader');
		$data['frame_footer'] = $this->load->controller('frame/framefooter');
		$data['main_nav'] = $this->load->controller('frame/mainnav');
		$data['aside'] = $this->load->controller('frame/aside');
		$data['content'] = $this->load->controller('home/home/content');
		
		$st_breadcrumb = array();
		$st_breadcrumb['items'] = array(array('url'=>'/','text'=>'首页'),array('url'=>'/dashboard/','text'=>'控制台'));
		$data['breadcrumb'] = $this->load->controller('component/breadcrumb',$st_breadcrumb);
		$this->response->setOutput($this->load->view('home/home.html', $data));
	}
	
	public function content() {
		$data = array();
		return $this->load->view('home/home_content.html', $data);
	}
}