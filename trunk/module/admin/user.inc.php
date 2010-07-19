<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 用户管理页面
 */

//载入公共文件
require_once MOD_PATH.'common.php';

//载入语言文件
Lang::load('admin/user');

//载入数据库对象
$db = DB::get_instance();
//--------------------------------------------
//	保存用户修改(增/改)
//--------------------------------------------
if($_REQUEST['do'] == 'edit') {
	$id = $_GET['id'];
	if(!preg_match('/^[0-9]+$/', $id)) {
		$id = 0;
	}
	$db->select('group_name, group_id')->from('group');
	$glist = $db->get();
	$form = new Form($_POST);
	$form->set_field('user_name',Lang::_('admin_user_name_tip'),'required|max_length[50]', 'trim');
	$form->set_field('user_pass',Lang::_('admin_user_password_tip'),'max_length[32]', 'trim');
	$form->set_field('user_groupid',Lang::_('admin_user_groupid_title'),'required', 'trim');
	$form->set_field('user_email',Lang::_('admin_user_email_tip'),'required|max_length[50]|_check_user_email['.$id.']|valid_email', 'trim');
	$form->set_field('user_nickname',Lang::_('admin_user_nickname_tip'),'max_length[50]', 'trim');
	$form->set_field('user_gender',Lang::_('admin_user_gender_tip'),NULL, 'trim');
	$form->set_field('user_birthday',Lang::_('admin_user_birthday_tip'),'max_length[20]', 'trim');
	$form->set_field('user_from',Lang::_('admin_user_from_tip'),'max_length[30]', 'trim');
	$form->set_field('user_qq',Lang::_('admin_user_qq_tip'),'max_length[15]', 'trim');
	$form->set_field('user_msn',Lang::_('admin_user_msn_tip'),'max_length[1oo]', 'trim');
	$form->set_field('user_homepage',Lang::_('admin_user_homepage_tip'),'max_length[255]', 'trim');
	$form->set_field('user_description',Lang::_('admin_user_description_tip'),'max_length[255]', 'trim');
	$form->set_field('user_state',Lang::_('admin_user_state_tip'), NULL, 'trim');
	$form->set_field('user_emailvalid',Lang::_('admin_user_emailvalid_tip'),NULL, 'trim');
	$form->set_field('user_adminvalid',Lang::_('admin_user_adminvalid_tip'),NULL, 'trim');
	if($form->run()) {		
		if($id == 0){
			$_POST['user_regtime'] = time();
			$_POST['user_regip'] = get_ip();
			$_POST['user_pass'] = md5($_POST['user_pass']);
			$db->set($_POST);
			$db->insert('user');
			show_message('success',Lang::_('admin_user_success_tip'), array(Lang::_('admin_user_return_tip') => 'index.php?m=admin&a=user'));
		}else{
			$_POST['user_pass'] = md5($_POST['user_pass']);
			$db->set($_POST);
			$db->sql_add('WHERE `user_id` = ?', $id);
			$db->update('user');
			show_message('success',Lang::_('admin_user_success_0_tip'), array(Lang::_('admin_user_return_tip') => 'index.php?m=admin&a=user'));
		}
	}else{
		if($id > 0) {
			$db->select('*')->from('user')->sql_add('WHERE `user_id` = ?', $id);
			$uinfo = $db->get();
			$uinfo = $uinfo[0];
		}
		include MOD_PATH.'templates/user.edit.tpl.php';
	}
	exit();
}
/**
 * 用于检查用户Email是否存在的函数
 * @global object $db 数据库对象
 * @param string $name 检查值
 * @return mixed
 */
function _check_user_email($name, $id) {
	global $db;
	if($id == 0){
	    $db->select('COUNT(*)')->from('user')->sql_add('WHERE `user_email`= ?', $name);
	}else {
		$db->select('COUNT(*)')->from('user')->sql_add('WHERE `user_email`= ? AND `user_id` != ?', $name,$id);
	}
	if($db->result($db->query()) == 0) {
		return;
	}else{
		return Lang::_('admin_user_error_tip');
	}
}
//--------------------------------------------

//--------------------------------------------
//	批量设置属性
//--------------------------------------------
if(in_array($_REQUEST['do'], array('normal', 'lock', 'passEmail','passAdmin', 'rm'))) {
	$id = $_REQUEST['id'];
	if(empty($id)) {
		show_message('error', Lang::_('admin_user_error_0_tip'));
	}
	if(!is_array($id)) $id=array($id);
	$uslist = $id;

	$i = 0;
	foreach($uslist as $id) {
		$db->sql_add('WHERE `user_id` = ?', $id);
		switch($_REQUEST['do']) {
			case 'rm':
				$db->delete('user');
				break;
			case 'normal':
				$db->set('user_state', 0);
				$db->update('user');
				break;
			case 'lock':
				$db->set('user_state', 1);
				$db->update('user');
				break;
			case 'passEmail':
				$db->set('user_emailvalid', 1);
				$db->update('user');
				break;
			case 'passAdmin':
				$db->set('user_adminvalid', 1);
				$db->update('user');
				break;
			default:
				break;
		}
		$i++;
	}
	Cache::clear();
	Cache::delete_page();
	show_message('success', Lang::_('admin_user_success_1_tip'));
	exit();
}
//--------------------------------------------


//--------------------------------------------
//	用户列表
//--------------------------------------------
//每页显示数
$pagesize = 20;
$pagenum = $_REQUEST['page'];
if(!is_numeric($pagenum) || $pagenum < 1) {
	$pagenum = 1;
}
// 用户状态限制
$userstate = $_REQUEST['user_state'];
if(preg_match('/^[012]$/', $userstate)) {
	$sql[] = '`user_state` = '.$userstate;
}

//搜索限制  查询方式
$mode = $_REQUEST['mode'];
$actionnum = addslashes($_REQUEST['actionnum']);
if(preg_match('/^\d$/', $mode)&&!empty($actionnum)) {
	if($mode == 0){
		if(preg_match('/^\d+$/', $actionnum)){
			$sql[] = '`user_id` = '.$actionnum;
		}
	}
	if($mode == 1){
		$sql[] = '`user_name` LIKE \'%'.$actionnum.'%\'';
	}
	if($mode == 2){
		$sql[] = '`user_email` LIKE \'%'.$actionnum.'%\'';
	}
	if($mode == 3){
		$sql[] = '`user_nickname` LIKE \'%'.$actionnum.'%\'';
	}
}
//排序限制
$sqlo = '';
$sequence = $_REQUEST['sequence'];
if(preg_match('/^\d$/', $sequence)) {
	switch($sequence) {
		case 0: $sqlo = ' ORDER BY `user_regtime` ASC' ;break;
		case 1: $sqlo = ' ORDER BY `user_regtime` DESC' ;break;
		case 2: $sqlo = ' ORDER BY `user_lastlogintime` ASC' ;break;
		case 3: $sqlo = ' ORDER BY `user_lastlogintime` DESC' ;break;
		case 4: $sqlo = ' ORDER BY `user_name` ASC' ;break;
		case 5: $sqlo = ' ORDER BY `user_id` ASC' ;break;
	}
}
//生成SQL语句
if(empty($sql)) {
	$sql = '';
}else{
	$sql = 'WHERE '.implode(' AND ', $sql);
}
$sql = $sql.$sqlo;
//查询结果数
$db->select('COUNT(*)')->from('user')->sql_add($sql);
$resultcount = $db->result($db->query());

//计算分页数
$pagecount = ceil($resultcount / $pagesize);
if($pagenum > $pagecount) $pagenum = $pagecount;

//计算偏移量
$offset = $pagenum > 0 ? ($pagenum - 1) * $pagesize : 0;

//生成翻页导航
$url = 'index.php?'.$_SERVER["QUERY_STRING"];
if(strpos($url, 'page=') === FALSE) {
	$url .= empty($url) ? 'page={page}':'&page={page}';
}else{
	$url = preg_replace('/page=(\d+)/i', 'page={page}', $url);
}

//查询结果集
$sql = 'JOIN `freewms_group` ON `group_id` = `user_groupid`'.$sql;
$db->select('*')->from('user')->sql_add("$sql LIMIT $offset, $pagesize");
$userlist = $db->get();

Paginate::set_paginate($url, $pagenum, $pagecount, $pagesize, 1);
//载入模板
include MOD_PATH.'templates/user.list.tpl.php';

//--------------------------------------------

/* End of this file */