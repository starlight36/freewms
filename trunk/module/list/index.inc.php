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

//读取用户参数
$key = $_GET['key'];
$page = $_GET['page'];
$tag = $_GET['tag'];
$sid = $_GET['sid'];
$type = $_GET['type'];

//初始化基本参数
$pagesize = 20;
$pagenum = $record_count = $pagecount = 0;

//加载内容对象
$content = new Content();

//格式化页数
if(!is_numeric($page) || $page < 1) {
	$page = 1;
}

//列表选择参数
$args = array();
if(!empty($key)) {
	//分类列表
	$args['category'] = $key;
	$cinfo = $content->get_category($key);
	if(!$cinfo) {
		show_404();
	}
	$pagesize = $cinfo['cate_pagesize'];
	View::set_title($cinfo['cate_name']);
	View::set_keywords($cinfo['cate_keywords']);
	View::set_description($cinfo['description']);
	$url = URL::get_url('list', 'm=list&key='.$key.'&page={page}');
	$tpl = $cinfo['cate_template'];
}elseif(!empty($tag)) {
	//TAG内容列表
	$args['tag'] = $tag;
	View::set_title('TAG: '.$tag);
	View::set_keywords($tag.', '.Config::get('site_keywords'));
	View::set_description(Config::get('site_keywords'));
	$url = URL::get_url('tag', 'm=list&tag='.$tag.'&page={page}');
	$tpl = 'tag';
}elseif(!empty($sid)) {
	//专题内容列表
	$args['subject'] = $sid;
	$subject = new Subject();
	$sinfo = $subject->get($sid);
	if(!$sinfo) {
		show_404();
	}
	View::set_title($sinfo['subject_title']);
	View::set_keywords($sinfo['subject_title']);
	View::set_description($sinfo['subject_desc']);
	$tpl = $sinfo['subject_template'];
	$url = URL::get_url('subject', 'm=list&type=list&key='.$sid.'&page={page}');
}else{
	show_404();
}


$args['order'] = array(
	'content_istop ASC',
	'content_time DESC'
);

//读取列表
$list = $content->get_content_list($args, $pagesize, $pagenum, $record_count, $pagecount);

//创建分页导航
Paginate::set_paginate($url, $pagenum, $pagecount, $pagesize);

//载入视图
$page_param = array(
	'list' => $list,
	'category_info' => $cinfo,
);
if(!empty($key) && $type == 'rss') {
	$tpl = 'system';
	View::load($tpl.'/rss', $page_param, FALSE, 'text/xml');
}else{
	View::load($tpl.'/list', $page_param);
}
/* End of this file */