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
		$key = md5(SAFETY_STRING.$key);
		$path = BASEPATH.CACHE_PATH.'data/'.substr($key,0,2)."/".substr($key,2,2).'/';
		if(!is_dir($path)) {
			create_dir($path);
		}
		$cache_file = $path.$key.'.cache';
		$value = serialize($value);
		file_put_contents($cache_file, $value);
		return TRUE;
	}

	/**
	 * 读取缓存
	 * @param string $key 缓存名
	 * @return unknown
	 */
	public static function get($key, $expires = NULL) {
		$key = md5(SAFETY_STRING.$key);
		$path = BASEPATH.CACHE_PATH.'data/'.substr($key,0,2)."/".substr($key,2,2).'/';
		$cache_file = $path.$key.'.cache';
		if(!is_file($cache_file)) {
			return FALSE;
		}else{
			if($expires == NULL) {
				$expires = CACHE_EXPIRES;
			}
			$file_create_time = filectime($cache_file);
			if($expires > 0 && gmmktime() - $file_create_time > $expires) {
				return FALSE;
			}else{
				return unserialize(file_get_contents($cache_file));
			}
		}
	}

	/**
	 * 删除一个缓存
	 * @param string $key 缓存名
	 * @return bool
	 */
	public static function delete($key) {
		$key = md5(SAFETY_STRING.$key);
		$path = BASEPATH.CACHE_PATH.'data/'.substr($key,0,2)."/".substr($key,2,2).'/';
		$cache_file = $path.$key.'.cache';
		@unlink($cache_file);
		return TRUE;
	}

	/**
	 * 删除全部缓存文件
	 * @return bool
	 */
	public static function clear() {
		$path = BASEPATH.CACHE_PATH.'data/';
		rm_file($path);
		if(!is_dir($path)) {
			create_dir($path);
		}
		return TRUE;
	}
}

/* End of this file */