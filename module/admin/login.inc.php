<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 后台登录页
 */

//加载语言文件
Lang::load('admin/login');

//处理登录动作
$form = new Form($_POST);
if($form->is_post()) {
	$form->set_field('admin', Lang::_('admin_login_user_name_tip'), 'required', 'trim');
	$form->set_field('pass', Lang::_('admin_login_user_pass_tip'), 'required', 'trim|md5');
	$form->set_field('validcode', Lang::_('admin_login_valid_code_tip'), 'required|valid_code', 'trim');
	if($form->run()) {
		$user = User::get_instance();
		if($user->login($_POST['admin'], $_POST['pass'], TRUE)) {
			redirect('index.php?m=admin');
		}else{
			View::show_message('error', $user->msg, NULL, 3);
		}
	}else{
		View::show_message('error', $form->get_all_errors('string'), NULL, 3);
	}
}else{
	include MOD_PATH.'templates/login.tpl.php';
}
/* End of this file */