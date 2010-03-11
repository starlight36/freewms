<?php
/*
 * 系统及增强函数
*/

/* 文件函数兼容及增强 */

/**
 * 写入文件兼容
 * @param string $file 要写入的文件路径
 * @param string $data 要写入的内容
 * @param string $append 打开魔术
 * @return int
 */
if(!function_exists('file_put_contents')) {
	function file_put_contents($file, $data, $append = '') {
		$mode = $append == '' ? 'wb' : 'ab';
		$fp = @fopen($file, $mode) or exit("Can not open file $file !");
		flock($fp, LOCK_EX);
		$len = @fwrite($fp, $data);
		flock($fp, LOCK_UN);
		@fclose($fp);
		return $len;
	}
}

/**
 * 读取文件兼容
 * @param string $file 要读取的文件路径
 * @return string
 */
if(!function_exists('file_get_contents')) {
	function file_get_contents($file) {
		$filerec = @fopen($file, "r");
		$fsize = @filesize($file);
		if ($fsize <= 0) {
			return NULL;
		}
		@flock($filerec, LOCK_SH);
		$fdata = @fread($filerec, $fsize);
		@fclose($filerec);
		return $fdata;
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