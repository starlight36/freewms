<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

//载入公共文件
require_once MOD_PATH.'common.php';
//载入语言文件
Lang::load('admin/page');
//载入数据库对象
$db = DB::get_instance();

//--------------------------------------------
//	保存自定义页修改(增/改)
//--------------------------------------------
if($_REQUEST['do'] == 'edit') {
	$id = $_GET['id'];
	if(!preg_match('/^[0-9]+$/', $id)) {
		$id = 0;
	}
    //进行输入验证
	$form = new Form($_POST);
	$form->set_field('page_name',Lang::_('admin_page_name_tip'), 'required|max_length[50]', 'trim');
	$form->set_field('page_keyword',Lang::_('admin_page_keyword_tip'), 'required|max_length[50]', 'trim');
	$form->set_field('page_desc',Lang::_('admin_page_desc_tip'),'required|max_length[255]', 'trim');
	$form->set_field('page_key',Lang::_('admin_page_key_tip'),'required|max_length[50]|dir_name|_check_page_key['.$id.']', 'trim');
	$form->set_field('page_template',Lang::_('admin_page_template_tip'),'required|max_length[255]', 'trim');
	$form->set_field('page_static', Lang::_('admin_page_static_tip'));
	if($form->run()){
		$db->set($_POST);
		if($id == 0) {
			$db->insert('page');
		}else{
			$db->sql_add('WHERE `page_id` = ?', $id);
			$db->update('page');
		}
		show_message('success', Lang::_('admin_page_success_tip'), array(Lang::_('admin_page_return_tip') =>
											'index.php?m=admin&a=page'));
	}else{
		if($id > 0) {
			$db->select('*')->from('page')->sql_add('WHERE `page_id` = ?', $id);
			$pinfo = $db->get();
			if($pinfo == NULL) {
				show_message('error', Lang::_('admin_page_error_tip'));
			}
			$pinfo = $pinfo[0];
		}
		include MOD_PATH.'templates/page.edit.tpl.php';
	}
	exit();
}
function _check_page_key($name, $id) {
	global $db;
	if($id == 0){
	    $db->select('COUNT(*)')->from('page')->sql_add('WHERE `page_key`= ?', $name);
	}else {
		$db->select('COUNT(*)')->from('page')->sql_add('WHERE `page_key`= ? AND `page_id` != ?', $name, $id);
	}
	if($db->result($db->query()) == 0) {
		return FALSE;
	}else{
		return  Lang::_('admin_page_warn_tip');
	}
}
//--------------------------------------------

//--------------------------------------------
//	删除自定义页删)
//--------------------------------------------
if($_REQUEST['do'] == 'del') {
	$id = $_GET['id'];
	if(!preg_match('/^[0-9]+$/', $id)) {
		$id = 0;
	}
	$db->sql_add('WHERE `page_id` = ?', $id);
	$db->delete('page');
	Cache::clear();
	Cache::delete_page();
	show_message();
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	显示自定义页
//--------------------------------------------
$db->select('*')->from('page');
$plist = $db->get();
include MOD_PATH.'templates/page.list.tpl.php';
//--------------------------------------------
/* End of this file */