<?php

namespace Siiwi\Api;

class Request extends \Request
{
    /**
     * @return bool
     * 判断http请求是否为post请求
     */
    public function isPost()
    {
        return ('POST' == $_SERVER['REQUEST_METHOD']);
    }

    /**
     * @return bool
     * 判断http请求是否为get请求
     */
    public function isGet()
    {
        return ('GET' == $_SERVER['REQUEST_METHOD']);
    }

    /**
     * @return bool
     * 判断http请求是否为delete请求
     */
    public function isDelete()
    {
        return ('DELETE' == $_SERVER['REQUEST_METHOD']);
    }

    /**
     * @return bool
     * 判断http请求是否为put请求
     */
    public function isPut()
    {
        return ('PUT' == $_SERVER['REQUEST_METHOD']);
    }

    /**
     * @param $email
     * @return bool
     * 判断email格式是否合法
     */
    public function isEmail($email)
    {
        return preg_match('/^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/', $email);
    }

    /**
     * @param $key
     * @param $default
     * @return string
     * 获取post流中的参数值
     */
    public function getHttpPost($key, $default=false)
    {
        return isset($this->post[$key]) ? $this->post[$key] : $default;
    }

    /**
     * @param $key
     * @param $default
     * @return string
     * 获取get流中的参数值
     */
    public function getHttpGet($key, $default=false)
    {
        return isset($this->get[$key]) ? $this->get[$key] : $default;
    }
}