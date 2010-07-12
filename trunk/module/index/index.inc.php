<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 首页模块
 */
//如果开启了生成静态,转跳至静态页
$indexfile = 'index.'.Config::get('site_staticize_extname');
if(Config::get('site_index_staticize') && is_file('./'.$indexfile)) {
	redirect($indexfile);
	exit();
}

//开启首页缓存
Cache::get_page('index');

//加载首页语言支持文件
Lang::load('index');

//设置首页标题/关键字等
View::set_title(Lang::_('mod_index_title'));
View::set_keywords(Config::get('site_keywords'));
View::set_description(Config::get('site_desc'));


//从模板加载首页
View::load('index/index');

//保存至缓存
Cache::set_page('index');
/* End of this file */