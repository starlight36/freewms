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
Lang::load('admin/module');

//载入数据库对象
$db = DB::get_instance();

//--------------------------------------------
//	保存专题修改(增/改)
//--------------------------------------------
if($_REQUEST['do'] == 'edit') {
	exit();
}
//--------------------------------------------



/* End of this file */