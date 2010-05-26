<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

class Cache_Adapter {
	/**
	 * 设置缓存
	 * @param string $key 缓存名
	 * @param unknown $value 缓存内容
	 */
	public static function set($key, $value) {
		eaccelerator_lock($key);
        return eaccelerator_put($key, $value, 7200);
	}

	/**
	 * 读取缓存
	 * @param string $key 缓存名
	 * @return unknown
	 */
	public static function get($key, $expires = NULL) {
		return eaccelerator_get($key);
	}

	/**
	 * 删除一个缓存
	 * @param string $key 缓存名
	 * @return bool
	 */
	public static function delete($key) {
		return eaccelerator_rm($key);
	}

	/**
	 * 删除全部缓存文件
	 * @return bool
	 */
	public static function clear() {
		return eaccelerator_gc();
	}
}

/* End of this file */