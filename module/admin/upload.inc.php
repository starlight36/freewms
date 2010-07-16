<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 文件上传页面
 */

//载入公共文件
require_once MOD_PATH.'common.php';

//载入语言文件
Lang::load('admin/filebrowser');

//载入数据库对象
$db = DB::get_instance();

//--------------------------------------------
//	上传文件表单
//--------------------------------------------
if($_GET['do'] == 'edit') {
	if(Form::is_post()) {
		$upload = new Upload('file');
		if($upload->savefile()) {
			show_message('success', '传入成功', array('返回上一页' =>'index.php?m=admin&a=upload',
													'继续传入' =>'index.php?m=admin&amp;a=upload&do=edit'));
		}else{
			show_message('error', '未传入', array('返回上一页' =>'index.php?m=admin&a=upload',
				                                  '重新传入' =>'index.php?m=admin&amp;a=upload&do=edit'));
		}
	}else{
		include MOD_PATH.'templates/upload.edit.tpl.php';
	}
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	批量删除
//--------------------------------------------
if($_REQUEST['do'] == 'rm'){
	$id = $_REQUEST['id'];
	if(empty($id)) {
		show_message('error','未选着文件！请选着！');
	}
	if(!is_array($id)) $id=array($id);
	$loadlist = $id;
	$i = 0;
	foreach($loadlist as $id) {
		$db->select('upload_path ')->from('upload');
		$db->sql_add('WHERE `upload_id` = ?', $id);
		$path = $db->result($db->query());
		$path = BASEPATH.Config::get('upload_url').$path;
		@unlink($path);
		if($isok) $i++;
		$db->sql_add('WHERE `upload_id` = ?', $id);
		$db->delete('upload');
	}
	Cache::clear();
	Cache::delete_page();
	show_message('success', '操作成功!');
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	文件列表
//--------------------------------------------
//每页显示数
$pagesize = 7;

$pagenum = $_REQUEST['page'];
$yearnum = $_REQUEST['year'];
$monthnum = $_REQUEST['month'];
$namenum = $_REQUEST['upload_name'];
if(!is_numeric($pagenum) || $pagenum < 1) {
	$pagenum = 1;
}
$sql = array();

//限定文件名
if(!empty($namenum)) {
	$sql[] = '`upload_name` LIKE \'%'.$namenum.'%\'';
}
//限定时间范围
if(preg_match('/^[0-9]+/i', $yearnum)) {
	if(preg_match('/^[0-9]+/i', $monthnum)) {
		$sql[] = '`upload_time` > '.mktime(0, 0, 0, $monthnum, 1, $yearnum);
		$sql[] = '`upload_time` < '.mktime(0, 0, 0, $monthnum, 31, $yearnum);
	}else{
		$sql[] = '`upload_time` > '.mktime(0, 0, 0, 1, 1, $yearnum);
		$sql[] = '`upload_time` < '.mktime(0, 0, 0, 12, 31, $yearnum);
	}
}

//生成SQL语句
if(empty($sql)) {
	$sql = '';
}else{
	$sql = 'WHERE '.implode(' AND ', $sql);
}

//查询结果数
$db->select('COUNT(*)')->from('upload')->sql_add($sql);
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
Paginate::set_paginate($url, $pagenum, $pagecount, $pagesize, 1);

//查询结果集
$db->select('*')->from('upload')->sql_add("$sql ORDER BY `upload_name` ASC LIMIT $offset, $pagesize");
$uploadlist = $db->get();

//载入模板
include MOD_PATH.'templates/upload.list.tpl.php';

//--------------------------------------------

/* End of this file */