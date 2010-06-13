<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 自定义字段管理页面
 */

//载入公共文件
require_once MOD_PATH.'common.php';

//载入语言文件
Lang::load('admin/field');

//载入数据库对象
$db = DB::get_instance();

//读取对应的模型ID并验证
$modid = $_GET['modid'];
if(!preg_match('/^[0-9]+$/', $modid)) {
	show_message('error', Lang::_('admin_show_message_error_0'));
}
$db->select('*')->from('module')->sql_add('WHERE `mod_id` = ?', $modid);
$mod = $db->get();
if($mod == NULL) {
	show_message('error', Lang::_('admin_show_message_error_1'));
}
unset($mod);

//--------------------------------------------
//	保存字段修改(增/改)
//--------------------------------------------
if($_GET['do'] == 'edit') {
	$id = $_GET['id'];
	if(!preg_match('/^[0-9]+$/', $id)) {
		$id = 0;
	}
	if($id != 0) {
		$db->select('*')->from('field')->sql_add('WHERE `field_id` = ?', $id);
		$field = $db->get();
		if($field == NULL) {
			show_message('error', Lang::_('admin_show_message_error_2'));
		}
		$field = $field[0];
	}
	$form = new Form($_POST);
	$form->set_field('field_name', ''.Lang::_('admin_field_name_tip').'', 'required|max_lenght[50]', 'trim');
	$form->set_field('field_key', ''.Lang::_('admin_field_key_tip').'', 'required|dir_name|max_lenght[50]', 'trim');
	$form->set_field('field_desc', ''.Lang::_('admin_field_desc_tip').'', 'max_lenght[220]', 'trim');
	$form->set_field('field_input', ''.Lang::_('admin_field_input_tip').'', 'required', 'trim');
	$form->set_field('field_default', ''.Lang::_('admin_field_default_tip').'');
	$form->set_field('field_rules', ''.Lang::_('admin_field_rules_tip').'', NULL, 'trim');
	$form->set_field('field_filters', ''.Lang::_('admin_field_filters_tip').'', NULL, 'trim');
	if($form->run()) {
		$db->sql_add('WHERE `field_id` = ?', $id);
		$db->set($_POST);
		if($id == 0) {
			$_POST['field_modid'] = $modid;
			$db->insert('field');
		}else{
			$db->update('field');
		}
		show_message('success', Lang::_('admin_field_success_tip'), array(Lang::_('admin_return_field_tip') =>
								'index.php?m=admin&a=field&modid='.$modid));
	}else{
		include MOD_PATH.'templates/field.edit.tpl.php';
	}
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	删除字段(删)
//--------------------------------------------
if($_GET['do'] == 'rm') {
	$id = $_GET['id'];
	if(!preg_match('/^[0-9]+$/', $id)) {
		show_message('error', Lang::_('admin_show_message_error_0'));
	}
	$db->select('*')->from('field')->sql_add('WHERE `field_id` = ?', $id);
	$field = $db->get();
	if($field == NULL) {
		show_message('error', Lang::_('admin_show_message_error_3'));
	}
	$db->sql_add('WHERE `field_id` = ?', $id);
	$db->delete('field');
	show_message();
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	列表显示字段(查)
//--------------------------------------------
$db->select('*')->from('field')->sql_add('WHERE `field_modid` = ?', $modid);
$flist = $db->get();
include MOD_PATH.'templates/field.list.tpl.php';
//--------------------------------------------

/* End of this file */