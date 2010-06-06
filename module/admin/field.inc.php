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
	show_message('error', '非法的参数格式.');
}
$db->select('*')->from('module')->sql_add('WHERE `mod_id` = ?', $modid);
$mod = $db->get();
if($mod == NULL) {
	show_message('error', '指定的模型不存在.');
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
			show_message('error', '没有找到要编辑的字段.');
		}
		$field = $field[0];
	}
	$form = new Form($_POST);
	$form->set_field('field_name', '字段名', 'required|max_lenght[50]', 'trim');
	$form->set_field('field_key', '字段关键字', 'required|dir_name|max_lenght[50]', 'trim');
	$form->set_field('field_desc', '字段说明', 'max_lenght[220]', 'trim');
	$form->set_field('field_input', '字段输入框', 'required', 'trim');
	$form->set_field('field_default', '字段默认值');
	$form->set_field('field_rules', '字段规则', NULL, 'trim');
	$form->set_field('field_filters', '字段过滤器', NULL, 'trim');
	if($form->run()) {
		$_POST['field_modid'] = $modid;
		$db->sql_add('WHERE `field_id` = ?', $id);
		$db->set($_POST);
		if($id == 0) {
			$db->insert('field');
		}else{
			$db->update('field');
		}
		show_message('success', '保存字段设置成功', array('返回字段列表页' =>
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
		show_message('error', '非法的参数格式.');
	}
	$db->select('*')->from('field')->sql_add('WHERE `field_id` = ?', $id);
	$field = $db->get();
	if($field == NULL) {
		show_message('error', '没有找到要删除的字段.');
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