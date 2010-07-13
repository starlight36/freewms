<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * URL方案
 */

$url = array(
	//内容页URL模板
	'view' => 'v-{key}.html|v-{key}-{type}.html',

	//分类页URL模板
	'category' => 'c-{key}.html',

	//列表页URL模板
	'list' => 'l-{key}.html|l-{key}-{page}.html|l-{key}-{type}.html',

	//自定义页面URL模板
	'page' => 'p-{key}.html',

	//留言页URL模板
	'guestbook' => 'gb.html|gb-{page}.html',

	//评论页URL模板
	'comment' => 'comment-{id}.html|comment-{id}-{page}.html',

	//专题页URL模板
	'subject' => 'subject-{key}.html|subject-{type}-{key}.html|subject-{type}-{key}-{page}.html',

	//TAG页路由设置
	'tag' => 'tag.html|tag-{tag}.html|tag-{tag}-{page}.html',
);

/* End of this file */