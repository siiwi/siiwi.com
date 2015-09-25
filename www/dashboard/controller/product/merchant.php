<?php
class ControllerProductMerchant extends Controller {
	public function index() {
		$this->document->setTitle('供应商管理 - 控制台 - 电商服务平台');
		
		//$this->document->addStyle('/assets/plugins/chosen/chosen.min.css');
		//$this->document->addStyle('/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css');
		$this->document->addStyle('/assets/plugins/sweet-alert/sweetalert.css');
		
		//$this->document->addScript('/assets/plugins/chosen/chosen.jquery.min.js');
		//$this->document->addScript('/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js');
		$this->document->addScript('/assets/plugins/sweet-alert/sweetalert.min.js');
		
		$data['header'] = $this->load->controller('frame/header');
		$data['footer'] = $this->load->controller('frame/footer');
		$data['frame_header'] = $this->load->controller('frame/frameheader');
		$data['frame_footer'] = $this->load->controller('frame/framefooter');
		$data['main_nav'] = $this->load->controller('frame/mainnav');
		$data['aside'] = $this->load->controller('frame/aside');
		
		$data['content'] = $this->load->controller('product/merchant/content');
		
		$st_breadcrumb = array();
		$st_breadcrumb['items'] = array(array('url'=>'/','text'=>'首页'),
										array('url'=>'/dashboard/','text'=>'控制台'),
										array('url'=>'/dashboard/?route=product/merchant','text'=>'供应商'));
		$data['breadcrumb'] = $this->load->controller('component/breadcrumb',$st_breadcrumb);
		$this->response->setOutput($this->load->view('product/merchant.html', $data));
	}
	public function content() {
		$page = 1;
		$size = 10;
		if(isset($this->request->get['page'])){
			$page = $this->request->get['page'];
		}
		$data['merchant_add'] = $this->load->controller('product/merchant/add');
		$data['merchant_edit'] = $this->load->controller('product/merchant/edit');
		//=====start pagination
		$pagination_setting = array();
		$pagination_setting['id'] = time();
		$pagination_setting['total_page'] = 30;
		$pagination_setting['page'] = $page;
		$pagination_setting['size'] = 10;
		$pagination_setting['link'] = '/dashboard/?route=product/merchant';
		$data['pagination'] = $this->load->controller('component/pagination', $pagination_setting);
		//=====end pagination
		
		return $this->load->view('product/merchant/content.html', $data);
	}
	public function add(){
		$data['id'] = 'add_merchant_'.time();
		return $this->load->view('product/merchant/add.html', $data);
	}
	public function edit(){
		$data['id'] = 'edit_merchant_'.time();
		return $this->load->view('product/merchant/edit.html', $data);
	}
	
}