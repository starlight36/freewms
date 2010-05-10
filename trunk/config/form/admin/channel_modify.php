<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
| -------------------------------------------------------------------
| 表单验证规则定义文件
| 编辑频道
| -------------------------------------------------------------------
 */
$form_rule = array(
	array(
		'field' => 'name',
		'label' => '频道名称',
		'rules' => 'required|max_lenght[30]',
		'filter' => 'trim'
	),
	array(
		'field' => 'desc',
		'label' => '模型简介',
		'rules' => 'required|max_lenght[180]',
		'filter' => 'trim'
	),
	array(
		'field' => 'class',
		'label' => '模型类库',
		'rules' => 'required|dir_name|max_lenght[100]',
		'filter' => 'trim'
	),
	array(
		'field' => 'plugin',
		'label' => '模型插件',
		'rules' => 'required|dir_name|max_lenght[50]',
		'filter' => 'trim'
	),
	array(
		'field' => 'manage',
		'label' => '管理接口',
		'rules' => 'required|dir_name|max_lenght[120]',
		'filter' => 'trim'
	)
);
/* End of the file */