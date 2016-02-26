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
     * ����ǩ��
     * ǩ���㷨��sha1($client_secret.$time)
     */
    public function signature()
    {
        $time = time();
        $this->signature = "key={$this->client_key}&t={$time}&signature=" . sha1($this->client_secret . $time);
    }

    /**
     * @param $route
     * @param array $post_params
     * ����POST����
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
     * ����GET����
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
     * ����DELETE����
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
     * ����PUT����
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
     * ִ������
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

        curl_setopt($ch, CURLOPT_URL, $url); // ��Ҫ��ȡ��URL��ַ
        curl_setopt($ch, CURLOPT_FAILONERROR, false); // ��ʾHTTP״̬�룬Ĭ����Ϊ�Ǻ��Ա��С�ڵ���400��HTTP��Ϣ
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // ��curl_exec()��ȡ����Ϣ���ļ�������ʽ���أ�������ֱ�����
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // ����ʱ�Ὣ���������������ص�"Location: "����header�еݹ�ķ��ظ���������ʹ��CURLOPT_MAXREDIRS�����޶��ݹ鷵�ص����������Ϻ�Ϳ��Բɼ��ˣ���ֹ302��301����
        curl_setopt($ch, CURLOPT_TIMEOUT, 5); // ����cURL����ִ�е������
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); // �ڷ�������ǰ�ȴ���ʱ�䣬�������Ϊ0�������޵ȴ�

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
     * �������
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
     * ��ȡ�ӿڷ���״̬
     * @return bool
     */
    public function getResponseStatus()
    {
        $response = json_decode($this->result, true);

        return (isset($response['code']) && ($response['code'] == 100000)) ? true : false;
    }

    /**
     * ��ȡ�ӿڷ���״̬��
     * @return int
     */
    public function getResponseCode()
    {
        $response = json_decode($this->result, true);

        return isset($response['code']) ? $response['code'] : 0;
    }

    /**
     * ��ȡ�ӿڷ�����Ϣ
     * @return int
     */
    public function getResponseMessage()
    {
        $response = json_decode($this->result, true);

        return isset($response['message']) ? $response['message'] : '';
    }

    /**
     * ��ȡ�ӿڷ�������
     * @return array
     */
    public function getResponseData()
    {
        $response = json_decode($this->result, true);

        return isset($response['data']) ? $response['data'] : '';
    }
}
