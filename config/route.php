<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 路由配置文件
 */

$route = array(
	//内容URL路由设置
	'v-(\w+?)\.html' => 'm=view&key=$1',
	'v-(\w+?)-print\.html' => 'm=view&key=$1&type=print',

	//分类页URL路由设置
	'c-(\w+?)\.html' => 'm=category&key=$1',

	//列表页URL路由设置
	'l-(\w+?)\.html' => 'm=list&key=$1',
	'l-(\w+?)-(\d+?)\.html' => 'm=list&key=$1&page=$2',
	'l-(\w+?)-rss\.html' => 'm=list&key=$1&type=rss',

	//自定义页面URL路由设置
	'p-(\w+?)\.html' => 'm=page&key=$1',

	//留言页URL路由设置
	'gb\.html' => 'm=guestbook',
	'gb-(\d+?)\.html' => 'm=guestbook&page=$1',

	//评论页URL路由设置
	'comment-(\d+?)\.html' => 'm=comment&id=$1',
	'comment-(\d+?)-(\d+?)\.html' => 'm=comment&id=$1&page=$2',

	//专题页URL路由设置
	'subject-(\w+?)\.html' => 'm=subject&key=$1',
	'subject-list-(\w+?)\.html' => 'm=list&sid=$1',
	'subject-list-(\w+?)-(\d+?)\.html' => 'm=list&sid=$1&page=$2',

	//TAG页路由设置
	'tag\.html' => 'm=tag',
	'tag-(.+?)\.html' => 'm=list&tag=$1',
	'tag-(.+?)-(\d+?)\.html' => 'm=list&tag=$1&page=$2',
);

/* End of this file */