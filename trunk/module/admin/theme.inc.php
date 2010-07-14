<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 系统主题管理页
 */

//载入公共文件
require_once MOD_PATH.'common.php';

//载入语言文件
Lang::load('admin/theme');

//--------------------------------------------
//	设为当前主题方案
//--------------------------------------------
if($_REQUEST['do'] == 'use') {
	$path = $_GET['path'];
	if(!preg_match('/^\w+?$/i', $path)) {
		show_message('error', '参数错误.');
	}
	$config_file = BASEPATH.'config/site.php';
	$config_content = file_get_contents($config_file);
	$config_content = preg_replace('/\$config\[\'site_theme\'\] = \'(.*)\';/i', '$config[\'site_theme\'] = \''.$path.'\';', $config_content);
	file_put_contents($config_file, $config_content);
	show_message();
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	主题列表拉取
//--------------------------------------------
$theme_list = array();
$dir_handle = opendir(BASEPATH.'theme');
while(false !== ($file = readdir($dir_handle))) {
	if (preg_match('/^[0-9a-z_-]+$/i', $file) && is_dir(BASEPATH.'theme/'.$file)) {
		$config_file = BASEPATH.'theme/'.$file.'/theme.conf';
		if(!is_file($config_file)) continue;
		$config = file_get_contents($config_file);
		$theme_list[] = path_array(Spyc::YAMLLoadString($config), 'theme');
	}
}
include MOD_PATH.'templates/theme.list.tpl.php';
//--------------------------------------------
/* End of this file */