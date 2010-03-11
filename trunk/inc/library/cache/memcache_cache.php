<?php
/*
 * memcache缓存类
 */
class memcache_cache {
	/**
	 * 设置缓存
	 * @param string $key 缓存名
	 * @param unknown $value 缓存内容
	 * @return bool
	 */
	public function put($key, $value) {
		
		return TRUE;
	}

	/**
	 * 读取缓存
	 * @param string $key 缓存名
	 * @return unknown
	 */
	public function get($key) {

	}

	/**
	 * 删除一个缓存
	 * @param string $key 缓存名
	 * @return bool
	 */
	public function rm($key) {

		return TRUE;
	}

	/**
	 * 删除全部缓存
	 * @return bool
	 */
	public function rm_all() {

		return TRUE;
	}
}