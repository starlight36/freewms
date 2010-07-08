<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/
/*
 * 格式类组件 用于处理输出格式
 */
class Format {
	
	/**
	 * 截取指定长度的文字
	 * @param string $string 输入的字符串
	 * @param int $sublen 要截取的长度
	 * @param int $start 截取起点
	 * @param string $extstr 省略号
	 * @param string $code 内容编码
	 * @return string
	 */
	public static function str_sub($string, $sublen, $start = 0, $extstr = '...', $code = "UTF-8") {
		if($code == 'UTF-8') {
			$pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
			$t_string = array();
			preg_match_all($pa, $string, $t_string);
			if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen)).$extstr;
			return join('', array_slice($t_string[0], $start, $sublen));
		}else{
			$start = $start*2;
			$sublen = $sublen*2;
			$strlen = strlen($string);
			$tmpstr = '';
			for ($i=0; $i< $strlen; $i++) {
				if($i>=$start && $i< ($start+$sublen)){
					if(ord(substr($string, $i, 1))>129){
					   $tmpstr.= substr($string, $i, 2);
					}else{
					   $tmpstr.= substr($string, $i, 1);
					}
				}
				if(ord(substr($string, $i, 1))>129) $i++;
			}
			if(strlen($tmpstr)< $strlen) $tmpstr.= $extstr;
			return $tmpstr;
		}
	}

	/**
	 * 将字节数转换为可读的文件大小
	 * @param int $filesize
	 * @return string
	 */
	public static function filesize($filesize) {
		$size = sprintf("%u", $filesize);
		if($size == 0) {
			return "0 Bytes";
		}
		$sizename = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
		return round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $sizename[$i];
	}

	/**
	 * 根据扩展名得到文件类型标识
	 * @param string $ext_name
	 */
	public static function filetype($ext_name) {
		$typelist = array(
			'image' => array('jpg', 'png', 'gif', 'jpge', 'bmp'),
			'flash' => array('swf'),
			'sound' => array('mp3', 'wma', 'wav', 'mid', 'ape', 'ra'),
			'video' => array('wmv', 'avi', 'rm', 'rmvb', 'flv', 'asf', 'mpg', 'mp4', '3gp'),
			'pdf' => array('pdf'),
			'archive' => array('zip', 'rar', 'gz', 'tar', '7z', 'iso', 'img'),
			'document' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'pps', 'pptx', 'txt', 'ini', 'html', 'htm'),
		);
		$ext_name = strtolower($ext_name);
		foreach($typelist as $k => $v) {
			if(in_array($ext_name, $v)) {
				return $k;
			}
		}
		return 'unknown';
	}
}
/* End of the file */