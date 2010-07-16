<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 发表评论模块
 */

$form = new Form($_POST);
$form->set_field('comment_contentid', NULL, 'integer');
$form->set_field('comment_username', '用户名', 'user_name|max_length[16]', 'trim|htmlspecialchars|nl2br');
$form->set_field('comment_content', '评论内容', 'required|max_length[5000]', 'trim|htmlspecialchars|nl2br');

if($form->run()) {
	$comment = new Comment();
	if($comment->set_comment($_POST)) {
		View::show_message('success', '发表评论成功!');
	}else{
		View::show_message('error', '发表评论出错: '.$comment->msg);
	}
}else{
	$errmsg = Form::get_all_errors('<br />');
	if($errmsg) {
		View::show_message('error', '发表评论出错: <br />'.Form::get_all_errors('<br />'));
	}else{
		show_404();
	}
}
/* End of this file */