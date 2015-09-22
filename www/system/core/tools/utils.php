<?php
class Utils{
	/**
	 * 去除划线
	 * @param string $input
	 * @param string $split
	 * @param bool $lower
	 */
	public static function camelize($input,$split='_', $lower = false){
		$result    = '';
		$words     = explode($split, $input);
		$wordCount = count($words);
		for ($i = 0; $i < $wordCount; $i++) {
			$word = $words[$i];
			if (!($i === 0 && $lower === false)) {
				$word = ucfirst($word);
			} else {
				$word = strtolower($word);
			}
			$result .= $word;
		}
		return $result;
	}
	/**
	 * 读取Cache文件
	 * @param Cache_Lite $oCache
	 * @param string $id
	 * @param string $group
	 */
	public static function getCache($oCache,$id,$group){
		if (extension_loaded('zlib')) {
			if($result = $oCache->get($id,$group,true)){
				return unserialize(gzuncompress($result));
			}
		}
		return false;
	}
	/**
	 * 保存Cache文件
	 * @param Cache_Lite $oCache
	 * @param string $id
	 * @param string $group
	 * @param array $data
	 * @param string $cachePath
	 */
	public static function saveCache($oCache,$id,$group,$data,$cachePath){
		if (is_writable($cachePath) && extension_loaded('zlib')) {
			$data = gzcompress(serialize($data), 9);
			return $oCache->save($data,$id,$group);
		}
		return false;
	}
	/**
	 * 删除Cache文件
	 * @param Cache_Lite $oCache
	 * @param string $id
	 * @param string $group
	 */
	public static function removeCache($oCache,$id,$group){
		return $oCache->remove($id, $group);
	}
	
	//获取完整URL链接，组装参数
	public static function gen($baseUrl,$params=array()){
		$requestUrl = $baseUrl . "?";
		foreach ($params as $paramKey => $paramValue){
			$requestUrl .= "$paramKey=" . urlencode($paramValue) . "&";
		}
		return $requestUrl = substr($requestUrl, 0, -1);
	}
	
	//比较后面的各字符串是否任意一个存在在前面的字符串里，
	//如存在任意一个或多个，返回true
	//如都不存在，返回false
	public static function strstrs($baseStr,$strs=array()){
		$c1 = count($strs);
		$result = false;
		for($i=0;$i<$c1;$i++){
			if(strstr(strtolower(trim($baseStr)),strtolower($strs[$i]))){
				$result = true;
				break;
			}
		}
		
		return $result;
	}
	
	//判断是否xml
	public static function isXml($xml_str){ 
        $xml_parser = xml_parser_create(); 
        if(!xml_parse($xml_parser,$xml_str,true)){ 
            xml_parser_free($xml_parser); 
            return false; 
        }else { 
            return (json_decode(json_encode(simplexml_load_string($xml_str)),true)); 
        } 
    }
	
	public static function getIP() {  
		$unknown = 'unknown';  
		if ( isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown) ) {  
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
		} elseif ( isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown) ) {  
			$ip = $_SERVER['REMOTE_ADDR'];  
		}
		/*  
		处理多层代理的情况  
		或者使用正则方式：$ip = preg_match("/[\d\.]
		{7,15}/", $ip, $matches) ? $matches[0] : $unknown;  
		*/  
		if (false !== strpos($ip, ',')) $ip = reset(explode(',', $ip));  
		return $ip;
	}
	
	 
	function getip_out(){ 
		$ip=false; 
		if(!empty($_SERVER["HTTP_CLIENT_IP"])){ 
		$ip = $_SERVER["HTTP_CLIENT_IP"]; 
		} 
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
		$ips教程 = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']); 
		if ($ip) { array_unshift($ips, $ip); $ip = FALSE; } 
		for ($i = 0; $i < count($ips); $i++) { 
		if (!eregi ("^(10│172.16│192.168).", $ips[$i])) { 
		$ip = $ips[$i]; 
		break; 
		} 
		} 
		} 
		return ($ip ? $ip : $_SERVER['REMOTE_ADDR']); 
	} 

	
}