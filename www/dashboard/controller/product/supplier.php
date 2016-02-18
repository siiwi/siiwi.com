<?php
/**
 * 供应商管理
 */
class ControllerProductSupplier extends \Siiwi\Dashboard\Controller
{
    public function index()
    {
        // 加载页面框架
        $this->data['frame']['header']      = $this->load->controller('frame/header', $this->language->get('product_supplier_index')->title);
        $this->data['frame']['navigation']  = $this->load->controller('frame/navigation');
        $this->data['frame']['sidebar']     = $this->load->controller('frame/sidebar');
        $this->data['frame']['footer']      = $this->load->controller('frame/footer');
        $this->data['frame']['content']     = $this->content();

        $this->response->setOutput($this->load->view('frame/main.html', $this->data));
    }

    private function content()
    {
        $page = $this->request->getHttpGet('page', 1);
        $this->api->get('supplier/get', array('status'=>1,  'page'=>$page, 'page_size'=>$this->config->get('config_page_size')));

        if($this->api->getResponseStatus()) {
            $supplier_list = $this->api->getResponseData();
            $this->data['product_supplier_content']['supplier_list'] = $supplier_list['supplier_list'];

            // 分页挂件
            if($supplier_list['supplier_total'] > $this->config->get('config_page_size')) {
                $pagination = array(
                    'total' => $supplier_list['supplier_total'],
                    'link'  => $this->url->link('product/supplier')
                );
                $this->data['product_supplier_content']['pagination'] = $this->load->controller('frame/pagination', $pagination);
            }
        }

        return $this->load->view('product/supplier/content.html', $this->data);
    }

    /**
     * 添加供应商
     */
    public function add()
    {
        if($this->request->isAjax()) {
            if($this->request->isPost()) {
                $data['name']       = $this->request->getHttpPost('name');
                $data['contact']    = $this->request->getHttpPost('contact');
                $data['phone']      = $this->request->getHttpPost('phone');
                $data['url']        = $this->request->getHttpPost('url');
                $data['email']      = $this->request->getHttpPost('email');
                $data['desc']       = $this->request->getHttpPost('desc');
                $data['address']    = $this->request->getHttpPost('address');

                $this->api->post('supplier/add', $data);
                $response['status']  = $this->api->getResponseStatus();
                $response['message'] = $this->language->get('product_supplier_add')->response[$this->api->getResponseMessage()];
                $this->response->outputJson($response);
            }

            if($this->request->isGet()) {
                $this->data['product_supplier_add']['regex_email'] = $this->config->get('config_regex_email');
                $this->response->setOutput($this->load->view('product/supplier/add.html', $this->data));
            }
        }
    }

    /**
     * 删除供应商
     */
    public function delete()
    {
        if($this->request->isPost() && $this->request->isAjax()) {
            $data['supplier_id'] = $this->request->getHttpPost('supplier_id');

            $this->api->delete('supplier/delete', $data);

            $response['status']  = $this->api->getResponseStatus();
            $response['message'] = $this->language->get('product_supplier_delete')->response[$this->api->getResponseMessage()];
            $this->response->outputJson($response);
        }
    }

    /**
     * 编辑供应商
     * @method GET|AJAX
     */
    public function edit()
    {
        if($this->request->isGet() && $this->request->isAjax()) {
            $supplier_id = $this->request->getHttpGet('supplier_id');
            $this->api->get('supplier/get', array('supplier_id'=>$supplier_id, 'status'=>1));

            if($this->api->getResponseStatus()) {
                $supplier_info = $this->api->getResponseData();
                $this->data['product_supplier_edit']['regex_email']   = $this->config->get('config_regex_email');
                $this->data['product_supplier_edit']['supplier_info'] = $supplier_info['supplier_list']['0'];

                $response['status']  = true;
                $response['message'] = '';
                $response['data']    = $this->load->view('product/supplier/edit.html', $this->data);
            } else {
                $response['status']  = false;
                $response['message'] = $this->language->get('product_supplier_edit')->response['system_error'];
                $response['data']    = '';
            }

            $this->response->outputJson($response);
        }
    }

    /**
     * 更新供应商
     * @method POST|AJAX
     */
    public function update()
    {
        if($this->request->isPost() && $this->request->isAjax()) {
            $put_params['supplier_id'] = $this->request->getHttpPost('supplier_id');
            $post_params['name']       = $this->request->getHttpPost('name');
            $post_params['contact']    = $this->request->getHttpPost('contact');
            $post_params['phone']      = $this->request->getHttpPost('phone');
            $post_params['url']        = $this->request->getHttpPost('url');
            $post_params['email']      = $this->request->getHttpPost('email');
            $post_params['desc']       = $this->request->getHttpPost('desc');
            $post_params['address']    = $this->request->getHttpPost('address');

            $this->api->put('supplier/update', $put_params, $post_params);
            $response['status']  = $this->api->getResponseStatus();
            $response['message'] = $this->language->get('product_supplier_update')->response[$this->api->getResponseMessage()];
            $this->response->outputJson($response);
        }
    }
}
