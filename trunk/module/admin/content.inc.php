<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 内容管理页
 */

//载入公共文件
require_once MOD_PATH.'common.php';

//载入语言文件
Lang::load('admin/content');

//载入数据库对象
$db = DB::get_instance();

//--------------------------------------------
//	保存内容(增/改)
//--------------------------------------------
if($_GET['do'] == 'save') {

	exit();
}
//--------------------------------------------

//--------------------------------------------
//	批量设置属性(改)
//--------------------------------------------
if($_GET['do'] == 'set') {

	exit();
}
//--------------------------------------------

//--------------------------------------------
//	删除内容(删)
//--------------------------------------------
if($_GET['do'] == 'rm') {

	exit();
}
//--------------------------------------------

//--------------------------------------------
//	显示内容列表(查)
//--------------------------------------------
$cate_id = $_REQUEST['cid']; //分类ID
$user_id = $_REQUEST['uid']; //用户ID
$state = $_REQUEST['state']; //状态
$search_type = $_REQUEST['search_type']; //搜索关键字
$keywords = $_REQUEST['keywords']; //查找关键字
$start_time = $_REQUEST['start_time']; //开始时间
$end_time = $_REQUEST['end_time']; //结束时间
$sid = $_REQUEST['sid']; //专题ID
$rid = $_REQUEST['rid']; //推荐位ID



//--------------------------------------------

