<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
| -------------------------------------------------------------------
| 表单验证规则定义文件
| -------------------------------------------------------------------
 */
$form_rule = array(
	//注册表单验证
	'admin/login' => array(
		array(
			'field' => 'admin',
			'label' => '管理员用户名',
			'rules' => 'required'
		)
	)
);

/* End of the file */