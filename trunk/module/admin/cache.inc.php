<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 系统设置管理页
 */

//载入公共文件
require_once MOD_PATH.'common.php';

Cache::clear();
Cache::delete_page();
@rm_file(BASEPATH.'cache/tpl');
@rm_file(SESSION_PATH);
show_message('success', '清空所有缓存成功!', array('返回管理首页'=>'index.php?m=admin&a=main'));

/* End of this file */