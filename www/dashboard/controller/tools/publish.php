<?php
class ControllerToolsPublish extends Controller {
	public function index() {
		$this->document->setTitle('刊登工具 - 应用工具 - 控制台 - 电商服务平台');
		
		$this->document->addStyle('/assets/plugins/light-gallery/lightGallery.min.css');
		$this->document->addScript('/assets/plugins/light-gallery/lightGallery.min.js');
		$this->document->addStyle('/assets/plugins/chosen/chosen.min.css');
		$this->document->addScript('/assets/plugins/chosen/chosen.jquery.min.js');
		$this->document->addStyle('/assets/plugins/sweet-alert/sweetalert.css');
		$this->document->addScript('/assets/plugins/sweet-alert/sweetalert.min.js');
		$this->document->addStyle('/assets/plugins/dropzone/dropzone.min.css');
		$this->document->addScript('/assets/plugins/dropzone/dropzone.min.js');
		$this->document->addStyle('/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css');
		$this->document->addScript('/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js');
		
		$data['header'] = $this->load->controller('frame/header');
		$data['footer'] = $this->load->controller('frame/footer');
		$data['frame_header'] = $this->load->controller('frame/frameheader');
		$data['frame_footer'] = $this->load->controller('frame/framefooter');
		$data['main_nav'] = $this->load->controller('frame/mainnav');
		$data['aside'] = $this->load->controller('frame/aside');
		
		$data['content'] = $this->load->controller('tools/publish/content');
		
		$st_breadcrumb = array();
		$st_breadcrumb['items'] = array(array('url'=>'/','text'=>'首页'),
										array('url'=>'/dashboard/','text'=>'控制台'),
										array('url'=>'/dashboard/?route=tools/publish','text'=>'刊登工具'));
		$data['breadcrumb'] = $this->load->controller('component/breadcrumb',$st_breadcrumb);
		$this->response->setOutput($this->load->view('tools/publish.html', $data));
	}
	public function content() {
		return $this->load->view('tools/publish/content.html', $data=array());
	}
	
}