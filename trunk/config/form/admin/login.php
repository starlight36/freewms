<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
| -------------------------------------------------------------------
| 表单验证规则定义文件
| -------------------------------------------------------------------
 */
$form_rule = array(
	array(
		'field' => 'admin',
		'label' => '管理员名',
		'rules' => 'required',
		'filter' => 'trim'
	),
	array(
		'field' => 'passwd',
		'label' => '管理员密码',
		'rules' => 'required|matches[admin]',
		'filter' => 'md5'
	)
);
/* End of the file */