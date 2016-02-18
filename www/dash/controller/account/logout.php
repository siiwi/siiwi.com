<?php

/**
 * 退出登录
 */
class ControllerAccountLogout extends \Siiwi\Dashboard\BaseController
{
    public function index()
    {
        session_destroy();
        setcookie('UIN', '', time()-3600, '/', $this->request->server['HTTP_HOST']);
        $this->url->redirect('account/login');
    }
}