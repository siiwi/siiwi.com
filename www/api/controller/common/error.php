<?php

/**
 * Class ControllerCommonError
 * 未匹配路由统一错误输出
 */

class ControllerCommonError extends \Siiwi\Api\Controller
{
    public function index()
    {
        $this->response->jsonOutputExit('bad_request');
    }
}