<?php
class ControllerProductCategory extends Controller {
	public function index() {
		$this->document->setTitle('产品类别及规格属性管理 - 产品管理 - 控制台 - 电商服务平台');
		
		$this->document->addStyle('/assets/plugins/chosen/chosen.min.css');
		$this->document->addScript('/assets/plugins/chosen/chosen.jquery.min.js');
		$this->document->addScript('/assets/plugins/bootbox/bootbox.min.js');
		
		$data['header'] = $this->load->controller('frame/header');
		$data['footer'] = $this->load->controller('frame/footer');
		$data['frame_header'] = $this->load->controller('frame/frameheader');
		$data['frame_footer'] = $this->load->controller('frame/framefooter');
		$data['main_nav'] = $this->load->controller('frame/mainnav');
		$data['aside'] = $this->load->controller('frame/aside');
		
		$data['content'] = $this->load->controller('product/category/content');
		
		$st_breadcrumb = array();
		$st_breadcrumb['items'] = array(array('url'=>'/','text'=>'首页'),
										array('url'=>'/dashboard/','text'=>'控制台'),
										array('url'=>'/dashboard/?route=product/product','text'=>'产品类别'));
		$data['breadcrumb'] = $this->load->controller('component/breadcrumb',$st_breadcrumb);
		$this->response->setOutput($this->load->view('product/category.html', $data));
	}
	public function content() {
		$page = 1;
		$size = 10;
		if(isset($this->request->get['page'])){
			$page = $this->request->get['page'];
		}
		
		$category_add_setting['id'] = time();
		$data['category_add'] = $this->load->controller('product/category/add',$category_add_setting);
		$category_modify_setting['id'] = time();
		$data['category_modify'] = $this->load->controller('product/category/modify',$category_modify_setting);
		$category_delete_setting['id'] = time();
		$data['category_delete'] = $this->load->controller('product/category/delete',$category_delete_setting);
		//=====start pagination
		$pagination_setting = array();
		$pagination_setting['id'] = time();
		$pagination_setting['total_page'] = 30;
		$pagination_setting['page'] = $page;
		$pagination_setting['size'] = 10;
		$pagination_setting['link'] = '/dashboard/?route=product/category';
		$data['pagination'] = $this->load->controller('component/pagination', $pagination_setting);
		//=====end pagination
		
		$data['category_add_modal_id'] = 'category_add_'.$category_add_setting['id'];
		return $this->load->view('product/category/content.html', $data);
	}
	
	public function add($setting){
		if(isset($setting['id'])){
			$data['id'] = 'category_add_'.$setting['id'];
		}else{
			return 'false:id';
		}
		return $this->load->view('product/category/add.html', $data);
	}
	public function modify($setting){
		if(isset($setting['id'])){
			$data['id'] = 'category_modify_'.$setting['id'];
		}else{
			return 'false:id';
		}
		return $this->load->view('product/category/modify.html', $data);
	}
	public function delete($setting){
		if(isset($setting['id'])){
			$data['id'] = 'category_delete_'.$setting['id'];
		}else{
			return 'false:id';
		}
		return $this->load->view('product/category/delete.html', $data);
	}
}