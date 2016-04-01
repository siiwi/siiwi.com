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

        // 获取SKU列表
        $this->api->get('sku/get', array('status'=>1, 'page'=>$page, 'page_size'=>$this->config->get('config_page_size')));

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

    public function edit()
    {
        if($this->request->isAjax() && $this->request->isGet()) {
            $sku = $this->request->getHttpGet('sku');
            $this->api->get('sku/get', array('sku'=>$sku, 'status'=>1));

            if($this->api->getResponseStatus()) {
                $product_sku_info = $this->api->getResponseData();
                $this->data['product_main_edit']['product_info'] = $product_sku_info['product_list'][0];

                $response['status']  = true;
                $response['message'] = '';
                $response['data']    = $this->load->view('product/main/edit.html', $this->data);
            } else {
                $response['status']  = false;
                $response['message'] = $this->language->get('product_main_edit')->response['system_error'];
                $response['data']    = '';
            }

            $this->response->outputJson($response);
        }
    }

    public function delete()
    {
        if($this->request->isPost() && $this->request->isAjax()) {
            $put_params['sku'] = $this->request->getHttpPost('sku');
            $post_params['status']  = 0;

            // 软删除
            $this->api->put('sku/update', $put_params, $post_params);

            $response['status']  = $this->api->getResponseStatus();
            $response['message'] = $this->language->get('product_main_delete')->response[$this->api->getResponseMessage()];
            $this->response->outputJson($response);
        }
    }

    public function update()
    {
        if($this->request->isPost() && $this->request->isAjax()) {
            $put_params['sku']             = $this->request->getHttpPost('sku');
            $post_params['stock']          = $this->request->getHttpPost('stock');
            $post_params['purchase_price'] = $this->request->getHttpPost('purchase_price');

            $this->api->put('sku/update', $put_params, $post_params);

            $response['status']  = $this->api->getResponseStatus();
            $response['message'] = $this->language->get('product_main_update')->response[$this->api->getResponseMessage()];
            $this->response->outputJson($response);
        }
    }

    public function get()
    {
        // 获取分类列表
        $this->api->get('category/get', array('status'=>1, 'type'=>2));
        if($this->api->getResponseStatus()) {
            $category_list = $this->api->getResponseData();
            $this->data['product_main_get']['category_list'] = $category_list['category_list'];
        }

        $this->response->setOutput($this->load->view('product/main/get.html', $this->data));
    }

    public function load()
    {
        if($this->request->isGet() && $this->request->isAjax()) {
            $data['page_size'] = $this->config->get('config_page_size');
            $data['page'] = $this->request->getHttpGet('page', 1);
            $data['status'] = 1;

            if($this->request->getHttpGet('category_id')) {
                $data['category_id'] = $this->request->getHttpGet('category_id');
            }

            $this->api->get('product/get', $data);
            if($this->api->getResponseStatus()) {
                $product_list = $this->api->getResponseData();
                if(is_array($product_list['product_list']) && !empty($product_list['product_list'])) {
                    $result['product_list'] = $product_list['product_list'];

                    // 分页
                    $page_size = $this->config->get('config_page_size');
                    if($product_list['product_total'] > $page_size) {
                        $total = ceil($product_list['product_total'] / $page_size);
                        $pagination['prev'] = ($data['page']<=1)?1:($data['page']-1);
                        $pagination['next'] = ($data['page']>=$total)?$total:($data['page']+1);
                        if($this->request->getHttpGet('category_id')) {
                            $pagination['category_id'] = $this->request->getHttpGet('category_id');
                        }
                        $result['pagination'] = $pagination;
                    }

                    $response['status']  = true;
                    $response['message'] = $this->language->get('product_main_load')->response[$this->api->getResponseMessage()];
                    $response['data']    = $result;
                } else {
                    $response['status']  = false;
                    $response['message'] = $this->language->get('product_main_load')->response['empty_product_list'];
                    $response['data']    = array();
                }
            } else {
                $response['status']  = false;
                $response['message'] = $this->language->get('product_main_load')->response[$this->api->getResponseMessage()];
                $response['data']    = array();
            }

            $this->response->outputJson($response);
        }
    }
}
