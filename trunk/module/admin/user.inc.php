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
Lang::load('admin/filebrowser');

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
	$form->set_field('user_name','用户名','required|max_length[50]', 'trim');
	$form->set_field('user_pass','用户密码','max_length[32]', 'trim');
	$form->set_field('user_groupid','required|用户所属组名','required', 'trim');
	$form->set_field('user_email','Email','required|max_length[50]|_check_user_email['.$id.']|valid_email', 'trim');
	$form->set_field('user_nickname','昵称','max_length[50]', 'trim');
	$form->set_field('user_gender','性别',NULL, 'trim');
	$form->set_field('user_birthday','生日','max_length[20]', 'trim');
	$form->set_field('user_from','来自','max_length[30]', 'trim');
	$form->set_field('user_qq','qq号','max_length[15]', 'trim');
	$form->set_field('user_msn','msn号','max_length[1oo]', 'trim');
	$form->set_field('user_homepage','主页','max_length[255]', 'trim');
	$form->set_field('user_description','个人描述','max_length[255]', 'trim');
	$form->set_field('user_state','状态', NULL, 'trim');
	$form->set_field('user_emailvalid','是否通过邮件验证',NULL, 'trim');
	$form->set_field('user_adminvalid','是否通过用户验证',NULL, 'trim');
	if($form->run()) {		
		if($id == 0){
			$_POST['user_regtime'] = time();
			$_POST['user_regip'] = get_ip();
			$_POST['user_pass'] = md5($_POST['user_pass']);
			$db->set($_POST);
			$db->insert('user');
			show_message('success','添加用户成功！', array('返回上一页' => 'index.php?m=admin&a=user'));
		}else{
			$_POST['user_pass'] = md5($_POST['user_pass']);
			$db->set($_POST);
			$db->sql_add('WHERE `user_id` = ?', $id);
			$db->update('user');
			show_message('success','修改用户信息成功！', array('返回上一页' => 'index.php?m=admin&a=user'));
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
		return '这个惟一标识符已被使用.';
	}
}
//--------------------------------------------

//--------------------------------------------
//	批量设置属性
//--------------------------------------------
if(in_array($_REQUEST['do'], array('normal', 'lock', 'passEmail','passAdmin', 'rm'))) {
	$id = $_REQUEST['id'];
	if(empty($id)) {
		show_message('error','未选着用户！');
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
	show_message('success', '操作成功!');
	exit();
}
//--------------------------------------------


//--------------------------------------------
//	用户列表
//--------------------------------------------
//每页显示数
$pagesize = 7;

$pagenum = $_REQUEST['page'];
$yearnum = $_REQUEST['year'];
$monthnum = $_REQUEST['month'];
$namenum = $_REQUEST['user_name'];
if(!is_numeric($pagenum) || $pagenum < 1) {
	$pagenum = 1;
}
$sql = array();

//限定文件名
if(!empty($namenum)) {
	$sql[] = '`user_name` LIKE \'%'.$namenum.'%\'';
}
// 用户状态限制
$state = $_REQUEST['state'];
if(preg_match('/^[012]$/', $state)) {
	$sql[] = '`user_state` = '.$state;
}

//限定时间范围
if(preg_match('/^[0-9]+/i', $yearnum)) {
	if(preg_match('/^[0-9]+/i', $monthnum)) {
		$sql[] = '`user_regtime` > '.mktime(0, 0, 0, $monthnum, 1, $yearnum);
		$sql[] = '`user_regtime` < '.mktime(0, 0, 0, $monthnum, 31, $yearnum);
	}else{
		$sql[] = '`user_regtime` > '.mktime(0, 0, 0, 1, 1, $yearnum);
		$sql[] = '`user_regtime` < '.mktime(0, 0, 0, 12, 31, $yearnum);
	}
}

//生成SQL语句
if(empty($sql)) {
	$sql = '';
}else{
	$sql = 'WHERE '.implode(' AND ', $sql);
}
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
if(strpos('page=', $url) === FALSE) {
	$url .= empty($url) ? 'page={page}':'&page={page}';
}else{
	$url = preg_replace('/page=(\d+)/i', 'page={page}', $url);
}

//查询结果集
$sql = 'JOIN `freewms_group` ON `group_id` = `user_groupid`'.$sql;
$db->select('*')->from('user')->sql_add("$sql ORDER BY `user_regtime` ASC LIMIT $offset, $pagesize");
$userlist = $db->get();

Paginate::set_paginate($url, $pagenum, $pagecount, $pagesize, 1);
//载入模板
include MOD_PATH.'templates/user.list.tpl.php';

//--------------------------------------------

/* End of this file */