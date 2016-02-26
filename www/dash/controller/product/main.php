<?php
/**
 * 产品管理
 */
class ControllerProductMain extends \Siiwi\Dashboard\Controller
{
    public function index()
    {
        // 加载页面框架
        $this->data['frame']['header']      = $this->load->controller('frame/header', $this->language->get('product_main_index')->title);
        $this->data['frame']['navigation']  = $this->load->controller('frame/navigation');
        $this->data['frame']['sidebar']     = $this->load->controller('frame/sidebar');
        $this->data['frame']['footer']      = $this->load->controller('frame/footer');
        $this->data['frame']['content']     = $this->content();

        $this->response->setOutput($this->load->view('frame/main.html', $this->data));
    }

    private function content()
    {
        return $this->load->view('product/main/content.html', $this->data);
    }

    /**
     * 添加新产品
     * @method AJAX
     */
    public function add()
    {
        if($this->request->isAjax()) {
//            if($this->request->isPost()) {
//
//            }

            if($this->request->isGet()) {
                // 品牌列表
                $this->api->get('brand/get', array('status'=>1));
                if($this->api->getResponseStatus()) {
                    $brand_list = $this->api->getResponseData();
                    $this->data['product_main_add']['brand_list'] = $brand_list['brand_list'];
                }

                // 供应商列表
                $this->api->get('supplier/get', array('status'=>1));
                if($this->api->getResponseStatus()) {
                    $supplier_list = $this->api->getResponseData();
                    $this->data['product_main_add']['supplier_list'] = $supplier_list['supplier_list'];
                }

                // 分类列表
                $this->api->get('category/get', array('status'=>1));
                if($this->api->getResponseStatus()) {
                    $category_list = $this->api->getResponseData();
                    $this->data['product_main_add']['category_list'] = $category_list['category_list'];
                }

                $this->response->setOutput($this->load->view('product/main/add.html', $this->data));
            }
        }
    }
}
