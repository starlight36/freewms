<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 留言板显示模块
 */

//读取用户参数
$pagenum = $_GET['page'];

//初始化页码
if($pagenum < 1) {
	$pagenum = 1;
}
$pagesize = 20;
$record_count = $pagecount = 0;

//设置查询参数
$args['state'] = '0';
$args['order'] = array('guestbook_time DESC');

$gb = new Guestbook();
$list = $gb->get_guestbook_list($args, $pagesize, $pagenum, $record_count, $pagecount);
$url = URL::get_url('guestbook', 'm=guestbook&page={page}');
Paginate::set_paginate($url, $pagenum, $pagecount, $pagesize);

//设置视图输出
View::set_title('留言');
View::set_keywords(Config::get('site_keywords'));
View::set_description(Config::get('site_desc'));
View::load('system/guestbook', array('list' => $list));

/* End of this file */