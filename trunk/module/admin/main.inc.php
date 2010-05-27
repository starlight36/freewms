<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 后台欢迎页
 */

//载入公共文件
require_once MOD_PATH.'common.php';

//载入语言文件
Lang::load('admin/main');

//保存后台便签
if(Form::is_post()) {
	$note = $_POST['admin_note'];
	$notefile = MOD_PATH.substr(md5(SAFETY_STRING.'adminnote'), 0, 12).'.txt';
	file_put_contents($notefile, $note);
}

//各项统计
$db = DB::get_instance();

//内容待审数量
$db->select('count(*)')->from('content')->sql_add('WHERE `content_state` = 1');
$content_verify_count = $db->result($db->query(), 0);

//评论待审数量
$db->select('count(*)')->from('comment')->sql_add('WHERE `comment_state` = 1');
$comment_verify_count = $db->result($db->query(), 0);

//草稿内容数量
$db->select('count(*)')->from('content')->sql_add('WHERE `content_state` = 3');
$content_draft_count = $db->result($db->query(), 0);

//留言待审数量
$db->select('count(*)')->from('guestbook')->sql_add('WHERE `gb_state` = 1');
$gb_verify_count = $db->result($db->query(), 0);

//留言待回复数量
$db->select('count(*)')->from('guestbook')->sql_add('WHERE `gb_replystate` = 0');
$gb_reply_count = $db->result($db->query(), 0);

//注册用户待审数量
if(Config::get('user_adminvalid') == '1') {
	$db->select('count(*)')->from('user')->sql_add('WHERE `user_adminvalid` = 0');
	$user_verify_count = $db->result($db->query(), 0);
}else{
	$user_verify_count = 0;
}

//加载欢迎页
include MOD_PATH.'templates/main.tpl.php';
/* End of this file */