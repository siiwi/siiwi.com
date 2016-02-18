<?php
/**
 * 产品品牌管理
 */
class ControllerProductBrand extends \Siiwi\Dashboard\Controller
{
    public function index()
    {
        // 加载页面框架
        $this->data['frame']['header']      = $this->load->controller('frame/header', $this->language->get('product_brand_index')->title);
        $this->data['frame']['navigation']  = $this->load->controller('frame/navigation');
        $this->data['frame']['sidebar']     = $this->load->controller('frame/sidebar');
        $this->data['frame']['footer']      = $this->load->controller('frame/footer');
        $this->data['frame']['content']     = $this->content();

        $this->response->setOutput($this->load->view('frame/main.html', $this->data));
    }

    private function content()
    {
        $page = $this->request->getHttpGet('page', 1);

        $this->api->get('brand/get', array('status'=>1, 'page'=>$page, 'page_size'=>$this->config->get('config_page_size')));

        if($this->api->getResponseStatus()) {
            $brand_list = $this->api->getResponseData();

            $this->data['product_brand_content']['brand_list'] = $brand_list['brand_list'];

            // 分页挂件
            if($brand_list['brand_total'] > $this->config->get('config_page_size')) {
                $pagination = array(
                    'total' => $brand_list['brand_total'],
                    'link'  => $this->url->link('product/brand')
                );
                $this->data['product_brand_content']['pagination'] = $this->load->controller('frame/pagination', $pagination);
            }
        }

        return $this->load->view('product/brand/content.html', $this->data);
    }

    /**
     * 添加新品牌
     * @method AJAX
     */
    public function add()
    {
        if($this->request->isAjax()) {
            if($this->request->isPost()) {
                $data['name'] = $this->request->getHttpPost('name');

                $this->api->post('brand/add', $data);
                $response['status']  = $this->api->getResponseStatus();
                $response['message'] = $this->language->get('product_brand_add')->response[$this->api->getResponseMessage()];
                $this->response->outputJson($response);
            }

            if($this->request->isGet()) {
                $this->response->setOutput($this->load->view('product/brand/add.html', $this->data));
            }
        }
    }

    /**
     * 删除品牌
     * @method AJAX
     */
    public function delete()
    {
        if($this->request->isPost() && $this->request->isAjax()) {
            $put_params['brand_id'] = $this->request->getHttpPost('brand_id');
            $post_params['status']  = 0;

            // 软删除
            // $this->api->delete('brand/delete', $data);
            $this->api->put('brand/update', $put_params, $post_params);

            $response['status']  = $this->api->getResponseStatus();
            $response['message'] = $this->language->get('product_brand_delete')->response[$this->api->getResponseMessage()];
            $this->response->outputJson($response);
        }
    }

    /**
     * 编辑品牌
     * @method AJAX
     */
    public function edit()
    {
        if($this->request->isAjax()) {
            $brand_id = $this->request->getHttpGet('brand_id');
            $this->api->get('brand/get', array('brand_id'=>$brand_id, 'status'=>1));

            if($this->api->getResponseStatus()) {
                $brand_list = $this->api->getResponseData();
                $this->data['product_brand_edit']['brand_info'] = $brand_list['brand_list']['0'];

                $response['status']  = true;
                $response['message'] = '';
                $response['data']    = $this->load->view('product/brand/edit.html', $this->data);
            } else {
                $response['status']  = false;
                $response['message'] = $this->language->get('product_brand_edit')->response['system_error'];
                $response['data']    = '';
            }

            $this->response->outputJson($response);
        }
    }

    /**
     * 更新品牌
     */
    public function update()
    {
        if($this->request->isPost() && $this->request->isAjax()) {
            $put_params['brand_id']  = $this->request->getHttpPost('brand_id');
            $post_params['name']     = $this->request->getHttpPost('name');

            $this->api->put('brand/update', $put_params, $post_params);
            $response['status']  = $this->api->getResponseStatus();
            $response['message'] = $this->language->get('product_brand_update')->response[$this->api->getResponseMessage()];
            $this->response->outputJson($response);
        }
    }
}
