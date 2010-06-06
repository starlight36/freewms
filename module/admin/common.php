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
check_admin();

/**
 * 检查后台页面访问权限
 */
function check_admin() {
	$user = User::get_instance();
	if(!$user->check_admin()) {
		$golist = array(
			Lang::_('admin_goto_login') => 'index.php?m=admin&a=login',
			Lang::_('admin_goto_index')  => 'index.php'
		);
		View::show_message('error', Lang::_('admin_access_denied'), $golist, 3);
	}
}

/**
 * 直接输出消息页
 * @param string $type
 * @param string $msg
 * @param mixed $go_url
 * @param int $autogo
 */
function show_message($type = 'error', $msg = NULL, $go_url = NULL, $autogo = 3) {
	if(!is_array($go_url) || $go_url == NULL) {
		$go_url[Lang::_('admin_goto_pre_page')] = $_SERVER["HTTP_REFERER"];
	}
	$redirect = current($go_url);
	if($type == 'success' && $msg == NULL) {
		$msg = Lang::_('admin_sys_success_reslut');
	}
	include MOD_PATH.'templates/message.tpl.php';
	exit();
}

/* End of this file */