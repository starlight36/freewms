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

/**
 * 重定向到一个URL
 * @param string $uri
 * @param string $method
 * @param int $http_response_code
 */
function redirect($uri = '', $method = 'location', $http_response_code = 302) {
	if ( ! preg_match('#^https?://#i', $uri)) {
		$uri = site_url($uri);
	}
	switch($method) {
		case 'refresh': header("Refresh:0;url=".$uri);
			break;
		default : header("Location: ".$uri, TRUE, $http_response_code);
			break;
	}
	exit;
}
/* End of the file */