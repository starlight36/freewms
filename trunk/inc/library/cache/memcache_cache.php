<?php
/*
 * memcache缓存类
*/
class memcache_cache {

	private $obj_mem;

	public function  __construct() {
		$this->obj_mem = new Memcache();
		$this->obj_mem->connect(MEMCACHE_HOST, MEMCACHE_PORT);
	}
	public function  __destruct() {
		$this->obj_mem->close();
	}

	/**
	 * 设置缓存
	 * @param string $key 缓存名
	 * @param unknown $value 缓存内容
	 * @return bool
	 */
	public function put($key, $value) {
		$this->obj_mem->set($key, serialize($value), 0, CACHE_EXPIRE);
		return TRUE;
	}

	/**
	 * 读取缓存
	 * @param string $key 缓存名
	 * @return unknown
	 */
	public function get($key) {
		return unserialize($this->obj_mem->get($key));
	}

	/**
	 * 删除一个缓存
	 * @param string $key 缓存名
	 * @return bool
	 */
	public function rm($key) {
		$this->obj_mem->delete($key);
		return TRUE;
	}

	/**
	 * 删除全部缓存
	 * @return bool
	 */
	public function rm_all() {
		$this->obj_mem->flush();
		return TRUE;
	}
}