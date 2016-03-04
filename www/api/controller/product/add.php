<?php

/**
 * Class ControllerProductAdd
 * 添加产品API接口
 *
 * @method POST
 * @param string $name
 * @param int $store_id
 * @param int $category_id
 * @param int $brand_id
 * @param int $supplier_id
 * @param string $url
 * @param array $sku 包含规格信息和资源信息
 */
class ControllerProductAdd extends \Siiwi\Api\Controller
{
    private $user_id;
    private $product_info = array();

    public function index()
    {
        $this->isPost();

        $this->load->model('global/token');
        $this->load->model('user/main');
        $this->load->model('store/main');
        $this->load->model('brand/main');
        $this->load->model('category/main');
        $this->load->model('supplier/main');
        $this->load->model('product/main');
        $this->load->model('product/attribute');
        $this->load->model('product/resource');

        $this->verifyToken();

        $this->user_id = $this->getParentUserId();

        $this->validate();

        $this->prepareProductData();

        foreach($this->product_info as $key=>$product_info) {
            $this->model_product_main->add($product_info);
            $product_id = $this->model_product_main->getLastId();
            if($product_id) {
                // 写入SKU规格信息
                $attribute_info = array();
                $attributes = $this->request->getHttpPost('attribute');
                foreach($attributes[$key] as $attr_id=>$attr_value) {
                    if($attr_value && is_numeric($attr_id)) {
                        $attribute_info[$attr_id]['product_id'] = $product_id;
                        $attribute_info[$attr_id]['attribute_id'] = $attr_id;
                        $attribute_info[$attr_id]['value'] = $attr_value;
                        $attribute_info[$attr_id]['status'] = 1;
                    }
                }
                $this->model_product_attribute->add($attribute_info);

                // 写入资源信息
                $resource_info = array();
                $image = $this->request->getHttpPost('image');
                if(is_array($image) && !empty($image)) {
                    foreach($image as $k=>$img) {
                        $resource_info[$k]['product_id'] = $product_id;
                        $resource_info[$k]['path'] = $img;
                        $resource_info[$k]['type'] = 1;
                        $resource_info[$k]['status'] = 1;
                    }
                }
                $this->model_product_resource->add($resource_info);
            }
        }

        $this->response->jsonOutput('success');
    }

    private function validate()
    {
        // 产品名称
        $name = $this->request->getHttpPost('name');
        if($name === false) {
            $this->response->jsonOutputExit('empty_name');
        }

        if(utf8_strlen($name) > 50 || utf8_strlen($name) < 2) {
            $this->response->jsonOutputExit('invalid_name_length');
        }

//        // 检查店铺
//        $store_id = $this->request->getHttpPost('store_id');
//        if($store_id === false) {
//            $this->response->jsonOutputExit('empty_store_id');
//        }
//        $this->checkUserStore($this->user_id, $store_id);

        // 检查分类
        $category_id = $this->request->getHttpPost('category_id');
        if($category_id === false) {
            $this->response->jsonOutputExit('empty_category_id');
        }
        $this->checkUserCategory($this->user_id, $category_id);

        // 检查品牌
        $brand_id = $this->request->getHttpPost('brand_id');
        if($brand_id === false) {
            $this->response->jsonOutputExit('empty_brand_id');
        }
        $this->checkUserBrand($this->user_id, $brand_id);

        // 检查供应商
        $supplier_id = $this->request->getHttpPost('supplier_id');
        if($supplier_id === false) {
            $this->response->jsonOutputExit('empty_supplier_id');
        }
        $this->checkUserSupplier($this->user_id, $supplier_id);

        // 检查规格
        $attributes = $this->request->getHttpPost('attribute');
        if(($attributes === false) || !is_array($attributes) || empty($attributes)) {
            $this->response->jsonOutputExit('empty_sku_attribute');
        }
    }

    private function prepareProductData()
    {
        $sku = array();
        $attr = array();
        $attributes = $this->request->getHttpPost('attribute');
        $time = time();

        if(is_array($attributes) && !empty($attributes)) {
            foreach($attributes as $key=>$attribute) {
                // 判断商家SKU是否重复
                if(isset($attribute['sku']) && $attribute['sku']) {
                    if(!in_array($attribute['sku'], $sku)) {
                        $sku[] = $attribute['sku'];
                    } else {
                        $this->response->jsonOutputExit('duplication_sku');
                    }
                }

                foreach($attribute as $attr_id=>$attr_value) {
                    if(is_numeric($attr_id)) {
                        $s = '#' . $attr_id . '#' . $attr_value;
                    }
                }

                // 判断SKU规格是否重复
                if($s && !in_array($s, $attr)) {
                    $attr[] = $s;
                } else {
                    $this->response->jsonOutputExit('duplication_sku_attribute');
                }

                $this->product_info[$key]['name'] = $this->request->getHttpPost('name');
                $this->product_info[$key]['store_id'] = $this->request->getHttpPost('store_id');
                $this->product_info[$key]['category_id'] = $this->request->getHttpPost('category_id');
                $this->product_info[$key]['brand_id'] = $this->request->getHttpPost('brand_id');
                $this->product_info[$key]['supplier_id'] = $this->request->getHttpPost('supplier_id');
                $this->product_info[$key]['purchase_url'] = $this->request->getHttpPost('purchase_url', '');
                $this->product_info[$key]['sn'] = $this->request->getHttpPost('sn', '');
                $this->product_info[$key]['sku'] = $attribute['sku'];
                $this->product_info[$key]['purchase_price'] = $attribute['purchase_price'];
                $this->product_info[$key]['stock'] = $attribute['stock'];
                $this->product_info[$key]['status'] = 1;
                $this->product_info[$key]['add_timestamp'] = $time;
            }
        }
    }
}