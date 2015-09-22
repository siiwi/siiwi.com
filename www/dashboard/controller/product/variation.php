<?php
class ControllerProductVariation extends Controller {
	public function index() {
		$this->document->setTitle('产品规格属性管理 - 产品管理 - 控制台 - 电商服务平台');
		
		$this->document->addStyle('/assets/plugins/chosen/chosen.min.css');
		$this->document->addStyle('/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css');
		$this->document->addScript('/assets/plugins/chosen/chosen.jquery.min.js');
		$this->document->addScript('/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js');
		
		$data['header'] = $this->load->controller('frame/header');
		$data['footer'] = $this->load->controller('frame/footer');
		$data['frame_header'] = $this->load->controller('frame/frameheader');
		$data['frame_footer'] = $this->load->controller('frame/framefooter');
		$data['main_nav'] = $this->load->controller('frame/mainnav');
		$data['aside'] = $this->load->controller('frame/aside');
		
		$data['content'] = $this->load->controller('product/variation/content');
		
		$st_breadcrumb = array();
		$st_breadcrumb['items'] = array(array('url'=>'/','text'=>'首页'),
										array('url'=>'/dashboard/','text'=>'控制台'),
										array('url'=>'/dashboard/?route=product/category','text'=>'产品类别'),
										array('url'=>'/dashboard/?route=product/variation','text'=>'产品规格'));
		$data['breadcrumb'] = $this->load->controller('component/breadcrumb',$st_breadcrumb);
		$this->response->setOutput($this->load->view('product/variation.html', $data));
	}
	public function content() {
		$page = 1;
		$size = 10;
		if(isset($this->request->get['page'])){
			$page = $this->request->get['page'];
		}
		$data['variation_add'] = $this->load->controller('product/variation/add');
		//=====start pagination
		$pagination_setting = array();
		$pagination_setting['id'] = time();
		$pagination_setting['total_page'] = 30;
		$pagination_setting['page'] = $page;
		$pagination_setting['size'] = 10;
		$pagination_setting['link'] = '/dashboard/?route=product/variation';
		$data['pagination'] = $this->load->controller('component/pagination', $pagination_setting);
		//=====end pagination
		
		return $this->load->view('product/variation/content.html', $data);
	}
	public function add(){
		$data['id'] = 'variation_add_'.time();
		return $this->load->view('product/variation/add.html', $data);
	}
	
	
}