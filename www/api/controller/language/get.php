<?php

/**
 * Class ControllerLanguageGet
 *
 * 获取语言列表API接口
 *
 * @method GET
 */
class ControllerLanguageGet extends Siiwi\Api\Controller
{
    public function index()
    {
        $this->isGet();

        $this->load->model('global/language');

        $language = $this->model_global_language->fetchAll(array('status'=>1));

        $this->response->jsonOutput('success', $language);
    }
}