<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 用户注册模块
 */

Cache::get_page('index', 7200);

Lang::load('index');
View::set_title(Lang::_('mod_index_title'));
View::load('index/index');
Cache::set_page('index');

/* End of this file */