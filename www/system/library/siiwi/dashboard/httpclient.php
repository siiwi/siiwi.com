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

    public function signature()
    {
        $time = time();
        $this->signature = "key={$this->client_key}&t={$time}&signature=" . sha1($this->client_secret . $time);
    }

    public function post($route, $post_params=array())
    {
        $this->method = 'POST';
        $this->route = $route;
        $this->post_params = $post_params;

        $this->doRequest();
    }

    public function get($route, $put_params=array())
    {
        $this->method = 'GET';
        $this->route = $route;
        $this->put_params = $put_params;

        $this->doRequest();
    }

    public function delete($route, $put_params=array())
    {
        $this->method = 'DELETE';
        $this->route = $route;
        $this->put_params = $put_params;

        $this->doRequest();
    }

    public function put($route, $put_params=array(), $post_params=array())
    {
        $this->method = 'PUT';
        $this->route = $route;
        $this->put_params = $put_params;
        $this->post_params = $post_params;

        $this->doRequest();
    }

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

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        if (is_array($this->post_params) && !empty($this->post_params)) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->post_params));
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

    public function getResult()
    {
        return json_decode($this->result, true);
    }

    public function getResponseStatus()
    {
        $response = json_decode($this->result, true);

        return (isset($response['code']) && ($response['code'] == 100000)) ? true : false;
    }

    public function getResponseCode()
    {
        $response = json_decode($this->result, true);

        return isset($response['code']) ? $response['code'] : 0;
    }

    public function getResponseMessage()
    {
        $response = json_decode($this->result, true);

        return isset($response['message']) ? $response['message'] : '';
    }

    public function getResponseData()
    {
        $response = json_decode($this->result, true);

        return isset($response['data']) ? $response['data'] : '';
    }
}
