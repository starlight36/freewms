<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 用户组管理页
 */

//载入公共文件
require_once MOD_PATH.'common.php';

//载入语言文件
Lang::load('admin/usergroup');

//载入数据库对象
$db = DB::get_instance();

//--------------------------------------------
//	编辑用户组(增/改)
//--------------------------------------------
if($_REQUEST['do'] == 'edit') {
	$id = $_GET['id'];
	if(!preg_match('/^[0-9]+$/', $id)) {
		$id = 0;
	}
	if($id != 0) {
		$db->select('*')->from('group')->sql_add('WHERE	`group_id` = ?', $id);
		$ginfo = $db->get();
		if(!$ginfo) {
			show_message('error',Lang::_('admin_group_modify_no_found_tip'));
		}
		$ginfo = $ginfo[0];
	}
	$form = new Form($_POST);
	$form->set_field('group_name', Lang::_('admin_group_name_tip'), 'required|max_length[20]', 'trim');
	$form->set_field('group_isadmin', Lang::_('admin_group_isadmin_tip'), 'numeric', 'trim');
	if($form->run()) {
		if($id == 0) {
			$db->set($_POST);
			$db->insert('group');
		}else{
			$db->sql_add('WHERE `group_id` = ?', $id);
			$db->set($_POST);
			$db->update('group');
		}
		show_message('success', Lang::_('admin_group_success_tip'));
		Cache::clear();
	}else{
		include MOD_PATH.'templates/usergroup.edit.tpl.php';
	}
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	删除用户组
//--------------------------------------------
if($_REQUEST['do'] == 'rm') {
	$id = $_GET['id'];
	if(!preg_match('/^[0-9]+$/', $id)) {
		show_message('error', Lang::_('admin_group_error_tip'));
	}
	$db->select('*')->from('group')->sql_add('WHERE	`group_id` = ?', $id);
	$ginfo = $db->get();
	if(!$ginfo) {
		show_message('error', Lang::_('admin_group_error_0_tip'));
	}
	$ginfo = $ginfo[0];
	if($ginfo['group_issys'] == '1') {
		show_message('error', Lang::_('admin_group_error_1_tip'));
	}
	$db->select('COUNT(*)')->from('user')->sql_add('WHERE `user_groupid` = ?', $id);
	if($db->result($db->query()) > 0) {
		show_message('error', Lang::_('admin_group_error_2_tip'));
	}
	$db->sql_add('WHERE `group_id` = ?', $id);
	$db->delete('group');
	show_message('success', Lang::_('admin_group_success_0_tip'));
	Cache::clear();
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	列表用户组
//--------------------------------------------
$db->select('*')->from('group');
$list = $db->get();
include MOD_PATH.'templates/usergroup.list.tpl.php';
//--------------------------------------------
/* End of this file */