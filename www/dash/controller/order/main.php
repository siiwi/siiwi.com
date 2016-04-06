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
        $page = $this->request->getHttpGet('page', 1);

        $this->api->get('order/get', array('status'=>1, 'page'=>$page, 'page_size'=>$this->config->get('config_page_size')));

        if($this->api->getResponseStatus()) {
            $order_list = $this->api->getResponseData();

            $this->data['order_main_content']['order_list'] = $order_list['order_list'];

            if($order_list['order_total'] > $this->config->get('config_page_size')) {
                $pagination = array(
                    'total' => $order_list['order_total'],
                    'link'  => $this->url->link('order/main')
                );
                $this->data['order_main_content']['pagination'] = $this->load->controller('frame/pagination', $pagination);
            }
        } else {
            $this->data['order_main_content']['order_list'] = array();
        }

        return $this->load->view('order/main/content.html', $this->data);
    }

    public function add()
    {
        if($this->request->isAjax()) {
            if($this->request->isPost()) {
                $data = $this->request->getHttpPost('data');

                $this->api->post('order/add', $data);

                if($this->api->getResponseStatus()) {
                    $response['status']  = true;
                    $response['data']    = $this->api->getResponseData();
                } else {
                    $response['status']  = false;
                    $response['data']    = '';
                }

                $response['message'] = $this->language->get('order_main_add')->response[$this->api->getResponseMessage()];

                // 返回数据
                $this->response->outputJson($response);
            }

            if($this->request->isGet()) {
                $this->api->get('country/get', array('language_id'=>$this->config->get('language_id')));
                if($this->api->getResponseStatus()) {
                    $country_list = $this->api->getResponseData();
                    $this->data['order_main_add']['country_list'] = $country_list['country_list'];
                }

                $this->api->get('platform/get', array('language_id'=>$this->config->get('language_id'), 'status'=>1));
                if($this->api->getResponseStatus()) {
                    $platform_list = $this->api->getResponseData();
                    $this->data['order_main_add']['platform_list'] = $platform_list['platform_list'];
                }

                $this->api->get('orderstate/get', array('language_id'=>$this->config->get('language_id'), 'status'=>1));
                if($this->api->getResponseStatus()) {
                    $orderstate_list = $this->api->getResponseData();
                    $this->data['order_main_add']['orderstate_list'] = $orderstate_list['orderstate_list'];
                }

                $this->response->setOutput($this->load->view('order/main/add.html', $this->data));
            }
        }
    }
}
