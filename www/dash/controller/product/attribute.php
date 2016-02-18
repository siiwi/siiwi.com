<?php
/**
 * 产品分类规格管理
 */
class ControllerProductAttribute extends \Siiwi\Dashboard\BaseController
{
    public function index()
    {
        if($this->request->isGet() && $this->request->isAjax()) {
            $category_id = $this->request->getHttpGet('category_id');
            $type_id     = $this->request->getHttpGet('type_id', 1); // 返回数据类型：1-html,其他-data

            // 获取分类规格列表
            $this->api->get('attribute/get', array('category_id'=>$category_id));

            if($this->api->getResponseStatus()) {
                // 分类规格列表
                $attribute_list = $this->api->getResponseData();

                // 获取分类信息
                $this->api->get('category/get', array('category_id'=>$category_id));

                if($this->api->getResponseStatus()) {
                    // 分类信息
                    $category_info = $this->api->getResponseData();

                    // 规格信息格式化
                    $attribute = array();
                    if(is_array($attribute_list['attribute_list']) && !empty($attribute_list['attribute_list'])) {
                        foreach($attribute_list['attribute_list'] as $key=>$value) {
                            if($type_id == 1) {
                                $attribute[] = $value['name'];
                            } else {
                                $attribute[$key]['name'] = $value['name'];
                                $attribute[$key]['id']   = $value['attribute_id'];
                            }
                        }
                    }

                    $this->data['product_attribute_index']['category_info']  = $category_info['category_list']['0'];
                    $this->data['product_attribute_index']['attribute_list'] = $attribute;

                    $response['status']  = true;
                    $response['message'] = '';
                    $response['data']    = ($type_id == 1) ? $this->load->view('product/attribute/index.html', $this->data) : $this->data['product_attribute_index'];
                }
            }

            if(!$response['status']) {
                $response['status']  = false;
                $response['message'] = $this->language->get('product_attribute_index')->response['system_error'];
                $response['data']    = '';
            }

            $this->response->outputJson($response);
        }
    }

    /**
     * 添加新规格项
     * @method POST|AJAX
     */
    public function add()
    {
        if($this->request->isPost() && $this->request->isAjax()) {
            // 接收参数
            $data['category_id'] = $this->request->getHttpPost('category_id');
            $data['name']        = $this->request->getHttpPost('name');

            // 请求API
            $this->api->post('attribute/add', $data);

            if($this->api->getResponseStatus()) {
                $response['status']  = true;
                $response['data']    = $this->api->getResponseData();
            } else {
                $response['status']  = false;
                $response['data']    = '';
            }

            $response['message'] = $this->language->get('product_attribute_add')->response[$this->api->getResponseMessage()];

            // 返回数据
            $this->response->outputJson($response);
        }
    }

    /**
     * 删除规格项
     * @mehtod POST|AJAX
     */
    public function delete()
    {
        if($this->request->isPost() && $this->request->isAjax()) {
            $data['category_id'] = $this->request->getHttpPost('category_id');
            $data['name']        = $this->request->getHttpPost('name');

            $this->api->delete('attribute/delete', $data);

            $response['status']  = $this->api->getResponseStatus();
            $response['message'] = $this->language->get('product_category_delete')->response[$this->api->getResponseMessage()];
            $this->response->outputJson($response);
        }
    }
}
