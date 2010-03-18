<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
 * 设置函数库
 */

/**
 * 读取一个设置参数
 * @param string $name 设置文件名称
 * @param string $path 设置路径,无需指明文件
 * @return unknown
 */
function get_config($name, $path) {
	$obj_config =& load_class('config');
	$obj_config->load($name);
	return $obj_config->get($name.'/'.$path);
}
/* End of the file */