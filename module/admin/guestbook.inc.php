<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/
/**
 * 留言列表页模版
 */
//载入公共文件
require_once MOD_PATH.'common.php';
//载入语言文件
Lang::load('admin/guestbook');
//从数据库读取
$db = DB::get_instance();

//--------------------------------------------
//	保存留言回复修改(增/改)
//--------------------------------------------
if($_REQUEST['do'] == 'edit') {
	$id = $_GET['id'];
	if(!preg_match('/^[0-9]+$/', $id)) {
		$id = 0;
	}else {
		$gb = new Guestbook();
		$in = $gb->get_guestbook($id);
	}
	$form = new Form($_POST);
	$form->set_field('gb_reply','','max_length[50]', 'trim');
	if($form->run()) {
		$in['gb_reply'] = $_POST['gb_reply'];
        $gb = new Guestbook();
		$gbinfo = $gb->set_guestbook($in);
		show_message('success',Lang::_('admin_gb_success_tip'), array(Lang::_('admin_gb_return_tip') => 'index.php?m=admin&amp;a=guestbook'));
	}else {
		if($id > 0) {
			$gb = new Guestbook();
			$gbinfo = $gb->get_guestbook($id);
		}
		include MOD_PATH.'templates/guestbook.edit.tpl.php';
	}
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	批量设置属性/删除(改/删)
//--------------------------------------------
if(in_array($_REQUEST['do'], array('normal', 'lock', 'recycle', 'rm'))) {
	$id = $_REQUEST['id'];
	if(empty($id)) {
		show_message('error',Lang::_('admin_gb_error_tip'));
	}
	if(!is_array($id)) $id=array($id);
	$gblist = $id;

	$i = 0;
	$guestbook = new Guestbook();
	foreach($gblist as $id) {
		$gbinfo = $guestbook->get_guestbook($id);
		if(!$gbinfo){
			continue;
		}
		$db->sql_add('WHERE `gb_id` = ?', $id);
		switch($_REQUEST['do']) {
			case 'rm':
				$db->delete('guestbook');
				break;
			case 'normal':
				$db->set('gb_state', 0);
				$db->update('guestbook');
				break;
			case 'lock':
				$db->set('gb_state', 2);
				$db->update('guestbook');
				break;
			default:
				break;
		}
		$i++;
	}
	Cache::clear();
	Cache::delete_page();
	show_message('success', Lang::_('admin_gb_success_0_tip'));
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	显示导航
//--------------------------------------------
$state = $_REQUEST['state'];
if(preg_match('/^[012]$/', $state)) {
	$args['state'] = $state;
}
//处理翻页URL
$url = 'index.php?'.$_SERVER["QUERY_STRING"];
if(strpos('page=', $url) === FALSE) {
	$url .= empty($url) ? 'page={page}':'&page={page}';
}else{
	$url = preg_replace('/page=(\d+)/i', 'page={page}', $url);
}
//查询记录
$pagesize =  20; //每页显示数
$pagenum = $_REQUEST['page'] ? $_REQUEST['page'] : 1; //页码
$record_count = 0; //总记录数
$pagecount = 0; //总分页数
$guestbook = new Guestbook();
$gblist = $guestbook->get_guestbook_list($args, $pagesize, $pagenum, $record_count, $pagecount);
Paginate::set_paginate($url, $pagenum, $pagecount, $pagesize);
include MOD_PATH.'templates/guestbook.list.tpl.php';
//--------------------------------------------
/* End of this file */
