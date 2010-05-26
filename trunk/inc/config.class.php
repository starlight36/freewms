<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 设置类
 */
class Config {

	private static $config = array();

	private function   __construct() {
		return FALSE;
	}

	private function  __clone() {
		return FALSE;
	}

	/**
	 * 加载一个配置文件
	 * @param string $file
	 */
	public static function load($file) {
		$file = BASEPATH.'config/'.strtolower($file).'.php';
		if(is_file($file)) {
			@include $file;
			self::$config = array_merge(self::$config, $config);
		}
	}

	/**
	 * 读取一个配置项
	 * @param string $str
	 * @return mixed
	 */
	public static function get($str) {
		return path_array(self::$config, $str);
	}

	/**
	 * 动态修改一个配置值
	 * @param string $str
	 * @param mixed $v
	 */
	public static function set($str, $v) {
		$value =& path_array(self::$config, $str);
		$value = $v;
	}
}
/* End of this file */