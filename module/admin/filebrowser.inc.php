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
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	上传文件保存
//--------------------------------------------
if($_GET['do'] == 'savefile') {
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	文件列表
//--------------------------------------------
//
include MOD_PATH.'templates/filebrowser.list.tpl.php';
exit();
//  每页条数
$pagesize = 2;
//  分页总数
$db->select('count( * )')->from('upload');
$pagecount = $db->result($db->query());
//  URl处理
$url = 'index.php?'.$_SERVER["QUERY_STRING"];
if(strpos('page=', $url) === FALSE) {
	$url .= empty($url) ? 'page={page}':'&page={page}';
}else{
	$url = preg_replace('/page=(\d+)/i', 'page={page}', $url);
}
//  当前所在页
if(!is_numeric($_GET['page'])) {
	$pagenum = 1;
}else{
 $pagenum = $_GET['page'];
}
$offset = ($pagenum - 1)*$pagesize;

//生成一个翻页导航条
Paginate::set_paginate($url, $pagenum, $pagecount, $pagesize, 2);

//分类选择树生成
$db->select('*')->from('upload')->sql_add('ORDER BY `upload_time` DESC LIMIT '.$offset.", ".$pagesize);
$temp=$db->get();
foreach($temp as $row) {
	echo "<P>".$row['upload_name'];
	echo $row['upload_time']."</p>";
}
echo Paginate::get_paginate();
//--------------------------------------------
/* End of this file */
