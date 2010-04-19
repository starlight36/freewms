<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
| -------------------------------------------------------------------
| 表单验证相关的语言配置
| -------------------------------------------------------------------
 */

$lang['form_rule'] = array(
	'required' => '%s必须填写.',
	'matches' => '%s和%s不匹配.',
	'min_length'=>'%s必须大于%s个字符.',
	'max_length'=>'%s必须小于%s个字符.',
	'max_num'=>'%s不能大于%s.',
	'min_num'=>'%s不能小于%s.',
	'exact_length'=>'%s必须为%s个字符.',
	'valid_email'=>'%s必须是一个合法的Email地址.',
	'valid_emails'=>'%s必须一个合法的Email地址组.',
	'valid_ip'=>'%s必须是一个有效的IP地址.',
	'dir_name'=>'%s中只能包含字母数字和下划线.',
	'numeric'=>'%s必须是一个合法的数字形式.',
	'integer'=>'%s必须是一个合法的整数形式.',
	'is_natural'=>'%s必须是一个合法的自然数形式.'

);