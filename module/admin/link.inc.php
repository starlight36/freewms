<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/
/**
 * 留言列表页模版
 */
//载入公共文件
require_once MOD_PATH.'common.php';
//载入语言文件
Lang::load('admin/link');
//从数据库读取
$db = DB::get_instance();
//--------------------------------------------
//	修改友情链接
//--------------------------------------------
if($_REQUEST['do'] == 'edit') {
	$id = $_GET['id'];
	if(!preg_match('/^[0-9]+$/', $id)) {
		$id = 0;
	}
	$form = new Form($_POST);
	$form->set_field('link_title',Lang::_('admin_link_title_tip'),'required|max_length[50]', 'trim');
	$form->set_field('link_desc',Lang::_('admin_link_desc_tip'), 'max_length[255]', 'trim');
	$form->set_field('link_url',Lang::_('admin_link_url_tip'), 'required|max_length[255]', 'trim');
	$form->set_field('link_img',Lang::_('admin_link_img_tip'), 'max_length[255]', 'trim');
	$form->set_field('link_isdisplay',Lang::_('admin_link_isdisplay_tip'));
	if($form->run()){
		$db->set($_POST);
		if($id == 0) {
			$db->insert('link');
		}else {
			$db->sql_add('WHERE `link_id` = ?', $id);
			$db->update('link');
		}
		show_message('success', Lang::_('admin_link_success_tip'), array( Lang::_('admin_link_return_tip')=>'index.php?m=admin&a=link'));
	}else {
		if($id > 0) {
			$db->select('*')->from('link');
			$db->sql_add('WHERE `link_id` = ?',$id);
			$list = $db->get();
			//处理结果
			if($list == NULL) {
				return FALSE;
			}
		    $linkinfo = $list[0];
		}
		include MOD_PATH.'templates/link.edit.tpl.php';
	}
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	批量设置属性/删除(改/删)
//--------------------------------------------
if(in_array($_REQUEST['do'], array('dly', 'undly', 'rm'))) {
	$id = $_REQUEST['id'];
	if(empty($id)) {
		show_message('error',Lang::_('admin_link_error_tip'));
	}
	if(!is_array($id)) $id=array($id);
	$linklist = $id;
	$i = 0;
	foreach($linklist as $id) {
		$db->sql_add('WHERE `link_id` = ?', $id);
		switch($_REQUEST['do']) {
				case 'rm':
					$db->delete('link');
					break;
				case 'dly':
				    $db->set('link_isdisplay', 1);
				    $db->update('link');
					break;
				case 'undly':
					$db->set('link_isdisplay', 0);
					$db->update('link');
					break;
				default:
					break;
		}
	}
	Cache::clear();
	Cache::delete_page();
	show_message('success', Lang::_('admin_link_success_1_tip'));
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	显示链接
//--------------------------------------------
//处理翻页URL
$args = NULL;
$url = 'index.php?'.$_SERVER["QUERY_STRING"];
if(strpos($url, 'page=') === FALSE) {
	$url .= empty($url) ? 'page={page}':'&page={page}';
}else{
	$url = preg_replace('/page=(\d+)/i', 'page={page}', $url);
}
$pagesize =  20; //每页显示数
$pagenum = $_REQUEST['page'] ? $_REQUEST['page'] : 1; //页码
$record_count = 0; //总记录数
$pagecount = 0; //总分页数
//查询记录
$link = new Link();
$linklist = $link->get_link_list($args, $pagesize, $pagenum, $record_count, $pagecount);
Paginate::set_paginate($url, $pagenum, $pagecount, $pagesize);
include MOD_PATH.'templates/link.list.tpl.php';
//--------------------------------------------
/* End of this file */