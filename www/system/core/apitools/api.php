<?php
/**
 * 版本 2013-3-20
 * Update 2014-11-28
 */
class API{
	public $connectTimeout = 30;
	public $readTimeout = 30;
	public $format = "json";//xml
	public $header = null;
	
    public function __construct(){}
    
	/**
	 * API结果
	 * @param string $responseName 返回的名称
	 * @param array $responseBody 返回的数据
	 * @param int $length 数据长度
	 *
	 * @return json 返回json数据
	 */
	public function result($responseName,$responseBody,$othersName=null,$othersBody=null){
		if($othersName == null)
			return json_encode(array($responseName => $responseBody));
		else
			return json_encode(array($responseName => $responseBody,$othersName => $othersBody));
	}
	/**
	 * 显示状态码及信息
	 * @param string $code 状态码(必填)
	 * @param string $message 状态信息(可选)
	 * @param string $sub_code 子状态码(可选)
	 * @param string $sub_msg 子状态信息(可选)
	 *
	 * @return json 返回json格式数据
	 */
	public function status($code, $message = '', $sub_code=null, $sub_msg=''){
		$statusCodes = parse_ini_file('status_codes/status_codes.ini');
		if(array_key_exists($code, $statusCodes)) {
			$message = $statusCodes[$code].$message;
		} else {
			$message = 'Unknow error.'.$message;
		}
		if (null != $sub_code){
			if(array_key_exists($sub_code, $statusCodes)) {
				$sub_msg = $statusCodes[$sub_code].$sub_msg;
			} else {
				$sub_msg = 'Unknow error.'.$sub_msg;
			}
			$error_response = array('error_response' => array('code' => $code, 'msg' => $message, 'sub_code' => $sub_code,'sub_msg' => $sub_msg));
		}
		else
			$error_response = array('error_response' => array('code' => $code, 'msg' => $message));
			
		echo json_encode($error_response);
	}
	
	/**
	 * 显示状态码及信息
	 * @param int $code 状态码(必填)
	 * @param array  $option:
	 * 		string $option['msg'] 状态补充信息(可选)
	 * 		string $option['format'] 返回格式(json,array,object)(可选)
	 * 		int    $option['sub_code'] 子状态码(可选)
	 * 		string $option['sub_msg'] 子状态补充信息(可选)
	 * @return 默认返回json格式数据
	 */
	public function info($code, $option = array()){
		$statusCodes = parse_ini_file('status_codes/status_codes.ini');
		
		//状态信息
		if(array_key_exists($code, $statusCodes)) {
			if(isset($option['msg'])){
				$message = $statusCodes[$code].'['.$option['msg'].']';
			}else{
				$message = $statusCodes[$code];
			}
		} else {
			if(isset($option['msg'])){
				$message = 'Unknow error ['.$option['msg'].']';
			}else{
				$message = 'Unknow error';
			}
		}
		
		//子状态信息
		if(isset($option['sub_code'])){
			if(array_key_exists($option['sub_code'], $statusCodes)) {
				if(isset($option['sub_msg'])){
					$sub_msg = $statusCodes[$option['sub_code']].'['.$option['sub_msg'].']';
				}else{
					$sub_msg = $statusCodes[$option['sub_code']];
				}
			} else {
				if(isset($option['sub_msg'])){
					$sub_msg = 'Unknow error ['.$option['sub_msg'].']';
				}else{
					$sub_msg = 'Unknow error';
				}
			}
			$error_response = array('error_response' => array('code' => $code, 'msg' => $message, 'sub_code' => $option['sub_code'],'sub_msg' => $sub_msg));
		}else{
			$error_response = array('error_response' => array('code' => $code, 'msg' => $message));
		}
		
		$result = null;
		if(!isset($option['format'])){
			$option['format'] = 'json';
		}
		switch($option['format']){
			case 'json':
				$result = json_encode($error_response);
				break;
			case 'array':
				$result = $error_response;
				break;
			case 'object':
				$result = json_decode(json_encode($error_response));
				break;
			default:
				$result = json_encode($error_response);
		}
		
		return $result;
	}
	
	public function curl($url, $postFields = null)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FAILONERROR, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);//加上后就可以采集了，防止302，301错误
		if ($this->readTimeout) {
			curl_setopt($ch, CURLOPT_TIMEOUT, $this->readTimeout);
		}
		if ($this->connectTimeout) {
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->connectTimeout);
		}
		//https 请求
		if(strlen($url) > 5 && strtolower(substr($url,0,5)) == "https" ) {
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		}

		if (is_array($postFields) && 0 < count($postFields))
		{
			$postBodyString = "";
			$postMultipart = false;
			foreach ($postFields as $k => $v)
			{
				if("@" != substr($v, 0, 1))//判断是不是文件上传
				{
					$postBodyString .= "$k=" . urlencode($v) . "&"; 
				}
				else//文件上传用multipart/form-data，否则用www-form-urlencoded
				{
					$postMultipart = true;
				}
			}
			unset($k, $v);
			curl_setopt($ch, CURLOPT_POST, true);
			if ($postMultipart)
			{
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
			}
			else
			{
				curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString,0,-1));
			}
		}elseif($this->is_xml($postFields)){
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
		}
		$reponse = curl_exec($ch);
		
		if (curl_errno($ch))
		{
			throw new Exception(curl_error($ch),0);
		}
		else
		{
			$httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if (200 !== $httpStatusCode)
			{
				throw new Exception($reponse,$httpStatusCode);
			}
		}
		curl_close($ch);
		return $reponse;
	}
	//post方式
	public function curl_post($url, $postFields = null){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FAILONERROR, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);//加上后就可以采集了，防止302，301错误
		if ($this->readTimeout) {
			curl_setopt($ch, CURLOPT_TIMEOUT, $this->readTimeout);
		}
		if ($this->connectTimeout) {
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->connectTimeout);
		}
		//https 请求
		if(strlen($url) > 5 && strtolower(substr($url,0,5)) == "https" ) {
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		}
		
		if (is_array($postFields) && 0 < count($postFields)) {
			$postBodyString = "";
			$postMultipart = false;
			foreach ($postFields as $k => $v) {
				//判断是不是文件上传
				if(isset($v->name) && isset($v->mime) && isset($v->postname)){
					//文件上传用multipart/form-data，否则用www-form-urlencoded
					$postMultipart = true;
				}
				else{
					$postBodyString .= "$k=" . urlencode($v) . "&"; 
				}
			}
			unset($k, $v);
			curl_setopt($ch, CURLOPT_POST, true);
			if ($postMultipart){
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
			}else{
				curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString,0,-1));
			}
		}else{
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
		}
		
		if($this->header != null) {
			curl_setopt($ch,CURLOPT_HTTPHEADER, $this->header);
		}
		
		$reponse = curl_exec($ch);
		if (curl_errno($ch)){
			throw new Exception(curl_error($ch),0);
		}else{
			$httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if (200 !== $httpStatusCode){
				throw new Exception($reponse,$httpStatusCode);
			}
		}
		curl_close($ch);
		return $reponse;
	}
	//get方式请求
	public function curl_get($url, $getFields = null){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_FAILONERROR, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);//加上后就可以采集了，防止302，301错误
		if ($this->readTimeout) {
			curl_setopt($ch, CURLOPT_TIMEOUT, $this->readTimeout);
		}
		if ($this->connectTimeout) {
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->connectTimeout);
		}
		//https 请求
		if(strlen($url) > 5 && strtolower(substr($url,0,5)) == "https" ) {
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		}
		if(isset($getFields)){
			if(!strpos($url,'?')){
				$params_str = '?';
				foreach($getFields as $k => $v){
					$params_str .= $k.'='.$v.'&';
				}
				$params_str = substr($params_str,0,-1);
				$url .= $params_str;
			}else{
				$params_str = '';
				foreach($getFields as $k => $v){
					$params_str .= '&'.$k.'='.$v;
				}
				$url .= $params_str;
			}
		}
        curl_setopt($ch, CURLOPT_URL, $url);
		if($this->header != null) {
			curl_setopt($ch,CURLOPT_HTTPHEADER, $this->header);
		}
		$reponse = curl_exec($ch);
		if (curl_errno($ch)){
			throw new Exception(curl_error($ch),0);
		}else{
			$httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if (200 !== $httpStatusCode){
				throw new Exception($reponse,$httpStatusCode);
			}
		}
		curl_close($ch);
		return $reponse;
	}
	
	/**
	 * 多线程下载 http://www.phpernote.com/php-function/281.html
	 * $params
	 *  - url : 下载链接
	 *  - fp  : fopen文件
	 * 
	 */
	public function curl_down($params){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_FAILONERROR, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);//加上后就可以采集了，防止302，301错误
		
		$ch = curl_init($params['url']);
		curl_setopt($ch, CURLOPT_FILE, $params['fp']);
		$reponse = curl_exec($ch);
		curl_close($ch);
		
		return $reponse;
	}
	
	public function execute($requestUrl, $apiParams=null, $method='post'){
		//发起HTTP请求
		try{
			if($method=='post'){
				$resp = $this->curl_post($requestUrl, $apiParams);
			}elseif($method=='get'){
				$resp = $this->curl_get($requestUrl, $apiParams);
			}
		}catch (Exception $e){
			return $this->info($e->getCode(),array('msg'=>$e->getMessage(),'format'=>'array'));
		}
		//解析TOP返回结果
		$respWellFormed = false;
		if ("json" == $this->format){
			$respObject = json_decode($resp);
			if (null !== $respObject){
				$respWellFormed = true;
			}
		}else if("xml" == $this->format){
			$respObject = @simplexml_load_string($resp);
			if (false !== $respObject)
			{
				$respWellFormed = true;
			}
		}

		//返回的HTTP文本不是标准JSON或者XML，记下错误日志
		if (false === $respWellFormed){
			$this->info(23,array('msg'=>'response format wrong'));
			return;
		}
		
		return $respObject;
	}
	
	public function executeString($requestUrl, $apiParams=null, $method='post'){
		//发起HTTP请求
		try{
			if($method=='post'){
				$resp = $this->curl_post($requestUrl, $apiParams);
			}elseif($method=='get'){
				$resp = $this->curl_get($requestUrl, $apiParams);
			}
		}catch (Exception $e){
			return $this->info($e->getCode(),array('msg'=>$e->getMessage(),'format'=>'array'));
		}
		return $resp;
	}
}
?>