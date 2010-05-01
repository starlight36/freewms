<?php
/*
 * 缓存函数库
 */

/**
 * 将内容存入缓存
 * @param string $key 缓存名
 * @param unknown $value 缓存内容
 * @return bool
 */
function cache_put($key, $value) {
	$obj_cache = &load_class('library/cache/'.CACHE_TYPE.'_cache');
	return $obj_cache->put($key, $value);
}

/**
 * 从缓存读取
 * @param string $key 缓存名
 * @return unknown
 */
function cache_get($key) {
	$obj_cache = &load_class('library/cache/'.CACHE_TYPE.'_cache');
	return $obj_cache->get($key);
}

/**
 * 删除一个缓存
 * @param string $key 缓存名
 * @return bool
 */
function cache_rm($key) {
	$obj_cache = &load_class('library/cache/'.CACHE_TYPE.'_cache');
	return $obj_cache->rm($key);
}

/**
 * 删除全部缓存
 * @return bool
 */
function cache_clear() {
	$obj_cache = &load_class('library/cache/'.CACHE_TYPE.'_cache');
	return $obj_cache->rm_all();
}

/**
 * 页面内容缓存初始化
 */
function cache_page_init() {
	ob_start();
}

/**
 * 保存页面缓存
 */
function cache_page_save() {
	if(!get_config('site', 'page_cache')) {
		return;
	}
	$obj_in =& load_class('in');
	$page_key = md5(SAFETY_STRING.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	$path = CACHE_PATH.'page/'.$obj_in->controller().'/'.$obj_in->action().'/'.substr($page_key,0,2);
	$cache_file = $path.'/'.$page_key.'.dat';
	if(!is_dir($path)) {
		create_dir($path);
	}
	$page_content = ob_get_contents();
	@unlink($cache_file);
	file_put_contents($cache_file, $page_content);
}

/**
 * 加载页面缓存
 * 成功直接应答并结束响应,否则返回FALSE
 * @return bool/null
 */
function cache_page_load() {
	if(!get_config('site', 'page_cache')) {
		return;
	}
	$obj_in =& load_class('in');
	$page_key = md5(SAFETY_STRING.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	$path = CACHE_PATH.'page/'.$obj_in->controller().'/'.$obj_in->action().'/'.substr($page_key,0,2);
	$cache_file = $path.'/'.$page_key.'.dat';
	if(!is_file($cache_file)) {
			return FALSE;
	}else{
		$file_pass_time = gmmktime() - filectime($cache_file);
		if(CACHE_PAGE_EXPIRE > 0 && $file_pass_time > CACHE_PAGE_EXPIRE) {
			return FALSE;
		}else{
			ob_clean();
			exit(file_get_contents($cache_file));
		}
	}
}

function cache_page_clear_all() {
	$path = CACHE_PATH.'page/';
	rm_file($path);
	if(!is_dir($path)) {
		create_dir($path);
	}
	return TRUE;
}

function cache_page_clear() {
	$path = CACHE_PATH.'page/'.$obj_in->controller().'/'.$obj_in->action().'/';
	rm_file($path);
	return TRUE;
}
/* End of the file */