<?php
class ControllerTradeOrder extends Controller {
	public function index() {
		$this->document->setTitle('订单列表 - 交易管理 - 控制台 - 电商服务平台');
		
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
		
		$data['content'] = $this->load->controller('trade/order/content');
		
		$st_breadcrumb = array();
		$st_breadcrumb['items'] = array(array('url'=>'/','text'=>'首页'),
										array('url'=>'/dashboard/','text'=>'控制台'),
										array('url'=>'/dashboard/?route=trade/order','text'=>'订单列表'));
		$data['breadcrumb'] = $this->load->controller('component/breadcrumb',$st_breadcrumb);
		$this->response->setOutput($this->load->view('trade/order.html', $data));
	}
	public function content() {
		$page = 1;
		$size = 10;
		if(isset($this->request->get['page'])){
			$page = $this->request->get['page'];
		}
		$data['search'] = $this->load->controller('trade/order/search');
		$data['add'] = $this->load->controller('trade/order/add');
		//=====start pagination
		$pagination_setting = array();
		$pagination_setting['id'] = time();
		$pagination_setting['total_page'] = 30;
		$pagination_setting['page'] = $page;
		$pagination_setting['size'] = 10;
		$pagination_setting['link'] = '/dashboard/?route=trade/order';
		$data['pagination'] = $this->load->controller('component/pagination', $pagination_setting);
		//=====end pagination
		
		return $this->load->view('trade/order/content.html', $data);
	}
	public function search(){
		$data = array();
		return $this->load->view('trade/order/search.html', $data);
	}
	public function add(){
		$data = array();
		$data['add_product'] = $this->load->controller('trade/order/add_product');
		return $this->load->view('trade/order/add.html', $data);
	}
	
	public function add_product(){
		$data = array();
		$data['id'] = 'order_add_product_'.time();
		return $this->load->view('trade/order/add/add_product.html',$data);
	}
}