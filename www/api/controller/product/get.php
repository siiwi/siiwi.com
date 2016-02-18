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
        $this->load->model('category/main');
        $this->load->model('category/description');

        $this->verifyToken();

        $this->prepareWhereArr();

        $this->pagination();

        $this->product_list = $this->model_product_main->fetchAll($this->where_array, $this->limit_array);

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
            foreach($this->product_list as $product_info) {
                $product_sku = $this->model_product_sku->fetchAll(array('product_id'=>$product_info['product_id']));

                if(is_array($product_sku) && !empty($product_sku)) {
                    foreach($product_sku as $sku) {
                        $product['sku'] = $sku['sku'];
                        $product['product_id'] = $product_info['product_id'];
                        $product['name'] = $product_info['name'];
                        $product['url'] = $product_info['url'];
                        $product['attribute'] = array();
                        $product['resource'] = array();
                        $product['brand'] = array();
                        $product['supplier'] = array();
                        $product['category'] = array();
                        $product['stock'] = $sku['stock'];
                        $product['purchase_price'] = $sku['purchase_price'];
                        $product['status'] = $product_info['status'];

                        // 属性
                        $product_attribute = $this->model_product_attribute->fetchAll(array('sku'=>$sku['sku']));
                        if(is_array($product_attribute) && !empty($product_attribute)) {
                            foreach($product_attribute as $attribute) {
                                $attribute_info = $this->model_attribute_main->fetchOne(array('attribute_id'=>$attribute['attribute_id']));
                                if(is_array($attribute_info) && !empty($attribute_info)) {
                                    $product['attribute'][$attribute['attribute_id']]['attribute_id'] = $attribute_info['attribute_id'];
                                    $product['attribute'][$attribute['attribute_id']]['name'] = $attribute_info['name'];
                                    $product['attribute'][$attribute['attribute_id']]['value'] = $attribute['value'];
                                }
                            }
                        }

                        // 资源
                        $product_resource = $this->model_product_resource->fetchAll(array('sku'=>$sku['sku']));
                        if(is_array($product_resource) && !empty($product_resource)) {
                            foreach($product_resource as $resource) {
                                $resource_info = $this->model_resource_main->fetchOne(array('resource_id'=>$resource['resource_id']));
                                if(is_array($resource_info) && !empty($resource_info)) {
                                    $product['resource'][$resource_info['resource_id']] = $resource_info['path'];
                                }
                            }
                        }

                        // 品牌
                        $brand_info = $this->model_brand_main->fetchOne(array('brand_id'=>$product_info['brand_id']));
                        if(is_array($brand_info) && !empty($brand_info)) {
                            $product['brand']['brand_name'] = $brand_info['name'];
                            $product['brand']['brand_id'] = $brand_info['brand_id'];
                        }

                        // 供应商
                        $supplier_info = $this->model_supplier_main->fetchOne(array('supplier_id'=>$product_info['supplier_id']));
                        if(is_array($supplier_info) && !empty($supplier_info)) {
                            $product['supplier']['supplier_name'] = $supplier_info['name'];
                            $product['supplier']['supplier_id'] = $supplier_info['supplier_id'];
                        }

                        // 类别
                        $category_info = $this->model_category_main->fetchOne(array('category_id'=>$product_info['category_id']));
                        if(is_array($category_info) && !empty($category_info)) {
                            $category_description_info = $this->model_category_description->fetchAll(array('category_id'=>$product_info['category_id']));

                            if(is_array($category_description_info) && !empty($category_description_info)) {
                                foreach($category_description_info as $description) {
                                    $product['category'][$description['language_id']]['category_id'] = $description['category_id'];
                                    $product['category'][$description['language_id']]['name'] = $description['name'];
                                }
                            }
                        }

                        $data[] = $product;
                    }
                }
            }
        }

        return array(
            'product_list' => $data
        );
    }
}