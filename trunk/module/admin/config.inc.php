<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 系统设置管理页
 */

//载入公共文件
require_once MOD_PATH.'common.php';

//载入语言文件
Lang::load('admin/config');

//--------------------------------------------
//	用于取得主题下拉选择列表
//--------------------------------------------
$theme_list = array();
$dir_handle = opendir(BASEPATH.'theme');
while(false !== ($file = readdir($dir_handle))) {
	if (preg_match('/^[0-9a-z_-]+$/i', $file) && is_dir(BASEPATH.'theme/'.$file)) {
		$theme_list[] = $file;
	}
}
//--------------------------------------------

//--------------------------------------------
//	用于取得用户组下拉选择列表
//--------------------------------------------
$group_list = array();
$db = DB::get_instance();
$db->select('group_name')->select('group_id')->from('group');
$group_list = $db->get();
//--------------------------------------------

$form = new Form($_POST['config']);

//设置验证规则, 未完成
$form->set_field('site_name', '站点名称', 'required', 'trim');
$form->set_field('site_desc', '站点简介', NULL, 'trim');


if ($form->run()) {
	$config_file = BASEPATH.'config/site.php';
	$config_content = file_get_contents($config_file);
	foreach($_POST['config'] as $key => $value) {
		$value = str_replace("\n", "\\n", $value);
		$value = str_replace('\'', '\\\'', $value);
		$config_content = preg_replace('/\$config\[\''.$key.'\'\] = \'(.*)\';/i', '$config[\''.$key.'\'] = \''.$value.'\';', $config_content);
	}
	file_put_contents($config_file, $config_content);
	echo '保存成功!';
}else{
	include MOD_PATH.'templates/config.tpl.php';
}
/* End of this file */