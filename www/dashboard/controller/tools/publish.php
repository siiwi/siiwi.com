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
		$data['lists'] = $this->load->controller('tools/publish/lists');
		return $this->load->view('tools/publish/content.html', $data);
	}
	public function lists(){
		//=====start pagination
		$page = 1;
		$size = 10;
		if(isset($this->request->get['page'])){
			$page = $this->request->get['page'];
		}
		$pagination_setting = array();
		$pagination_setting['id'] = time();
		$pagination_setting['total_page'] = 30;
		$pagination_setting['page'] = $page;
		$pagination_setting['size'] = 10;
		$pagination_setting['link'] = '/dashboard/?route=tools/publish';
		$data['pagination'] = $this->load->controller('component/pagination', $pagination_setting);
		//=====end pagination
		return $this->load->view('tools/publish/lists.html', $data);
	}
	public function add(){
		$this->document->setTitle('刊登一个新商品 - 应用工具 - 控制台 - 电商服务平台');
		
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
		
		$data['content'] = $this->load->controller('tools/publish/add_content');
		
		$this->response->setOutput($this->load->view('tools/publish/add.html', $data));
	}
	public function add_content(){
		$data['selectItem'] = $this->load->controller('tools/publish/add_select_item');
		$data['baseInfo'] = $this->load->controller('tools/publish/add_baseinfo');
		$data['category'] = $this->load->controller('tools/publish/add_category');
		$data['property'] = $this->load->controller('tools/publish/add_property');
		return $this->load->view('tools/publish/add/content.html', $data);
	}
	//1.选择商品
	public function add_select_item(){
		return $this->load->view('tools/publish/add/add_select_item.html', $data=array());
	}
	//2.添加基本信息
	public function add_baseinfo(){
		return $this->load->view('tools/publish/add/add_baseinfo.html', $data=array());
	}
	//3.分类
	public function add_category(){
		return $this->load->view('tools/publish/add/add_category.html', $data=array());
	}
	//4.物品属性与状况
	public function add_property(){
		return $this->load->view('tools/publish/add/add_property.html', $data=array());
	}
	
}