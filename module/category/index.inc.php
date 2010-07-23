<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 分类页显示模块
 */

//读取分类关键字
$key = $_GET['key'];

//检查缓存情况
Cache::get_page('category/'.$key);

//读取分类信息
$content = new Content();
$cinfo = $content->get_category($key);

//不存在则显示404错误
if(!$cinfo) {
	show_404();
}

//如果没有子分类，就直接转跳到列表页
if($cinfo['cate_childid'] == NULL) {
	redirect($cinfo['cate_listurl']);
}

//设置了生成静态, 则转向静态页
if($cinfo['cate_static'] == '1') {
	redirect($cinfo['cate_url']);
}

//设置页面标题/关键字等
View::set_title($cinfo['cate_name']);
View::set_keywords($cinfo['cate_keywords']);
View::set_description($pinfo['cate_description']);

//准备参数/加载页面模板
View::load($cinfo['cate_template'].'/index', $cinfo);

//缓存页面
Cache::set_page('category/'.$key);

/* End of this file */