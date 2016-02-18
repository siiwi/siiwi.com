<?php

/**
 * Class ControllerSignatureVerify
 * 验证url签名信息
 *
 * @method GET
 * @param string $signature
 * @param int $t
 * @param int $key
 */
class ControllerSignatureVerify extends \Siiwi\Api\Controller
{
    public function index()
    {
        // URL中是否传入签名
        $signature = (!$this->request->getHttpGet('signature')) ? $this->response->jsonOutputExit('empty_signature') : $this->request->getHttpGet('signature');

        // URL中是否传入当前请求时间戳
        $timestamp = (!$this->request->getHttpGet('t')) ? $this->response->jsonOutputExit('empty_timestamp') : $this->request->getHttpGet('t');

        // URL中是否传入客户端key
        $client_key = (!$this->request->getHttpGet('key')) ? $this->response->jsonOutputExit('empty_key') : $this->request->getHttpGet('key');

        $this->load->model('global/client');

        // 获取客户端信息
        $client_info = $this->model_global_client->fetchOne(array('client_key'=>$client_key, 'status'=>1));
        if(!is_array($client_info) || empty($client_info)) {
            $this->response->jsonOutputExit('invalid_key');
        }

        // 验证签名
        ($signature != sha1($client_info['client_secret'] . $timestamp)) ? $this->response->jsonOutputExit('invalid_signature') : $this->config->set('client_id', $client_info['client_id']);
    }
}