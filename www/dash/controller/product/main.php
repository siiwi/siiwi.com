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
        $page = $this->request->getHttpGet('page', 1);

        $this->api->get('product/get', array('status'=>1, 'page'=>$page, 'page_size'=>$this->config->get('config_page_size')));
        // echo '<pre>';
        // print_r($this->api->getResponseData());

        if($this->api->getResponseStatus()) {
            $product_list = $this->api->getResponseData();

            $this->data['product_main_content']['product_list'] = $product_list['product_list'];

            // 分页挂件
            if($product_list['product_total'] > $this->config->get('config_page_size')) {
                $pagination = array(
                    'total' => $product_list['product_total'],
                    'link'  => $this->url->link('product/main')
                );
                $this->data['product_main_content']['pagination'] = $this->load->controller('frame/pagination', $pagination);
            }
        }

        return $this->load->view('product/main/content.html', $this->data);
    }

    /**
     * 添加新产品
     * @method AJAX
     */
    public function add()
    {
        if($this->request->isAjax()) {
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

            if($this->request->isPost()) {
                $data = $this->request->getHttpPost('data');
                $this->api->post('product/add', $data);
                if($this->api->getResponseStatus()) {
                    $response['status']  = true;
                    $response['data']    = $this->api->getResponseData();
                } else {
                    $response['status']  = false;
                    $response['data']    = '';
                }

                $response['message'] = $this->language->get('product_main_add')->response[$this->api->getResponseMessage()];

                // 返回数据
                $this->response->outputJson($response);
            }
        }
    }

    public function delete()
    {
        if($this->request->isPost() && $this->request->isAjax()) {
            $put_params['product_id'] = $this->request->getHttpPost('product_id');
            $post_params['status']  = 0;

            // 软删除
            $this->api->put('product/update', $put_params, $post_params);

            $response['status']  = $this->api->getResponseStatus();
            $response['message'] = $this->language->get('product_main_delete')->response[$this->api->getResponseMessage()];
            $this->response->outputJson($response);
        }
    }
}
