<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-----------------------------------------------*/

/*-------------------------------------------------
 | 系统函数库
 *-----------------------------------------------*/

/**
 * 取消全局变量注册
 *
 * @return bool
 */
function unregister_globals() {
	if (!ini_get('register_globals')) {
		return FALSE;
	}
	$arr_pass_unset = array('_GET', '_POST', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
	$arr_input = array_merge($_GET, $_POST,	$_COOKIE, $_SERVER, $_ENV, $_FILES, isset($_SESSION) && is_array($_SESSION) ? $_SESSION : array());
	foreach ($arr_input as $key => $value) {
		if ($key == 'GLOBALS') {
			unset_globals($arr_input[$key]);
		}elseif (!in_array($key, $arr_pass_unset) && isset($GLOBALS[$key])) {
			unset($GLOBALS[$key]);
		}
	}
	unset($HTTP_GET_VARS, $HTTP_POST_VARS, $HTTP_COOKIE_VARS, $HTTP_SERVER_VARS, $HTTP_ENV_VARS);
	return TRUE;
}

/**
 * 清空全局数组
 *
 * @param array $arr_global 要清空的数组
 */
function unset_globals($arr_global) {
	if (is_array($arr_global)) {
		foreach ($arr_global as $key => $value) {
			if ($key == "GLOBALS") unset_globals($arr_global[$key]);
			unset($GLOBALS[$key]);
		}
	}
}

/**
 * 建立多层目录
 * @param string $path 要建立的路径
 */
function create_dir($path) {
	if (!file_exists($path)) {
		create_dir(dirname($path));
		mkdir($path, 0777);
	}
}

/**
 * 删除一个文件(夹)
 * @param string $path 要删除的路径
 * @return bool
 */
function rm_file($path) {
	if(!is_dir($path)) {
		return unlink($path);
	}else{
		$str = scandir($path);
		foreach($str as $file) {
			if($file != "." && $file != "..") {
				$path = $path."/".$file;
				if(!is_dir($path)) {
					unlink($path);
				}else{
					rm_file($path);
				}
			}
		}
		if(rmdir($path)) {
			return TRUE;
		}else{
			return FALSE;
		}
	}
}

/**
 * 取得扩展名
 * @param string $filename 文件路径
 * @return string
 */
function file_ext_name($filename) {
	return strtolower(trim(substr(strrchr($filename, '.'), 1, 10)));
}

/* JSON函数兼容 */

/**
 * 兼容性json编码函数
 * @param unknown $a 要编码的内容
 * @return string
 */
if(!function_exists('json_encode')) {
	function json_encode($a = false) {
		if (is_null($a)) return 'null';
		if ($a === false) return 'false';
		if ($a === true) return 'true';
		if (is_scalar ($a)) {
			if (is_float($a)) {
				return floatval(str_replace(",", ".", strval($a)));
			}
			if (is_string($a)) {
				static $jsonReplaces = array(
					array ('\\', '/', '\n', '\t', '\r', '\b', '\f', '"'),
					array ('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"')
				);
				return '"'.str_replace($jsonReplaces [0], $jsonReplaces [1], $a).'"';
			}else{
				return $a;
			}
		}
		$isList = true;
		for($i = 0, reset($a); $i < count ($a); $i ++, next ($a)) {
			if (key($a) !== $i) {
				$isList = false;
				break;
			}
		}
		$result = array();
		if ($isList) {
			foreach ($a as $v)
				$result [] = json_encode($v);
			return '['.join( ',', $result ).']';
		}else{
			foreach($a as $k => $v)
				$result[] = json_encode($k).':'.json_encode($v);
			return '{'.join(',', $result).'}';
		}
	}
}

/**
 * 兼容性json解码函数
 * @param string $data 要解码的json串
 * @return unknown
 */
if(!function_exists('json_decode')) {
	function json_decode($data) {
		static $strings,$count=0;
		if (is_string($data)) {
			$data = trim($data);
			if ($data{0} != '{' && $data{0} != '[') return json_utf_slash_strip($data);
			$strings = array();
			$data = preg_replace_callback('/"([\s\S]*?(?<!\\\\)(?:\\\\\\\\)*)"/',__FUNCTION__,$data);
			//简单的危险性检测
			//echo $data;
			$cleanData = str_ireplace(array('true','false','undefined','null','{','}','[',']',',',':','#'),'',$data);
			if (!is_numeric($cleanData)) {
				throw new Exception('Dangerous!The JSONString is dangerous!');
				return NULL;
			}
			$data = str_replace(
					array('{','[',']','}',':','null'),
					array('array(','array(',')',')',' = >','NULL')
					,$data);
			$data = preg_replace_callback('/#\d+/',__FUNCTION__,$data);
			//抑制错误,诸如{123###}这样错误的JSON是不能转换成PHP数组的
			@$data = eval("return $data;");
			$strings = $count = 0;
			return $data;
		} elseif (count($data)>1) {//存储字符串
			$strings[] = json_utf_slash_strip(str_replace(array('$','\\/'),array('\\$','/'),$data[0]));
			return '#'.($count++);
		} else {//读取存储的值
			$index = substr($data[0],1);
			return $strings[$index];
		}
	}
}

/**
 * 以PATH形式读取数组元素
 * @param array $array
 * @param string $path
 * @return unknown
 */
function &path_array(&$array, $path = NULL) {
	if(empty($path) || !is_array($array)) {
		return $array;
	}else{
		$arr_path = explode('/', $path);
		$path = NULL;
		foreach($arr_path as $v){
			$path .= '[\''.addslashes($v).'\']';
		}
		eval('$value =& $array'.$path.';');
		return $value;
	}
}

/**
 * 发送404错误
 * @param string $tip 错误消息
 */
function show_404($tip = 'Not Found') {
	ob_clean();
	@header('HTTP/1.1 404 '.$tip);
	exit();
}

/**
 * 重定向到一个URL
 * @param string $url
 * @param string $method
 * @param int $http_response_code
 */
function redirect($url = '', $method = 'location', $http_response_code = 302) {
	if(!preg_match('#^https?://#i', $url)) {
		$url = URL::base().$url;
	}
	switch($method) {
		case 'refresh': header("Refresh:0;url=".$url);
			break;
		default : header("Location: ".$url, TRUE, $http_response_code);
			break;
	}
	exit;
}

/**
 * 安全化输入数据
 * @param str/array $str
 * @return str/array
 */
function clean_input_data($str) {
	if(is_array($str)) {
		$new_array = array();
		foreach ($str as $key => $val) {
			$new_array[clean_input_keys($key)] = clean_input_data($val);
		}
		return $new_array;
	}
	if(get_magic_quotes_gpc()) {
		$str = stripslashes($str);
	}
	if(strpos($str, "\r") !== FALSE) {
		$str = str_replace(array("\r\n", "\r"), "\n", $str);
	}
	return $str;
}

/**
 * 安全化输入数组键名
 * @param str $str
 * @return str
 */
function clean_input_keys($str) {
	if(!preg_match("/^[a-z0-9:_\/-]+$/i", $str)) {
		exit('Disallowed Key Characters.');
	}
	return $str;
}

/**
 * 获取用户客户端真实IP
 *
 * @return string
 */
function get_ip() {
	if ($_SERVER['HTTP_X_FORWARDED_FOR']) {
		$t_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}elseif($_SERVER['HTTP_CLIENT_IP']){
		$t_ip = $_SERVER['HTTP_CLIENT_IP'];
	}else{
		$t_ip = $_SERVER['REMOTE_ADDR'];
	}
	return $t_ip;
}

/**
 * 获取当前精确时间
 *
 * @return float
 */
function get_micro_time() {
	list($msec, $sec) = explode(" ",microtime());
	return ((float)$msec + (float)$sec);
}
/* End of this file */