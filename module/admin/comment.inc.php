<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/
/**
 * 内容列表页模版
 */

//载入公共文件
require_once MOD_PATH.'common.php';

//从数据库读取
$db = DB::get_instance();

//--------------------------------------------
//	批量设置属性/删除(改/删)
//--------------------------------------------
if(in_array($_REQUEST['do'], array('normal', 'lock', 'recycle', 'rm'))) {
	$id = $_REQUEST['id'];
	if(empty($id)) {
		show_message('error',Lang::_('admin_admin_show_message_error_3_tip'));
	}
	if(!is_array($id)) $id=array($id);
	$clist = $id;

	$i = 0;
	$comment = new Comment();
	foreach($clist as $id) {
		$cinfo = $comment->get_comment($id);
		if(!$cinfo){
			continue;
		}
		$db->sql_add('WHERE `comment_id` = ?', $id);
		switch($_REQUEST['do']) {
			case 'rm':
				$db->delete('comment');
				break;
			case 'normal':
				$db->set('comment_state', 0);
				$db->update('comment');
				break;
			case 'lock':
				$db->set('comment_state', 2);
				$db->update('comment');
				break;
			default:
				break;
		}
		$i++;
	}
	Cache::clear();
	Cache::delete_page();
	show_message('success', '操作成功!');
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	显示导航
//--------------------------------------------
$state = $_REQUEST['state'];
$uid = $_REQUEST['uid'];
$cid = $_REQUEST['cid'];

if(preg_match('/^[012]$/', $state)) {
	$args['state'] = $state;
}

if(preg_match('/^\d+?$/', $uid)) {
	$args['userid'] = $uid;
}

if(preg_match('/^\d+?$/', $cid)) {
	$args['contentid'] = $cid;
}

$args['order'] = array('comment_time DESC');

//处理翻页URL
$url = 'index.php?'.$_SERVER["QUERY_STRING"];
if(strpos('page=', $url) === FALSE) {
	$url .= '&page={page}';
}else{
	$url = preg_replace('/page=(\d+)/i', 'page={page}', $url);
}
//查询记录
$pagesize =  20; //每页显示数
$pagenum = $_REQUEST['page'] ? $_REQUEST['page'] : 1; //页码
$record_count = 0; //总记录数
$pagecount = 0; //总分页数
$comment = new Comment();
$comlist = $comment->get_comment_list($args, $pagesize, $pagenum, $record_count, $pagecount);

Paginate::set_paginate($url, $pagenum, $pagecount, $pagesize);

include MOD_PATH.'templates/comment.list.tpl.php';
//--------------------------------------------
/* End of this file */