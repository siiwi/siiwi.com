<?php

namespace Siiwi\Api;

class Response extends \Response
{
    private $json_output_message;
    private $json_output_data;
    private $json_output_request;
    private $message;

    /**
     * @param $message
     * 设置消息列表
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return int
     * 获取消息码
     */
    private function getOutputMessageCode()
    {
        return ($this->json_output_message && in_array($this->json_output_message, $this->message)) ? array_search($this->json_output_message, $this->message) : 100001;
    }

    /**
     * @return string
     * 获取消息
     */
    private function getOutputMessage()
    {
        return ($this->json_output_message && in_array($this->json_output_message, $this->message)) ? $this->json_output_message : 'bad_request';
    }

    /**
     * @param $request
     * 设置请求路由
     */
    public function setRequest($request)
    {
        $this->json_output_request = $request;
    }

    /**
     * @return string
     * 获取请求路由
     */
    private function getOutputRequest()
    {
        return $this->json_output_request ? $this->json_output_request : '';
    }

    /**
     * @return array
     * 获取输出数据
     */
    private function getOutputData()
    {
        return ($this->json_output_data) ? $this->json_output_data : array();
    }

    /**
     * 设置响应消息
     */
    private function setJsonOutput()
    {
        $output['code'] = (int) $this->getOutputMessageCode();
        $output['message'] = $this->getOutputMessage();
        $output['request'] = $this->getOutputRequest();
        $output['data'] = $this->getOutputData();

        $this->output = json_encode($output);
    }

    /**
     * @param $output_message
     * @param array $output_data
     * 输出响应消息
     */
    public function jsonOutput($output_message, $output_data=array())
    {
        $this->json_output_message = $output_message;
        $this->json_output_data = $output_data;
        $this->setJsonOutput();
    }

    /**
     * @param $output_message
     * @param array $output_data
     * 输出响应消息并退出
     */
    public function jsonOutputExit($output_message, $output_data=array())
    {
        $this->jsonOutput($output_message, $output_data);
        $this->output();
        exit;
    }
}
