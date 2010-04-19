<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
| -------------------------------------------------------------------
| 表单验证规则定义文件
| -------------------------------------------------------------------
 */
$form_rule = array(
	array(
		'field' => 'admin',
		'label' => '用户名',
		'rules' => 'required',
		'filter' => 'trim'
	),
	array(
		'field' => 'passwd',
		'label' => '用户密码',
		'rules' => 'required',
		'filter' => 'trim|md5'
	),
	array(
		'field' => 'adminpass',
		'label' => '管理密码',
		'rules' => 'required',
		'filter' => 'trim|md5'
	)
);
/* End of the file */