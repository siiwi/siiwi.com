<?php
/**
 * 产品分类管理
 */
class ControllerProductCategory extends \Siiwi\Dashboard\Controller
{
    public function index()
    {
        // 加载页面框架
        $this->data['frame']['header']      = $this->load->controller('frame/header', $this->language->get('product_category_index')->title);
        $this->data['frame']['navigation']  = $this->load->controller('frame/navigation');
        $this->data['frame']['sidebar']     = $this->load->controller('frame/sidebar');
        $this->data['frame']['footer']      = $this->load->controller('frame/footer');
        $this->data['frame']['content']     = $this->content();

        $this->response->setOutput($this->load->view('frame/main.html', $this->data));
    }

    private function content()
    {
        $page = $this->request->getHttpGet('page', 1);
        $this->api->get('category/get', array('status'=>1, 'page'=>$page, 'page_size'=>$this->config->get('config_page_size')));

        if($this->api->getResponseStatus()) {
            $category_list = $this->api->getResponseData();
            $this->data['product_category_content']['category_list'] = $category_list['category_list'];

            // 分页挂件
            if($category_list['category_total'] > $this->config->get('config_page_size')) {
                $pagination = array(
                    'total' => $category_list['category_total'],
                    'link'  => $this->url->link('product/category')
                );
                $this->data['product_category_content']['pagination'] = $this->load->controller('frame/pagination', $pagination);
            }
        }

        return $this->load->view('product/category/content.html', $this->data);
    }

    /**
     * 添加产品分类
     */
    public function add()
    {
        if($this->request->isAjax()) {
            // 提交产品新分类信息
            if($this->request->isPost()) {
                $data['name']               = $this->request->getHttpPost('name');
                $data['parent_category_id'] = $this->request->getHttpPost('parent_category_id');

                $this->api->post('category/add', $data);
                $response['status']  = $this->api->getResponseStatus();
                $response['message'] = $this->language->get('product_category_add')->response[$this->api->getResponseMessage()];

                $this->response->outputJson($response);
            }

            // 渲染添加产品分类页面
            if($this->request->isGet()) {
                $this->api->get('category/get', array('status'=>1, 'parent_category_id'=>0));
                if($this->api->getResponseStatus()) {
                    $category_list = $this->api->getResponseData();
                    $this->data['product_category_add']['category_list'] = $category_list['category_list'];
                }

                $this->response->setOutput($this->load->view('product/category/add.html', $this->data));
            }
        }
    }

    /**
     * 删除产品分类
     */
    public function delete()
    {
        if($this->request->isPost() && $this->request->isAjax()) {
            $data['category_id'] = $this->request->getHttpPost('category_id');

            $this->api->delete('category/delete', $data);

            $response['status']  = $this->api->getResponseStatus();
            $response['message'] = $this->language->get('product_category_delete')->response[$this->api->getResponseMessage()];
            $this->response->outputJson($response);
        }
    }

    /**
     * 编辑产品分类
     */
    public function edit()
    {
        if($this->request->isGet() && $this->request->isAjax()) {
            $category_id = $this->request->getHttpGet('category_id');
            $this->api->get('category/get', array('category_id'=>$category_id, 'status'=>1));

            if($this->api->getResponseStatus()) {
                $category_list = $this->api->getResponseData();
                $this->data['product_category_edit']['category_info'] = $category_list['category_list']['0'];

                $response['status']  = true;
                $response['message'] = '';
                $response['data']    = $this->load->view('product/category/edit.html', $this->data);
            } else {
                $response['status']  = false;
                $response['message'] = $this->language->get('product_category_edit')->response['system_error'];
                $response['data']    = '';
            }

            $this->response->outputJson($response);
        }
    }

    /**
     * 更新产品分类
     */
    public function update()
    {
        if($this->request->isPost() && $this->request->isAjax()) {
            $put_params['category_id']  = $this->request->getHttpPost('category_id');
            $post_params['name']        = $this->request->getHttpPost('name');

            $this->api->put('category/update', $put_params, $post_params);
            $response['status']  = $this->api->getResponseStatus();
            $response['message'] = $this->language->get('product_category_update')->response[$this->api->getResponseMessage()];
            $this->response->outputJson($response);
        }
    }
}