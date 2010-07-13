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
	$form->set_field('page_name','页面名', 'required|max_length[50]', 'trim');
	$form->set_field('page_keyword','页面关键字', 'required|max_length[50]', 'trim');
	$form->set_field('page_desc','页面描述','required|max_length[255]', 'trim');
	$form->set_field('page_key','页面URL名称','required|max_length[50]|dir_name|_check_page_key['.$id.']', 'trim');
	$form->set_field('page_template','页面模板','required|max_length[255]', 'trim');
	$form->set_field('page_static', '是否生成静态');
	if($form->run()){
		$db->set($_POST);
		if($id == 0) {
			$db->insert('page');
		}else{
			$db->sql_add('WHERE `page_id` = ?', $id);
			$db->update('page');
		}
		show_message('success', '添加导航成功', array('返回导航列表' =>
											'index.php?m=admin&a=page'));
	}else{
		if($id > 0) {
			$db->select('*')->from('page')->sql_add('WHERE `page_id` = ?', $id);
			$pinfo = $db->get();
			if($pinfo == NULL) {
				show_message('error', '要编辑的页面不存在');
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
		return '这个惟一标识符已被使用.';
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