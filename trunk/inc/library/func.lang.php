<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
 * 多语言支持函数库
 */

/**
 * 加载一个语言文件
 * @param string $str 语言文件
 * @return bool
 */
function load_lang($str) {
	$obj =& load_class('lang');
	return $obj->load($str);
}

/**
 * 读取一个语言项
 * @param string $str 语言项PATH形式
 * @return string
 */
function lang($str) {
	$obj =& load_class('lang');
	return $obj->get($str);
}
/* End of the file */
