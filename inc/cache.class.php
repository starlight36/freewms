<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

//装入缓存支持组件
require_once BASEPATH.'inc/cache/'.CACHE_TYPE.'.class.php';

class Cache extends Cache_Adapter {

	private static $cache = NULL;

	private function  __construct() {
		return FALSE;
	}

	private function  __clone() {
		return FALSE;
	}

	/**
	 * 设置缓存
	 * @param string $key 缓存名
	 * @param unknown $value 缓存内容
	 */
	public static function set($key, $value) {
		unset(self::$cache[$key]);
		return parent::set($key, $value);
	}

	/**
	 * 读取缓存
	 * @param string $key 缓存名称
	 * @param int $expires 缓存超时期限
	 * @return mixed
	 */
	public static function get($key, $expires = NULL) {
		if(empty(self::$cache[$key])) {
			$val = parent::get($key, $expires);
			self::$cache[$key] = $val;
		}
		return self::$cache[$key];
	}
	
	/**
	 * 删除一个缓存
	 * @param string $key 缓存名
	 * @return bool
	 */
	public static function delete($key) {
		self::$cache[$key] = NULL;
		return parent::delete($key);
	}

	/**
	 * 删除全部缓存文件
	 * @return bool
	 */
	public static function clear() {
		self::$cache = NULL;
		return parent::clear();
	}
	
	//------------------------------------------------------
	//  我是华丽的分割线    以下部分是页面缓存
	//------------------------------------------------------

	/**
	 * 写入页面缓存文件
	 * @param string $cache_path
	 */
	public static function set_page($cache_path) {
		$page_content = ob_get_contents();
		$cache_path = BASEPATH.CACHE_PATH.'page/'.$cache_path.'.cache';
		if(!is_dir(dirname($cache_path))) {
			create_dir(dirname($cache_path));
		}
		if(is_file($cache_path)) {
			@unlink($cache_path);
		}
		file_put_contents($cache_path, $page_content);
	}

	/**
	 * 读取页面缓存并输出
	 * @param string $cache_path
	 * @param int $expires
	 * @return mixed
	 */
	public static function get_page($cache_path, $expires = NULL) {
		$cache_path = BASEPATH.CACHE_PATH.'page/'.$cache_path.'.cache';
		if(!is_file($cache_path)) {
			return FALSE;
		}else{
			if($expires == NULL) {
				$expires = CACHE_PAGE_EXPIRES;
			}
			$file_create_time = filectime($cache_path);
			if($expires > 0 && time() - $file_create_time > $expires) {
				return FALSE;
			}
			ob_clean();
			readfile($cache_path);
			exit();
		}
	}

	/**
	 * 删除一个路径下的所有页面缓存
	 * @param string $cache_path
	 */
	public static function delete_page($cache_path = NULL) {
		$cache_path = BASEPATH.CACHE_PATH.'page/'.$cache_path;
		if(is_dir($cache_path)) {
			rm_file($cache_path);
		}else{
			rm_file($cache_path.'.cache');
		}
	}
}
/* End of this file */