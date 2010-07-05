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

//--------------------------------------------
/* End of this file */