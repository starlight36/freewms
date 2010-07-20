<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/
class Session {

	private function  __construct() {
		return FALSE;
	}

	private function  __clone() {
		return FALSE;
	}

	/**
	 * 读取一个SESSION的值,使用PATH路径形式
	 * @param string $key
	 * @return unknown
	 */
	public static function get($key) {
		return path_array($_SESSION, $key);
	}

	/**
	 * 设置一个SESSION,使用PATH路径形式
	 * @param string $key
	 * @param unknown $value
	 * @return unknown
	 */
	public static function set($key, $value) {
		$array =& path_array($_SESSION, $key);
		$array = $value;
		return TRUE;
	}

	/**
	 * 注销一个SESSION
	 * @param string $key SESSION key
	 * @return bool
	 */
	public static function clear($key = NULL) {
		$array =& path_array($_SESSION, $key);
		$array = '';
		return TRUE;
	}

	/**
	 * 以FLASH形式取出一个值
	 * @param <type> $key
	 * @return <type>
	 */
	public static function flash($key) {
		$value = self::get($key);
		self::clear($key);
		return $value;
	}
}
/* End of this file */