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
	'normal_content_view' => 'index.php?m=view&k={k}',
	'path_content_view' => 'view.php/{k}',
	'rewrite_content_view' => 'view/{k}',

	//分类页URL模板
	'normal_category' => 'index.php?m=category&k={k}',
	'path_category' => 'category.php/{k}',
	'rewrite_category' => 'category/{k}',

	//内容列表页URL模板
	'normal_list' => 'index.php?m=list&k={k}&page={page}',
	'path_list' => 'list.php/{k}/{page}',
	'rewrite_list' => 'list/{k}/{page}',

	//自定义页面URL模板
	'normal_page' => 'index.php?m=page&k={k}',
	'path_page' => 'page.php/{k}',
	'rewrite_page' => 'page/{k}',
);

/* End of this file */