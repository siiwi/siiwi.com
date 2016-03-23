<?php

class ControllerProductGet extends \Siiwi\Api\Controller
{
    private $where_array = array();
    private $product_list = array();

    public function index()
    {
        $this->isGet();

        $this->load->model('global/token');
        $this->load->model('user/main');
        $this->load->model('product/main');
        $this->load->model('product/sku');
        $this->load->model('product/attribute');
        $this->load->model('product/resource');
        $this->load->model('resource/main');
        $this->load->model('attribute/main');
        $this->load->model('brand/main');
        $this->load->model('supplier/main');
        $this->load->model('category/description');

        $this->verifyToken();

        $this->prepareWhereArr();

        $this->pagination();

        $order_array = array('key'=>'product_id', 'value'=>'desc');

        $this->product_total = $this->model_product_main->getProductListCount($this->where_array);
        if(!$this->product_total) {
            $this->response->jsonOutputExit('empty_product_list');
        }

        $this->product_list = $this->model_product_main->getProductList($this->where_array, $this->limit_array);

        $this->response->jsonOutput('success', $this->setResponseData());
    }

    private function prepareWhereArr()
    {
        $this->where_array['user_id'] = $this->getParentUserId();

        if($this->request->getHttpGet('product_id') !== false) {
            $this->where_array['product_id'] = $this->request->getHttpGet('product_id');
        }

        // 所属店铺
        if($this->request->getHttpGet('store_id') !== false) {
            $this->where_array['store_id'] = $this->request->getHttpGet('store_id');
        }

        if($this->request->getHttpGet('brand_id') !== false) {
            $this->where_array['brand_id'] = $this->request->getHttpGet('brand_id');
        }

        if($this->request->getHttpGet('category_id') !== false) {
            $this->where_array['category_id'] = $this->request->getHttpGet('category_id');
        }

        if($this->request->getHttpGet('status') !== false) {
            $this->where_array['status'] = $this->request->getHttpGet('status');
        }
    }

    private function setResponseData()
    {
        $data = array();

        if(is_array($this->product_list) && !empty($this->product_list)) {
            foreach($this->product_list as $key=>$product) {
                // 获取产品资源
                $resource = $this->model_product_resource->fetchAll(array('product_id'=>$product['product_id']));
                if(is_array($resource) && !empty($resource)) {
                    foreach($resource as $img) {
                        $this->product_list[$key]['resource'][] = $this->config->get('config_img_url') . $img['path'];
                    }
                }

                // 获取品牌信息
                $brand_info = $this->model_brand_main->fetchOne(array('brand_id'=>$product['brand_id']));
                $this->product_list[$key]['brand_name'] = $brand_info['name'];

                // 获取分类信息
                $category_info = $this->model_category_description->fetchOne(array('category_id'=>$product['category_id']));
                $this->product_list[$key]['category_name'] = $category_info['name'];

                // 获取供应商信息
                $supplier_info = $this->model_supplier_main->fetchOne(array('supplier_id'=>$product['supplier_id']));
                $this->product_list[$key]['supplier_name'] = $supplier_info['name'];

                // 获取产品规格信息
                $attribute_list = $this->model_product_attribute->fetchAll(array('sku'=>$product['sku'], 'status'=>1));
                if(is_array($attribute_list) && !empty($attribute_list)) {
                    foreach($attribute_list as $k=>$attribute) {
                        $attribute_info = $this->model_attribute_main->fetchOne(array('attribute_id'=>$attribute['attribute_id']));
                        $attr['attribute_id'] = $attribute['attribute_id'];
                        $attr['attribute_name'] = $attribute_info['name'];
                        $attr['attribute_value'] = $attribute['value'];
                        $this->product_list[$key]['attribute'][$k] = $attr;
                    }
                }
            }
        }

        return array(
            'product_list'  => $this->product_list,
            'product_total' => $this->product_total
        );
    }
}
