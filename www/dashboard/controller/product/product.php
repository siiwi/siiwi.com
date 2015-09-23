<?php
class ControllerProductProduct extends Controller {
	public function json(){
		$this->response->setOutput('{"category":[
								   {"id":12,"is_parent":true,"name":"服装类","parent_id":0},
								   {"id":13,"is_parent":true,"name":"其他分类","parent_id":0},
								   {"id":14,"is_parent":true,"name":"美食类","parent_id":0},
								   {"id":121,"is_parent":false,"name":"内衣","parent_id":12},
								   {"id":122,"is_parent":false,"name":"牛仔裤","parent_id":12},
								   {"id":123,"is_parent":false,"name":"西装","parent_id":12},
								   {"id":131,"is_parent":false,"name":"儿童玩具","parent_id":13},
								   {"id":132,"is_parent":false,"name":"艺术品","parent_id":13}
								   ]}');
	}
	public function index() {
		$this->document->setTitle('产品管理 - 控制台 - 电商服务平台');
		
		$this->document->addStyle('/assets/plugins/light-gallery/lightGallery.min.css');
		$this->document->addStyle('/assets/plugins/chosen/chosen.min.css');
		$this->document->addStyle('/assets/plugins/sweet-alert/sweetalert.css');
		
		$this->document->addScript('/assets/plugins/chosen/chosen.jquery.min.js');
		$this->document->addScript('/assets/plugins/light-gallery/lightGallery.min.js');
		$this->document->addScript('/assets/plugins/sweet-alert/sweetalert.min.js');
		
		$data['header'] = $this->load->controller('frame/header');
		$data['footer'] = $this->load->controller('frame/footer');
		$data['frame_header'] = $this->load->controller('frame/frameheader');
		$data['frame_footer'] = $this->load->controller('frame/framefooter');
		$data['main_nav'] = $this->load->controller('frame/mainnav');
		$data['aside'] = $this->load->controller('frame/aside');
		
		$data['content'] = $this->load->controller('product/product/content');
		
		$st_breadcrumb = array();
		$st_breadcrumb['items'] = array(array('url'=>'/','text'=>'首页'),
										array('url'=>'/dashboard/','text'=>'控制台'),
										array('url'=>'/dashboard/?route=product/product','text'=>'产品列表'));
		$data['breadcrumb'] = $this->load->controller('component/breadcrumb',$st_breadcrumb);
		$this->response->setOutput($this->load->view('product/product.html', $data));
	}
	public function content() {
		$page = 1;
		$size = 10;
		if(isset($this->request->get['page'])){
			$page = $this->request->get['page'];
		}
		$data['search'] = $this->load->controller('product/product/search');
		$data['add'] = $this->load->controller('product/product/add');
		//=====start pagination
		$pagination_setting = array();
		$pagination_setting['id'] = time();
		$pagination_setting['total_page'] = 30;
		$pagination_setting['page'] = $page;
		$pagination_setting['size'] = 10;
		$pagination_setting['link'] = '/dashboard/?route=product/product';
		$data['pagination'] = $this->load->controller('component/pagination', $pagination_setting);
		//=====end pagination
		
		return $this->load->view('product/product/content.html', $data);
	}
	public function search(){
		$data = array();
		return $this->load->view('product/product/search.html', $data);
	}
	public function add(){
		$data = array();
		$data['variation_manage'] = $this->load->controller('product/product/variation_manage');
		return $this->load->view('product/product/add.html', $data);
	}
	public function variation_manage(){
		$data = array();
		$data['id'] = 'product_manage_variation_'.time();
		return $this->load->view('product/product/variation_manage.html',$data);
	}
}