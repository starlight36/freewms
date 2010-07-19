<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 权限表管理页
 */

//载入公共文件
require_once MOD_PATH.'common.php';

//载入语言文件
Lang::load('admin/usergroup');

//载入数据库对象
$db = DB::get_instance();

//--------------------------------------------
//	增加/编辑权限(增/改)
//--------------------------------------------
if($_REQUEST['do'] == 'edit') {
	$id = $_GET['id'];
	if(!preg_match('/^[0-9]+$/', $id)) {
		$id = 0;
	}
	$form = new Form($_POST);
	$form->set_field('acl_name', '权限名称', 'required|max_length[30]', 'trim');
	$form->set_field('acl_desc', '权限简介', 'max_length[200]', 'trim');
	$form->set_field('acl_key', '权限标识符', 'required|dir_name', 'trim');
	$form->set_field('acl_default', '权限设置默认值', NULL, 'trim');
	$form->set_field('acl_type', '权限类型', 'required|numeric', 'trim');
	if($form->run()) {
		if($id == 0) {
			$db->set($_POST);
			$db->insert('acl');
		}else{
			$db->set($_POST);
			$db->sql_add('WHERE `acl_id` = ?', $id);
			$db->update('acl');
		}
		show_message('success',  '保存权限成功!', array('返回权限列表' =>
											'index.php?m=admin&a=acl'));
	}else{
		if($id != 0) {
			$db->select('*')->from('acl')->sql_add('WHERE `acl_id` = ?', $id);
			$aclinfo = $db->get();
			if(!$aclinfo) {
				show_message('error',  '要编辑的权限条目不存在');
			}
			$aclinfo = $aclinfo[0];
		}
		include MOD_PATH.'templates/acl.edit.tpl.php';
	}
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	删除权限
//--------------------------------------------
if($_REQUEST['do'] == 'del') {
	$id = $_GET['id'];
	if(!preg_match('/^[0-9]+$/', $id)) {
		show_message('error', '非法参数');
	}
	$db->sql_add('WHERE `uacl_aclid` = ?', $id);
	$db->delete('user_acl');
	$db->sql_add('WHERE `gacl_aclid` = ?', $id);
	$db->delete('group_acl');
	$db->sql_add('WHERE `acl_id` = ?', $id);
	$db->delete('acl');
	show_message('success', '删除成功!', array('返回权限列表' =>
											'index.php?m=admin&a=acl'));
	Cache::clear();
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	修改用户权限
//--------------------------------------------
if($_REQUEST['do'] == 'auth_user') {
	$id = $_REQUEST['id'];
	if(!preg_match('/^[0-9]+$/', $id)) {
		show_message('error', '非法参数.');
	}
	$db->select('`user_name`')->from('user')->sql_add('WHERE `user_id` = ?', $id);
	$uname = $db->result($db->query());
	if(empty($uname)) {
		show_message('error', '用户不存在.');
	}
	if(Form::is_post()) {
		$acl_type = $_POST['acl_type'];
		$acl_value = $_POST['acl_type'];
		$db->sql_add('WHERE `uacl_uid` = ?', $id);
		$db->delete('user_acl');
		foreach($acl_type as $key => $value) {
			if($value === '') continue;
			$db->set('uacl_uid', $id);
			$db->set('uacl_aclid', $key);
			$db->set('uacl_value', $acl_value[$key]);
			$db->set('uacl_type', $value);
			$db->insert('user_acl');
		}
	}else{
		$db->select('*')->from('acl');
		$db->sql_add('LEFT JOIN `'.DB_PREFIX.'user_acl` ON `acl_id` = `uacl_aclid` AND `uacl_uid` = ? ORDER BY `acl_type`, `acl_name`', $id);
		foreach($db->get() as $row) {
			$list[] = array(
				'acl_id' => $row['acl_id'],
				'acl_name' => $row['acl_name'],
				'acl_desc' => $row['acl_desc'],
				'acl_key' => $row['acl_key'],
				'acl_type' => $row['acl_type'],
				'acl_value' => ($row['uacl_value'] ? $row['uacl_value'] : $row['acl_default']),
				'acl_state' => $row['uacl_type']
			);
		}
		include MOD_PATH.'templates/acl.auth.tpl.php';
	}
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	修改用户组权限
//--------------------------------------------
if($_REQUEST['do'] == 'auth_group') {
	$id = $_REQUEST['id'];
	if(!preg_match('/^[0-9]+$/', $id)) {
		show_message('error', '非法参数.');
	}
	$db->select('`group_name`')->from('group')->sql_add('WHERE `group_id` = ?', $id);
	$uname = $db->result($db->query());
	if(empty($uname)) {
		show_message('error', '用户组不存在.');
	}
	if(Form::is_post()) {
		$acl_type = $_POST['acl_type'];
		$acl_value = $_POST['acl_type'];
		$db->sql_add('WHERE `uacl_uid` = ?', $id);
		$db->delete('group_acl');
		foreach($acl_type as $key => $value) {
			if($value === '') continue;
			$db->set('gacl_gid', $id);
			$db->set('gacl_aclid', $key);
			$db->set('gacl_value', $acl_value[$key]);
			$db->set('gacl_type', $value);
			$db->insert('group_acl');
		}
	}else{
		$db->select('*')->from('acl');
		$db->sql_add('LEFT JOIN `'.DB_PREFIX.'group_acl` ON `acl_id` = `gacl_aclid` AND `gacl_gid` = ? ORDER BY `acl_type`, `acl_name`', $id);
		foreach($db->get() as $row) {
			$list[] = array(
				'acl_id' => $row['acl_id'],
				'acl_name' => $row['acl_name'],
				'acl_desc' => $row['acl_desc'],
				'acl_key' => $row['acl_key'],
				'acl_type' => $row['acl_type'],
				'acl_value' => ($row['gacl_value'] ? $row['gacl_value'] : $row['acl_default']),
				'acl_state' => $row['gacl_type']
			);
		}
		include MOD_PATH.'templates/acl.auth.tpl.php';
	}
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	权限列表
//--------------------------------------------
$pagenum = $_GET['page'];
if(!preg_match('/^\d+$/', $page)) {
	$pagenum = 1;
}
$pagesize = 20;
$record_count = $pagecount = 0;

$db->select('COUNT(*)')->from('acl');
$record_count = $db->result($db->query());
$pagecount = ceil($record_count / $pagesize);
if($pagenum > $pagecount) $pagenum = $pagecount;
$offset = ($pagenum - 1) * $pagenum;
if($offset < 0) $offset = 0;
$offset = abs($offset);

$url = 'index.php?'.$_SERVER["QUERY_STRING"];
if(strpos('page=', $url) === FALSE) {
	$url .= empty($url) ? 'page={page}':'&page={page}';
}else{
	$url = preg_replace('/page=(\d+)/i', 'page={page}', $url);
}

Paginate::set_paginate($url, $pagenum, $pagecount, $pagesize, 2);

$db->select('*')->from('acl')->sql_add("LIMIT {$offset}, {$pagesize}");
$list = $db->get();
include MOD_PATH.'templates/acl.list.tpl.php';
//--------------------------------------------

/* End of this file */