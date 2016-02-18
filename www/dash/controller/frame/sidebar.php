<?php

class ControllerFrameSidebar extends \Siiwi\Dashboard\BaseController
{
    public function index()
    {
        // 获取当前路由
        $this->data['route'] = $this->request->getHttpGet('route');

        // 返回视图
        return $this->load->view('frame/sidebar.html', $this->data);
    }
}