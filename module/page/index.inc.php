<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 自定义页显示模块
 */

//读取自定义页面名称
$key = $_GET['key'];

//检查缓存情况
Cache::get_page('page/'.$key);

//读取自定义页面信息
$pinfo = Page::get($key);

//不存在返回404错误
if(!$pinfo) {
	show_404();
}

//设置生成静态, 转向静态页
if($pinfo['page_static'] == '1') {
	redirect($pinfo['page_url']);
}

//设置页面标题/关键字等
View::set_title($pinfo['page_name']);
View::set_keywords($pinfo['page_keyword']);
View::set_description($pinfo['page_desc']);

//加载模板显示
View::load($pinfo['page_template']);

//保存至缓存
Cache::set_page('page/'.$key);

/* End of this file */