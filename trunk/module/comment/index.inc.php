<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 评论显示模块
 */

//读取内容ID/页码
$id = $_GET['id'];
$pagenum = $_GET['page'];

//判断格式
if(!preg_match('/^\d+$/', $id)) {
	show_404();
}

//初始化页码
if($pagenum < 1) {
	$pagenum = 1;
}

//设置查询参数
$args['contentid'] = $id;
$args['state'] = 1;
$args['order'] = array('comment_time ASC');

//读取内容信息
$content = new Content();
$cinfo = $content->get_content($id);
if(!$cinfo) {
	show_404();
}

//初始化分页参数
$pagesize = 20;
$record_count = $pagecount = 0;

//读取评论列表
$comment = new Comment();
$list = $comment->get_comment_list($args, $pagesize, $pagenum, $record_count, $pagecount);

//生成翻页导航
$url = URL::get_url('comment', 'm=comment&id='.$id.'&page={page}');
Paginate::set_paginate($url, $pagenum, $pagecount, $pagesize);

//设置视图输出
View::set_title('评论: '.$cinfo['content_title']);
View::set_description($cinfo['content_title'].'-'.$cinfo['cate_description']);
View::set_keywords($cinfo['content_title']);

$page_param = array(
	'content' => $cinfo,
	'comment_list' => $list,
);
View::load($cinfo['cate_template'].'/comment');

/* End of this file */