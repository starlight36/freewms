<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
 * 内容接口
 * 提供内容模块展示
 */

function interface_clist($param) {
	if(!is_array($param)) {
		return FALSE;
	}
	$content_obj =& load_class('content');
	$c_rst = $content_obj->get_list($param);
	cache_put($clist_id, $c_rst);
	return $c_rst;
}