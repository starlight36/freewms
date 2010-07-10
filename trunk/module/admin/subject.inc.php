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
Lang::load('admin/subject');

//载入数据库对象
$db = DB::get_instance();

//--------------------------------------------
//	保存专题修改(增/改)
//--------------------------------------------
if($_REQUEST['do'] == 'edit') {
	$id = $_GET['id'];
	if(!preg_match('/^[0-9]+$/', $id)) {
		$id = 0;
	}
	$form = new Form($_POST);
	$form->set_field('subject_title',Lang::_('admin_subject_title_tip'), 'required|max_length[50]', 'trim');
	$form->set_field('subject_desc',Lang::_('admin_subject_desc_tip'), 'required|max_length[255]', 'trim');
	$form->set_field('subject_key', Lang::_('admin_subject_key_tip'), 'max_length[50]|_check_subject_key['.$id.']', 'trim');
	$form->set_field('subject_icon', Lang::_('admin_subject_icon_tip'), 'max_length[255]', 'trim');
	$form->set_field('subject_cateid',Lang::_('admin_subject_cateid_tip'));
	$form->set_field('subject_template', Lang::_('admin_subject_template_tip'), 'max_length[255]', 'trim');
	$form->set_field('subject_state', Lang::_('admin_subject_state_tip'));
	$form->set_field('subject_roles',Lang::_('admin_subject_roles_tip'));
	if($form->run()) {
		$_POST['subject_roles'] = serialize($_POST['subject_roles']);
		$db->set($_POST);
		if($id == 0) {
			$db->insert('subject');
		}else{
			$db->sql_add('WHERE `subject_id` = ?', $id);
			$db->update('subject');
		}
		show_message('success', Lang::_('admin_subject_success_tip'), array(Lang::_('admin_subject_return_tip') =>
											'index.php?m=admin&a=subject'));
	}else{
		//读取记录填充表单
		if($id > 0) {
			$db->select('*')->from('subject')->sql_add('WHERE `subject_id` = ?', $id);
			$sinfo = $db->get();
			if($sinfo == NULL) {
				show_message('error', Lang::_('admin_admin_subject_error_tip'));
			}
			$sinfo = $sinfo[0];
			$sinfo['subject_roles'] = unserialize($sinfo['subject_roles']);
		}else{
			$sinfo['subject_state'] = 0;
		}
		//读取分类选择树
		$db->select('cate_id, cate_name, cate_parentid')->from('category');
		$query = $db->query();
		$catelist = NULL;
		if($db->num_rows($query) > 0) {
			while($row = $db->fetch($query)) {
				$catelist[$row['cate_id']]['name'] = $row['cate_name'];
				$catelist[$row['cate_id']]['parentid'] = $row['cate_parentid'];
			}
		}
		$db->free($query);
		$tree = new Tree($catelist);
		$cate_select_tree = $tree->plant(0, "<option value=\"\$id\"\$selected>\$value</option>\n", $sinfo['subject_cateid']);
		//创建管理角色用户组列表
		$db->select('group_id, group_name')->from('group')->sql_add('WHERE `group_isadmin` = 1');
		$role_select_list = $db->get();
		include MOD_PATH.'templates/subject.edit.tpl.php';
	}
	exit();
}
/**
 * 用于检查专题URL关键是否存在的函数
 * @global object $db 数据库对象
 * @param string $name 检查值
 * @return mixed
 */
function _check_subject_key($name,$id) {
	global $db;
	if($id == 0){
	    $db->select('COUNT(*)')->from('subject')->sql_add('WHERE `subject_key`= ?', $name);
	}else {
		$db->select('COUNT(*)')->from('subject')->sql_add('WHERE `subject_key`= ? AND `subject_id` != ?', $name,$id);
	}
	if($db->result($db->query()) == 0) {
		return;
	}else{
		return '这个惟一标识符已被使用.';
	}
}
//--------------------------------------------

//--------------------------------------------
//	删除专题(删)
//--------------------------------------------
if($_REQUEST['do'] == 'del') {
	$id = $_GET['id'];
	if(!preg_match('/^[0-9]+$/', $id)) {
		$id = 0;
	}
	$db->sql_add('WHERE `sc_subjectid` = ?', $id);
	$db->delete('subject_content');
	$db->sql_add('WHERE `subject_id` = ?', $id);
	$db->delete('subject');
	Cache::clear();
	Cache::delete_page();
	show_message();
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	列表显示专题
//--------------------------------------------
$pagesize = 20; //每页显示数目
$pagenum = $_REQUEST['page'];  //取页码
if(!preg_match('/^[0-9]+$/i', $pagenum)) {
	$pagenum = 1;
}
//读取结果集总数
$db->select('COUNT(*)')->from('subject');
$record_count = $db->result($db->query());
//计算分页数
$pagecount = ceil($record_count / $pagesize);
if($pagenum > $pagecount) $pagenum = $pagecount;
//设置游标
$offset = $pagenum > 0 ? ($pagenum - 1) * $pagesize : 0;
//查询记录
$db->select('*')->from('subject')->sql_add("LIMIT $offset, $pagesize");
$slist = $db->get();
//生成翻页导航
$url = 'index.php?'.$_SERVER["QUERY_STRING"];
if(strpos('page=', $url) === FALSE) {
	$url .= empty($url) ? 'page={page}':'&page={page}';
}else{
	$url = preg_replace('/page=(\d+)/i', 'page={page}', $url);
}
Paginate::set_paginate($url, $pagenum, $pagecount, $pagesize);
include MOD_PATH.'templates/subject.list.tpl.php';
//--------------------------------------------

/* End of this file */