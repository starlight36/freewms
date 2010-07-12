<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 文件浏览器页面
 */

//载入公共文件
require_once MOD_PATH.'common.php';

//载入语言文件
Lang::load('admin/filebrowser');

//载入数据库对象
$db = DB::get_instance();

//--------------------------------------------
//	显示上传文件表单
//--------------------------------------------
if($_GET['do'] == 'upload') {
	if(Form::is_post()) {
		$upload = new Upload('file');
		if($upload->savefile()) {
			define('TPL_PART', 'SUCCESS');
			$filelist = $upload->get_upload_files();
		}else{
			define('TPL_PART', 'ERROR');
			$errorlist = $upload->get_errors('array');
		}
	}else{
		define('TPL_PART', 'INPUT');
	}
	include MOD_PATH.'templates/filebrowser.upload.tpl.php';
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
$filename = $_REQUEST['filename'];
if(!is_numeric($pagenum) || $pagenum < 1) {
	$pagenum = 1;
}
$sql = array();
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
//限定文件名
if(!empty($filename)) {
	$sql[] = '`upload_name` LIKE \'%'.addslashes($filename).'%\'';
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
$filelist = $db->get();

//进行预处理
$new_list = array();
foreach($filelist as $row) {
	$n_row['id'] = $row['upload_id'];
	$n_row['filename'] = Format::str_sub($row['upload_name'], 14);
	$n_row['filesize'] = Format::filesize($row['upload_size']);
	$n_row['uploadtime'] = date('Y-m-d H:i', $row['upload_time']);
	$n_row['filepath'] = $row['upload_path'];
	$n_row['filetype'] = Format::filetype(file_ext_name($row['upload_path']));
	if($n_row['filetype'] == 'image') {
		$preview = preg_replace('/^(.+)\.('.file_ext_name($row['upload_path']).')$/i', '$1_preview.$2', $n_row['filepath']);
		if(is_file(BASEPATH.Config::get('upload_save_path').$preview)) {
			$n_row['preview'] = Config::get('upload_url').$preview;
		}else{
			$n_row['preview'] = Config::get('upload_url').$n_row['filepath'];
		}
	}else{
		$n_row['preview'] = Url::base().'images/files/64/'.$n_row['filetype'].'.png';
	}
	$n_row['filepath'] = Config::get('upload_url').$n_row['filepath'];
	$new_list[] = $n_row;
}
$filelist = $new_list;

include MOD_PATH.'templates/filebrowser.list.tpl.php';
//--------------------------------------------
/* End of this file */
