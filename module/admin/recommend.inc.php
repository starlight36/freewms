<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 推荐位管理页
 */

//载入公共文件
require_once MOD_PATH.'common.php';

//载入语言文件
Lang::load('admin/recommend');

//载入数据库对象
$db = DB::get_instance();

//--------------------------------------------
//	保存推荐位修改(增/改)
//--------------------------------------------
if($_REQUEST['do'] == 'edit') {
	$id = $_GET['id'];
	if(!preg_match('/^[0-9]+$/', $id)) {
		$id = 0;
	}
	$form = new Form($_POST);
	$form->set_field('rec_name', Lang::_('admin_rec_name_tip'), 'required|max_length[50]', 'trim');
	$form->set_field('rec_desc', Lang::_('admin_rec_desc_tip'), 'max_length[255]', 'trim');
	$form->set_field('rec_key', Lang::_('admin_recommend_key_only_tip'), 'max_length[50]', 'trim');
	$form->set_field('rec_roles', Lang::_('admin_rec_rec_roles_tip'));
	if($form->run()) {
		$_POST['rec_roles'] = serialize($_POST['rec_roles']);
		$db->set($_POST);
		if($id == 0) {
			$db->insert('recommend');
		}else{
			$db->sql_add('WHERE `rec_id` = ?', $id);
			$db->update('recommend');
		}
		show_message('success',  Lang::_('admin_subject_success_tip'), array( Lang::_('admin_subject_return_tip') =>
											'index.php?m=admin&a=recommend'));
	}else{
		//读取记录填充表单
		if($id > 0) {
			$db->select('*')->from('recommend')->sql_add('WHERE `rec_id` = ?', $id);
			$rinfo = $db->get();
			if($rinfo == NULL) {
				show_message('error',  Lang::_('admin_admin_subject_error_tip'));
			}
			$rinfo = $rinfo[0];
			$rinfo['rec_roles'] = unserialize($rinfo['rec_roles']);
		}
		//创建管理角色用户组列表
		$db->select('group_id, group_name')->from('group')->sql_add('WHERE `group_isadmin` = 1');
		$role_select_list = $db->get();
		include MOD_PATH.'templates/recommend.edit.tpl.php';
	}
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	保存推荐位删除(删)
//--------------------------------------------
if($_REQUEST['do'] == 'del') {
	$id = $_GET['id'];
	if(!preg_match('/^[0-9]+$/', $id)) {
		$id = 0;
	}
	$db->sql_add('WHERE `rc_recid` = ?', $id);
	$db->delete('recommend_content');
	$db->sql_add('WHERE `rec_id` = ?', $id);
	$db->delete('recommend');
	Cache::clear();
	Cache::delete_page();
	show_message();
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	显示推荐位列表
//--------------------------------------------
$pagesize = 20; //每页显示数目
$pagenum = $_REQUEST['page'];  //取页码
if(!preg_match('/^[0-9]+$/i', $pagenum)) {
	$pagenum = 1;
}
//读取结果集总数
$db->select('COUNT(*)')->from('recommend');
$record_count = $db->result($db->query());
//计算分页数
$pagecount = ceil($record_count / $pagesize);
if($pagenum > $pagecount) $pagenum = $pagecount;
//设置游标
$offset = $pagenum > 0 ? ($pagenum - 1) * $pagesize : 0;
//查询记录
$db->select('*')->from('recommend')->sql_add("LIMIT $offset, $pagesize");
$rlist = $db->get();
//生成翻页导航
$url = 'index.php?'.$_SERVER["QUERY_STRING"];
if(strpos('page=', $url) === FALSE) {
	$url .= empty($url) ? 'page={page}':'&page={page}';
}else{
	$url = preg_replace('/page=(\d+)/i', 'page={page}', $url);
}
Paginate::set_paginate($url, $pagenum, $pagecount, $pagesize);
include MOD_PATH.'templates/recommend.list.tpl.php';
//--------------------------------------------
/* End of this file */