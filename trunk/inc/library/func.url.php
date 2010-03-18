<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
 * URL函数库
 */

/**
 * 取得站点根路径
 * @return string
 */
function base_url() {
	$obj =& load_class('url');
	return $obj->base_url();
}

/**
 * 从URI获取URL
 * @param string $str
 * @return string
 */
function site_url($str = NULL) {
	$obj =& load_class('url');
	return $obj->site_url($str);
}