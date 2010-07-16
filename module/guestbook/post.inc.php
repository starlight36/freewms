<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 保存留言模块
 */
$form = new Form($_POST);
$form->set_field('gb_username', '用户名', 'user_name|max_length[16]', 'trim|htmlspecialchars|nl2br');
$form->set_field('gb_content', '留言内容', 'required|max_length[5000]', 'trim|htmlspecialchars|nl2br');

if($form->run()) {
	$gb = new Guestbook();
	if($gb->set_guestbook($_POST)) {
		View::show_message('success', '发表留言成功!');
	}else{
		View::show_message('error', '发表留言出错: '.$comment->msg);
	}
}else{
	$errmsg = Form::get_all_errors('<br />');
	if($errmsg) {
		View::show_message('error', '发表留言出错: <br />'.Form::get_all_errors('<br />'));
	}else{
		show_404();
	}
}

/* End of this file */