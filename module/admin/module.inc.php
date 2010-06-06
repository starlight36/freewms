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
			show_message('error', '没有找到要编辑的模型.');
		}
		$mod = $mod[0];
	}
	$form = new Form($_POST);
	$form->set_field('mod_name', '模型名称', 'required|max_lenght[50]', 'trim');
	$form->set_field('mod_desc', '模型简介', 'required|max_lenght[200]', 'trim');
	$form->set_field('mod_itemname', '内容条目名称', 'required|max_lenght[20]', 'trim');
	$form->set_field('mod_itemunit', '内容条目单位', 'required|max_lenght[20]', 'trim');
	$form->set_field('mod_template', '模型默认模板文件夹', 'required|max_lenght[200]', 'trim');
	if($form->run()) {
		$db->sql_add('WHERE `mod_id` = ?', $id);
		$db->set($_POST);
		if($id == 0) {
			$db->insert('module');
		}else{
			$db->update('module');
		}
		show_message('success', '保存模型成功', array('返回模型列表页' => 'index.php?m=admin&a=module'));
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
		show_message('error', '非法的参数格式.');
	}
	$db->select('*')->from('module')->sql_add('WHERE `mod_id` = ?', $id);
	$mod = $db->get();
	if($mod == NULL) {
		show_message('error', '没有找到要删除的模型.');
	}
	$mod = $mod[0];
	if($mod['mod_is_system']) {
		show_message('error', '您不能删除一个系统模型.');
	}
	$db->select('*')->from('category')->sql_add('WHERE `cate_modid` = ?', $id);
	$mod = $db->get();
	if($mod != NULL) {
		show_message('error', '当前模型正在被使用, 您不能删除. 如果您一定要删除此模型, 请先删除使用此模型的分类.');
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