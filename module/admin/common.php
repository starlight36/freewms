<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 后台公共包含文件
 */

//加载语言文件
Lang::load('admin/admin');

//判断后台界面进入权限
$user = User::get_instance();
if(!$user->check_admin()) {
	$golist = array(
		'前往登录页' => 'index.php?m=admin&a=login',
		'返回网站首页' => 'index.php'
	);
	View::show_message('error', Lang::_('admin_access_denied'), $golist, 3);
}


/* End of this file */