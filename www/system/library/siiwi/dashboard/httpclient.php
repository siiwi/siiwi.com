<?php

namespace Siiwi\Dashboard;

class HttpClient
{
    public $host;
    public $client_key;
    public $client_secret;
    public $signature;
    public $access_token;
    private $method;
    private $route;
    private $put_params;
    private $post_params;
    private $result;

    /**
     * 设置签名
     * 签名算法：sha1($client_secret.$time)
     */
    public function signature()
    {
        $time = time();
        $this->signature = "key={$this->client_key}&t={$time}&signature=" . sha1($this->client_secret . $time);
    }

    /**
     * @param $route
     * @param array $post_params
     * 发起POST请求
     */
    public function post($route, $post_params=array())
    {
        $this->method = 'POST';
        $this->route = $route;
        $this->post_params = $post_params;

        $this->doRequest();
    }

    /**
     * @param $route
     * @param array $put_params
     * 发起GET请求
     */
    public function get($route, $put_params=array())
    {
        $this->method = 'GET';
        $this->route = $route;
        $this->put_params = $put_params;

        $this->doRequest();
    }

    /**
     * @param $route
     * @param array $put_params
     * 发起DELETE请求
     */
    public function delete($route, $put_params=array())
    {
        $this->method = 'DELETE';
        $this->route = $route;
        $this->put_params = $put_params;

        $this->doRequest();
    }

    /**
     * @param $route
     * @param array $put_params
     * @param array $post_params
     * 发起PUT请求
     */
    public function put($route, $put_params=array(), $post_params=array())
    {
        $this->method = 'PUT';
        $this->route = $route;
        $this->put_params = $put_params;
        $this->post_params = $post_params;

        $this->doRequest();
    }

    /**
     * 执行请求
     */
    private function doRequest()
    {
        $url = $this->host . 'index.php?route=' . $this->route . '&' . $this->signature;

        if ($this->access_token) {
            $url .= '&access_token=' . $this->access_token;
        }

        if(is_array($this->put_params) && !empty($this->put_params)) {
            $url .= '&'.http_build_query($this->put_params);
        }
        
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url); // 需要获取的URL地址
        curl_setopt($ch, CURLOPT_FAILONERROR, false); // 显示HTTP状态码，默认行为是忽略编号小于等于400的HTTP信息
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 将curl_exec()获取的信息以文件流的形式返回，而不是直接输出
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // 启用时会将服务器服务器返回的"Location: "放在header中递归的返回给服务器，使用CURLOPT_MAXREDIRS可以限定递归返回的数量（加上后就可以采集了，防止302，301错误）
        curl_setopt($ch, CURLOPT_TIMEOUT, 5); // 设置cURL允许执行的最长秒数
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); // 在发起连接前等待的时间，如果设置为0，则无限等待

        if (is_array($this->post_params) && !empty($this->post_params)) {
            if ($this->method == 'PUT') {
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->post_params));
            }

            if ($this->method == 'POST') {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $this->post_params);
            }
        }

        if ($this->method == 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        }

        if ($this->method == 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        }

        $this->result = curl_exec($ch);

        curl_close($ch);
    }

    /**
     * 解析结果
     * @return string
     */
    public function getResult()
    {
        $response = json_decode($this->result, true);

        if(is_array($response) && !empty($response) && isset($response['code']) && ($response['code'] == 100000)) {
            $message = $response['data'];
        } else {
            if(isset($response['message']) && $response['message']) {
                $message = $response['message'];
            } else {
                $message = 'system_error';
            }
        }

        return $message;
    }

    /**
     * 获取接口返回状态
     * @return bool
     */
    public function getResponseStatus()
    {
        $response = json_decode($this->result, true);

        return (isset($response['code']) && ($response['code'] == 100000)) ? true : false;
    }

    /**
     * 获取接口返回状态码
     * @return int
     */
    public function getResponseCode()
    {
        $response = json_decode($this->result, true);

        return isset($response['code']) ? $response['code'] : 0;
    }

    /**
     * 获取接口返回消息
     * @return int
     */
    public function getResponseMessage()
    {
        $response = json_decode($this->result, true);

        return isset($response['message']) ? $response['message'] : '';
    }

    /**
     * 获取接口返回数据
     * @return array
     */
    public function getResponseData()
    {
        $response = json_decode($this->result, true);

        return isset($response['data']) ? $response['data'] : '';
    }
}
