<?php
/*
 * 安全相关函数
 */

/**
 * 检查一个字符串是否在另一个字符串中
 *
 * @param string $str 要检查的字符串
 * @param string $aim 检查目标字符串
 * @return bool $str中包含$aim,返回TRUE,否则返回FALSE
 */
function check_str_in($str, $aim) {
	$con = explode($aim, $str);
	if (count($con) > 1) {
		return TRUE;
	}else{
		return FALSE;
	}
}
/**
 * 检查安全名称
 *
 * @param string $str 要检查的名称
 * @return bool
 */
function check_safety_name($str) {
	if (strlen($str) < 1 || strlen($str) > 225) return FALSE;
	if (preg_match('/^\w+$/u', $str)) {
		return TRUE;
	}else{
		return FALSE;
	}
}

/* End of the file */