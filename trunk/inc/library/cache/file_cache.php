<?php
/*
 * 文件缓存类
 */

class file_cache {

	/**
	 * 设置缓存
	 * @param string $key 缓存名
	 * @param unknown $value 缓存内容
	 * @return bool
	 */
	public function put($key, $value) {
		$key = md5(SAFETY_STRING.$key);
		$path = CACHE_PATH.'data/'.substr($key,0,2)."/".substr($key,2,2).'/';
		if(!is_dir($path)) {
			create_dir($path);
		}
		$cache_file = $path.$key.'.dat';
		$value = serialize($value);
		file_put_contents($cache_file, $value);
		return TRUE;
	}

	/**
	 * 读取缓存
	 * @param string $key 缓存名
	 * @return unknown
	 */
	public function get($key) {
		$key = md5(SAFETY_STRING.$key);
		$path = CACHE_PATH.'data/'.substr($key,0,2)."/".substr($key,2,2).'/';
		$cache_file = $path.$key.'.dat';
		if(!is_file($cache_file)) {
			return FALSE;
		}else{
			$file_create_time = filectime($cache_file);
			if(CACHE_EXPIRE > 0 && gmmktime() - $file_create_time > CACHE_EXPIRE) {
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
	public function rm($key) {
		$key = md5(SAFETY_STRING.$key);
		$path = CACHE_PATH.'data/'.substr($key,0,2)."/".substr($key,2,2).'/';
		$cache_file = $path.$key.'.dat';
		@unlink($cache_file);
		return TRUE;
	}

	/**
	 * 删除全部缓存文件
	 * @return bool
	 */
	public function rm_all() {
		$path = CACHE_PATH.'data/';
		rm_file($path);
		if(!is_dir($path)) {
			create_dir($path);
		}
		return TRUE;
	}
}

/* End of the file */