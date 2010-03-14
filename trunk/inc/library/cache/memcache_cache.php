<?php
/*
 * memcache缓存类
 */
class memcache_cache {

	private $mem = 0;
        public $val = 0;


        function  __construct() {
                $mem = new Memcache;
        }
        function  __destruct() {
                $mem->close();
        }

        /**
	 * 设置缓存
	 * @param string $key 缓存名
	 * @param unknown $value 缓存内容
	 * @return bool
	 */
	public function put($key, $value) {
                $mem->connect(MEMCACHE_HOST,MEMCACHE_PORT);
                $mem->set($key,$value,0,CACHE_EXPIRE);
		return TRUE;
	}

	/**
	 * 读取缓存
	 * @param string $key 缓存名
	 * @return unknown
	 */
	public function get($key) {
            $val = $mem->get($key);

	}

	/**
	 * 删除一个缓存
	 * @param string $key 缓存名
	 * @return bool
	 */
	public function rm($key) {
                $mem->delete($key);

		return TRUE;
	}

	/**
	 * 删除全部缓存
	 * @return bool
	 */
	public function rm_all() {
                $mem->flush();
		return TRUE;
	}
}