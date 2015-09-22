<?php
class ControllerComponentPagination extends Controller {
	public function index($setting) {
		if(isset($setting['id'])){
            $data['id'] = 'id_pagination_'.$setting['id'];
        }else{
            echo $this->api->info(43,array('sub_code'=>43001,'sub_msg'=>'id'));
            return;
        }
		$data['page'] = $setting['page'];//当前页
		$data['total_page'] = $setting['total_page'];//所有页数
		$data['size'] = $setting['size'];//每页个数
		$data['link'] = $setting['link'];//链接
        $data['n'] = 3;//激活状态item的前后个数
		return $this->load->view('component/pagination/s-0.html',$data);
	}
    public function style($setting){
        $data['id'] = $setting['id'];
        return $this->load->view('component/pagination/s-0.html',$data);
    }
}