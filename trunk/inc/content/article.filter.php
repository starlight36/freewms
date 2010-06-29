<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 文章模型内容过滤器
 *
 * 内容模型过滤器是在内容录入数据库前, 输出之前进行统一格式化的工具
 * 之所以引入内容过滤器是为了提高系统的可扩展性.
 * 内容过滤器需配合模型使用,在模型处需要写明内容过滤器的名称
 * 一个内容过滤器需要实现if_content_filter接口
 */
class filter_article implements if_content_filter {
	public function  __construct() {

	}

	public function out(&$content_info) {
		
	}

	public function in(&$content_info) {
		
	}
}

/* End of this file */