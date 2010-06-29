<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 系统模型管理页
 */

//载入公共文件
require_once MOD_PATH.'common.php';

//载入语言文件
Lang::load('admin/module');

//载入数据库对象
$db = DB::get_instance();

//--------------------------------------------
//	保存模型修改(增/改)
//--------------------------------------------
if($_GET['do'] == 'edit') {
	$id = $_GET['id'];
	if(!preg_match('/^[0-9]+$/', $id)) {
		$id = 0;
	}
	if($id != 0) {
		$db->select('*')->from('module')->sql_add('WHERE `mod_id` = ?', $id);
		$mod = $db->get();
		if($mod == NULL) {
			show_message('error', ''.Lang::_('admin_error_tip').'');
		}
		$mod = $mod[0];
	}
	$form = new Form($_POST);
	$form->set_field('mod_name', ''.Lang::_('admin_mod_name_tip').'', 'required|max_lenght[50]', 'trim');
	$form->set_field('mod_desc', ''.Lang::_('admin_mod_desc_tip').'', 'required|max_lenght[200]', 'trim');
	$form->set_field('mod_itemname', ''.Lang::_('admin_mod_itemname_tip').'', 'required|max_lenght[20]', 'trim');
	$form->set_field('mod_itemunit', ''.Lang::_('admin_mod_itemunit_tip').'', 'required|max_lenght[20]', 'trim');
	$form->set_field('mod_template', ''.Lang::_('admin_mod_template_tip').'', 'required|max_lenght[200]', 'trim');
	$form->set_field('mod_filter', ''.Lang::_('admin_mod_filter_tip').'', 'required|max_lenght[50]', 'trim');
	if($form->run()) {
		$db->sql_add('WHERE `mod_id` = ?', $id);
		$db->set($_POST);
		if($id == 0) {
			$db->insert('module');
		}else{
			$db->update('module');
		}
		show_message('success', ''.Lang::_('admin_mod_save_success_tip').'', array(''.Lang::_('admin_return_mod_tip').'' => 'index.php?m=admin&a=module'));
	}else{
		include MOD_PATH.'templates/module.edit.tpl.php';
	}
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	删除模型(删)
//--------------------------------------------
if($_GET['do'] == 'rm') {
	$id = $_GET['id'];
	if(!preg_match('/^[0-9]+$/', $id)) {
		show_message('error', ''.Lang::_('admin_show_message_error_0').'.');
	}
	$db->select('*')->from('module')->sql_add('WHERE `mod_id` = ?', $id);
	$mod = $db->get();
	if($mod == NULL) {
		show_message('error', ''.Lang::_('admin_show_message_error_1').'.');
	}
	$mod = $mod[0];
	if($mod['mod_is_system']) {
		show_message('error', ''.Lang::_('admin_show_message_error_2').'.');
	}
	$db->select('*')->from('category')->sql_add('WHERE `cate_modid` = ?', $id);
	$mod = $db->get();
	if($mod != NULL) {
		show_message('error', ''.Lang::_('admin_show_message_error_3').'');
	}
	$db->sql_add('WHERE `mod_id` = ?', $id);
	$db->delete('module');
	show_message();
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	列表显示模型(查)
//--------------------------------------------
$db->select('*')->from('module');
$mlist = $db->get();
include MOD_PATH.'templates/module.list.tpl.php';
//--------------------------------------------

/* End of this file */