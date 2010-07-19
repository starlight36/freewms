<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * URL方案管理
 */

//载入公共文件
require_once MOD_PATH.'common.php';

//载入语言文件
Lang::load('admin/url');

//--------------------------------------------
//	保存方案文件
//--------------------------------------------
if($_REQUEST['do'] == 'save') {
	$url_content = $_POST['url'];
	$route_content = $_POST['route'];
	if(empty($url_content) || empty($route_content)) {
		exit();
	}
	file_put_contents(BASEPATH.'config/url.php', $url_content);
	file_put_contents(BASEPATH.'config/route.php', $route_content);
	show_message();
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	显示当前方案
//--------------------------------------------
$url_content = file_get_contents(BASEPATH.'config/url.php');
$route_content = file_get_contents(BASEPATH.'config/route.php');
include MOD_PATH.'templates/url.tpl.php';
//--------------------------------------------

/* End of this file */