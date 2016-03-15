<?php
/**
 * 产品管理
 */
class ControllerOrderMain extends \Siiwi\Dashboard\Controller
{
    public function index()
    {
        // 加载页面框架
        $this->data['frame']['header']      = $this->load->controller('frame/header', $this->language->get('order_main_index')->title);
        $this->data['frame']['navigation']  = $this->load->controller('frame/navigation');
        $this->data['frame']['sidebar']     = $this->load->controller('frame/sidebar');
        $this->data['frame']['footer']      = $this->load->controller('frame/footer');
        $this->data['frame']['content']     = $this->content();

        $this->response->setOutput($this->load->view('frame/main.html', $this->data));
    }

    private function content()
    {
        return $this->load->view('order/main/content.html', $this->data);
    }

    public function add()
    {
        if($this->request->isAjax()) {
            // if($this->request->isPost()) {
            //     $data['name'] = $this->request->getHttpPost('name');
            //
            //     $this->api->post('brand/add', $data);
            //     $response['status']  = $this->api->getResponseStatus();
            //     $response['message'] = $this->language->get('product_brand_add')->response[$this->api->getResponseMessage()];
            //     $this->response->outputJson($response);
            // }

            if($this->request->isGet()) {
                $this->response->setOutput($this->load->view('order/main/add.html', $this->data));
            }
        }
    }
}
