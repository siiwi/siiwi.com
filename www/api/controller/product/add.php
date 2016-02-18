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
    private $product_info = array();
    private $product_sku_info = array();
    private $product_attribute_info = array();
    private $product_resource_info = array();

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
        $this->load->model('product/sku');
        $this->load->model('product/attribute');
        $this->load->model('product/resource');

        $this->verifyToken();

        $this->product_info['user_id'] = $this->getParentUserId();

        $this->validate();

        $this->prepareProductData();

        $this->prepareProductSkuData();

        // 添加产品
        $product_id = (!$this->model_product_main->add($this->product_info)) ? $this->request->jsonOutputExis('system_error') : $this->model_product_main->getLastId();

        foreach($this->product_sku_info as $key=>$value) {
            // 添加sku
            $value['product_id'] = $product_id;
            $this->model_product_sku->add($value);
            $sku = $this->model_product_sku->getLastId();

            // 添加规格项
            foreach($this->product_attribute_info[$key] as $k=>$v) {
                $v['sku'] = $sku;
                $this->model_product_attribute->add($v);
            }

            // 添加资源
            foreach($this->product_resource_info[$key] as $k=>$v) {
                $v['sku'] = $sku;
                $this->model_product_resource->add($v);
            }
        }

        $this->response->jsonOutput('success');
    }

    private function validate()
    {
        // 产品名称
        $name = ($this->request->getHttpPost('name') === false) ? $this->response->jsonOutputExit('empty_name') : $this->request->getHttpPost('name');
        if(utf8_strlen($name) > 50 || utf8_strlen($name) < 2) {
            $this->response->jsonOutputExit('invalid_name_length');
        }

        // 所属店铺
        $store_id = ($this->request->getHttpPost('store_id') === false) ? $this->response->jsonOutputExit('empty_store_id') : $this->request->getHttpPost('store_id');
        $this->checkUserStore($this->product_info['user_id'], $store_id);

        // 所属分类
        $category_id = ($this->request->getHttpPost('category_id') === false) ? $this->response->jsonOutputExit('empty_category_id') : $this->request->getHttpPost('category_id');
        $this->checkUserCategory($this->product_info['user_id'], $category_id);

        // 所属品牌
        $brand_id = ($this->request->getHttpPost('brand_id') === false) ? $this->response->jsonOutputExit('empty_brand_id') : $this->request->getHttpPost('brand_id');
        $this->checkUserBrand($this->product_info['user_id'], $brand_id);

        // 所属供应商
        $supplier_id = ($this->request->getHttpPost('supplier_id') === false) ? $this->response->jsonOutputExit('empty_supplier_id') : $this->request->getHttpPost('supplier_id');
        $this->checkUserSupplier($this->product_info['user_id'], $supplier_id);
    }

    private function prepareProductData()
    {
        $this->product_info['name'] = $this->request->getHttpPost('name');
        $this->product_info['store_id'] = $this->request->getHttpPost('store_id');
        $this->product_info['category_id'] = $this->request->getHttpPost('category_id');
        $this->product_info['brand_id'] = $this->request->getHttpPost('brand_id');
        $this->product_info['supplier_id'] = $this->request->getHttpPost('supplier_id');
        $this->product_info['url'] = $this->request->getHttpPost('url', '');
        $this->product_info['status'] = 1;
        $this->product_info['add_timestamp'] = time();
    }

    private function prepareProductSkuData()
    {
        $sn = $attribute = array();

        $attribute_num = 0;

        $sku = ($this->request->getHttpPost('sku') === false) ? $this->response->jsonOutputExit('empty_sku') : $this->request->getHttpPost('sku');

        if(!is_array($sku) || empty($sku)) {
            $this->response->jsonOutputExit('invalid_sku');
        }

        foreach($sku as $key=>$value) {
            // 确认每一个sn唯一
            $sn[] = (isset($value['sn']) && $value['sn'] && !in_array($value['sn'], $sn)) ? $value['sn'] : $this->response->jsonOutputExit('invalid_sn');

            $attr = '';

            // 确认规格项
            if(!isset($value['attribute']) || !is_array($value['attribute']) || empty($value['attribute'])) {
                $this->response->jsonOutputExit('empty_attribute');
            }

            // 确认规格项个数相同
            $attribute_num = !$attribute_num ? count($value['attribute']) : $attribute_num;
            if($attribute_num != count($value['attribute'])) {
                $this->response->jsonOutputExit('invalid_attribute');
            }

            // 确认规格值不同
            foreach($value['attribute'] as $k=>$v) {
                if(utf8_strlen($v) < 1) {
                    $this->response->jsonOutputExit('empty_attribute_value');
                }
                $attr .= $k . $v;

                $this->product_attribute_info[$key][$k]['attribute_id'] = $k;
                $this->product_attribute_info[$key][$k]['value'] = $v;
            }

            $attribute[] = (!in_array($attr, $attribute)) ? $attr : $this->response->jsonOutputExit('invalid_attribute');

            // sku 信息
            $this->product_sku_info[$key]['sn'] = $value['sn'];
            $this->product_sku_info[$key]['purchase_price'] = $value['purchase_price'];
            $this->product_sku_info[$key]['stock'] = ($value['stock'] > 0) ? $value['stock'] : 0;

            // 资源信息
            if(isset($value['resource']) && is_array($value['resource']) && !empty($value['resource'])) {
                foreach($value['resource'] as $k=>$resource_id) {
                    $this->product_resource_info[$key][$k]['resource_id'] = $resource_id;
                }
            }
        }
    }
}