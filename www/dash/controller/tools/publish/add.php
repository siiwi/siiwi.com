<?php
class ControllerToolsPublishAdd extends Controller {
	public function index(){
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
		
		$data['content'] = $this->load->controller('tools/publish/add/content');
		
		$this->response->setOutput($this->load->view('tools/publish/add.html', $data));
	}
	public function content(){
		$data['selectItem'] = $this->load->controller('tools/publish/add/select_item');
		$data['baseInfo'] = $this->load->controller('tools/publish/add/set_baseinfo');
		$data['category'] = $this->load->controller('tools/publish/add/set_category');
		$data['property'] = $this->load->controller('tools/publish/add/set_property');
		return $this->load->view('tools/publish/add/content.html', $data);
	}
	//1----------选择商品-------------
	public function select_item(){
		return $this->load->view('tools/publish/add/select_item.html', $data=array());
	}
	
	//2----------添加基本信息-----------
	public function set_baseinfo(){
		return $this->load->view('tools/publish/add/set_baseinfo.html', $data=array());
	}
	//3----------分类选择----------
	public function set_category(){
		$data['ebay'] = $this->load->controller('tools/publish/add/set_category_ebay');
		$data['amazon'] = $this->load->controller('tools/publish/add/set_category_amazon');
		return $this->load->view('tools/publish/add/set_category.html', $data);
	}
	public function set_category_ebay(){
		return $this->load->view('tools/publish/add/set_category/ebay.html', $data=array());
	}
	public function set_category_amazon(){
		return $this->load->view('tools/publish/add/set_category/amazon.html', $data=array());
	}
	//4----------物品属性与状况----------
	public function set_property(){
		$data['ebay'] = $this->load->controller('tools/publish/add/set_property_ebay');
		$data['amazon'] = $this->load->controller('tools/publish/add/set_property_amazon');
		return $this->load->view('tools/publish/add/set_property.html', $data);
	}
	public function set_property_ebay(){
		return $this->load->view('tools/publish/add/set_property/ebay.html', $data=array());
	}
	public function set_property_amazon(){
		return $this->load->view('tools/publish/add/set_property/amazon.html', $data=array());
	}
	
}