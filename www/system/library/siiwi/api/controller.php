<?php

namespace Siiwi\Api;

class Controller extends \Controller
{
    protected $limit_array = array();

    /**
     * 判断请求方法是否是POST请求
     * @param bool $return
     * @return bool
     */
    public function isPost($return=false)
    {
        return $this->request->isPost() ? ($return ? true : '') : ($return ? false : $this->response->jsonOutputExit('bad_request_method'));
    }

    /**
     * 判断请求方法是否是GET请求
     * @param bool $return
     * @return bool
     */
    public function isGet($return=false)
    {
        return $this->request->isGet() ? ($return ? true : '') : ($return ? false : $this->response->jsonOutputExit('bad_request_method'));
    }

    /**
     * 判断请求方法是否是DELETE请求
     * @param bool $return
     * @return bool
     */
    public function isDelete($return=false)
    {
        return $this->request->isDelete() ? ($return ? true : '') : ($return ? false : $this->response->jsonOutputExit('bad_request_method'));
    }

    /**
     * 判断请求方法是否是PUT请求
     * @param bool $return
     * @return bool
     */
    public function isPut($return=false)
    {
        return $this->request->isPut() ? ($return ? true : '') : ($return ? false : $this->response->jsonOutputExit('bad_request_method'));
    }

    /**
     * 验证access_token是否有效
     */
    public function verifyToken()
    {
        $acces_token = (!$this->request->getHttpGet('access_token')) ? $this->response->jsonOutputExit('empty_access_token') : $this->request->getHttpGet('access_token');
        $token_info = $this->model_global_token->fetchOne(array('access_token'=>$acces_token));
        if(!is_array($token_info) || empty($token_info) || ($token_info['client_id'] != $this->config->get('client_id')) || ($token_info['expires'] < time())) {
            $this->response->jsonOutputExit('invalid_access_token');
        }
        $this->config->set('user_id', $token_info['user_id']);
    }

    /**
     * 验证当前用户是否为超级用户
     * @param bool $return
     * @return bool
     */
    public function verifySuperUser($return=false)
    {
        $user_info = $this->model_user_main->fetchOne(array('user_id'=>$this->config->get('user_id'), 'role'=>1, 'status'=>1));
        return (is_array($user_info) && !empty($user_info)) ? ($return ? true : '') : ($return ? false : $this->response->jsonOutputExit('user_not_allowed'));
    }

    /**
     * 获取父级用户ID
     * @return int $user_id
     */
    public function getParentUserId()
    {
        $user_info = $this->model_user_main->fetchOne(array('user_id'=>$this->config->get('user_id')));
        return ($user_info['role'] == 1) ? $this->config->get('user_id') : $user_info['parent_user_id'];
    }

    /**
     * 设置分页参数
     */
    public function pagination()
    {
        if(($this->request->getHttpGet('page_size') !== false) || ($this->request->getHttpGet('page') !== false)) {
            $page = 0;
            $page_size = $this->request->getHttpGet('page_size') ? $this->request->getHttpGet('page_size') : $this->config->get('page_size');

            if($this->request->getHttpGet('page') !== false) {
                $page = ($this->request->getHttpGet('page') > 1) ? ($this->request->getHttpGet('page') - 1) : 0;
            }

            $this->limit_array['offset'] = $page * $page_size;
            $this->limit_array['rows'] = $page_size;
        }
    }

    /**
     * 判断改组是否属于该用户
     * @param int $user_id
     * @param int $group_id
     * @param bool $return
     * @return bool
     */
    public function checkUserGroup($user_id, $group_id, $return=false)
    {
        $group_info = $this->model_group_main->fetchOne(array('group_id'=>$group_id, 'user_id'=>$user_id, 'status'=>1));
        return (is_array($group_info) && !empty($group_info)) ? ($return ? true : '') : ($return ? false : $this->response->jsonOutputExit('invalid_group_id'));
    }

    /**
     * 判断自定义分类是否属于该用户
     * @param int $user_id
     * @param int $category_id
     * @param bool $return
     * @return bool
     */
    public function checkUserCategory($user_id, $category_id, $return=false)
    {
        $category_info = $this->model_category_main->fetchOne(array('category_id'=>$category_id, 'status'=>1));
        if(!is_array($category_info) || empty($category_info)) {
            return $return ? false : $this->response->jsonOutputExit('invalid_category_id');
        }

        if($category_info['type'] == 2 && $category_info['user_id'] != $user_id) {
            return $return ? false : $this->response->jsonOutputExit('user_not_allowed');
        }

        return true;
    }

    /**
     * 判断店铺是否属于该用户
     * @param int $user_id
     * @param int $store_id
     * @param bool $return
     * @return bool
     */
    public function checkUserStore($user_id, $store_id, $return=false)
    {
        $store_info = $this->model_store_main->fetchOne(array('store_id'=>$store_id, 'user_id'=>$user_id, 'status'=>1));
        return (is_array($store_info) && !empty($store_info)) ? ($return ? true : '') : ($return ? false : $this->response->jsonOutputExit('invalid_store_id'));
    }

    /**
     * 判断品牌是否属于该用户
     * @param int $user_id
     * @param int $brand_id
     * @param bool $return
     * @return bool
     */
    public function checkUserBrand($user_id, $brand_id, $return=false)
    {
        $brand_info = $this->model_brand_main->fetchOne(array('brand_id'=>$brand_id, 'user_id'=>$user_id, 'status'=>1));
        return (is_array($brand_info) && !empty($brand_info)) ? ($return ? true : '') : ($return ? false : $this->response->jsonOutputExit('invalid_brand_id'));
    }

    /**
     * 判断供应商是否属于该用户
     * @param int $user_id
     * @param int $supplier_id
     * @param bool $return
     * @return bool
     */
    public function checkUserSupplier($user_id, $supplier_id, $return=false)
    {
        $supplier_info = $this->model_supplier_main->fetchOne(array('supplier_id'=>$supplier_id, 'user_id'=>$user_id, 'status'=>1));
        return (is_array($supplier_info) && !empty($supplier_info)) ? ($return ? true : '') : ($return ? false : $this->response->jsonOutputExit('invalid_supplier_id'));
    }
}