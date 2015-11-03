<?php
class ControllerSettingSubUsers extends Controller {
    public function index(){
		$this->document->setTitle('子账号管理 - 设置中心 - 电商服务平台');
		
		//$this->document->addStyle('/assets/plugins/chosen/chosen.min.css');
		//$this->document->addScript('/assets/plugins/chosen/chosen.jquery.min.js');
		
		$data['header'] = $this->load->controller('frame/header');
		$data['footer'] = $this->load->controller('frame/footer');
		$data['frame_header'] = $this->load->controller('frame/frameheader');
		$data['frame_footer'] = $this->load->controller('frame/framefooter');
		$data['main_nav'] = $this->load->controller('frame/mainnav');
		$data['aside'] = $this->load->controller('frame/aside');
		
		$data['content'] = $this->load->controller('setting/subusers/content');
		
		$st_breadcrumb = array();
		$st_breadcrumb['items'] = array(array('url'=>'/','text'=>'首页'),
										array('url'=>'/dashboard/','text'=>'控制台'),
										array('url'=>'/dashboard/?route=setting/setting','text'=>'设置中心'),
                                        array('url'=>'/dashboard/?route=setting/subusers','text'=>'子账号管理'));
		$data['breadcrumb'] = $this->load->controller('component/breadcrumb',$st_breadcrumb);
		$this->response->setOutput($this->load->view('setting/subusers.html', $data));
	}
	public function content() {
		return $this->load->view('setting/subusers/content.html', $data=array());
	}
}