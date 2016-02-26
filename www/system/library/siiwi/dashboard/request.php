<?php

namespace Siiwi\Dashboard;

class Request extends \Request
{
    /**
     * @return bool
     * �ж������Ƿ���ajax����
     */
    public function isAjax()
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) ? true : false;
    }

    /**
     * @return bool
     * �ж�http�����Ƿ�Ϊpost����
     */
    public function isPost()
    {
        return ('POST' == $_SERVER['REQUEST_METHOD']);
    }

    /**
     * @return bool
     * �ж�http�����Ƿ�Ϊget����
     */
    public function isGet()
    {
        return ('GET' == $_SERVER['REQUEST_METHOD']);
    }

    /**
     * @return bool
     * �ж�http�����Ƿ�Ϊdelete����
     */
    public function isDelete()
    {
        return ('DELETE' == $_SERVER['REQUEST_METHOD']);
    }

    /**
     * @param $email
     * @return bool
     * �ж�email��ʽ�Ƿ�Ϸ�
     */
    public function isEmail($email)
    {
        return preg_match('/^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/', $email);
    }

    /**
     * @param $key
     * @param $default
     * @return string
     * ��ȡpost���еĲ���ֵ
     */
    public function getHttpPost($key, $default=false)
    {
        return isset($this->post[$key]) ? $this->post[$key] : $default;
    }

    /**
     * @param $key
     * @param $default
     * @return string
     * ��ȡget���еĲ���ֵ
     */
    public function getHttpGet($key, $default=false)
    {
        return isset($this->get[$key]) ? $this->get[$key] : $default;
    }
}