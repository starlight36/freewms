<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
 * 内容接口
 * 提供内容模块展示
 */

function interface_clist($param) {
	if(!is_array($param)) {
		return FALSE;
	}
	if(empty($param['where']['chid'])) {
		return FALSE;
	}
	$clist_id = md5(serialize($param));
	$c_rst = cache_get($clist_id);
	if($c_rst != FALSE) {
		return $c_rst;
	}
	$content_obj =& load_class('content');
	$content_obj->set_channel(NULL, $param['where']['chid']);
	$c_rst = $content_obj->get_list($param);
	cache_put($clist_id, $c_rst);
	return $c_rst;
}