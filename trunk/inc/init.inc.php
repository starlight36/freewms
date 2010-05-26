<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*-------------------------------------------------
 | 定义错误报告级别
 *-----------------------------------------------*/
error_reporting(E_ALL ^ E_NOTICE && E_STRICT);

/*-------------------------------------------------
 | 强制关闭魔术引号环境
 *-----------------------------------------------*/
@set_magic_quotes_runtime(0);

/*-------------------------------------------------
 | 装入系统常量配置文件
 *-----------------------------------------------*/
require_once BASEPATH.'config/database.php';
require_once BASEPATH.'config/system.php';

/*-------------------------------------------------
 | 装入系统全局函数库
 *-----------------------------------------------*/
require_once BASEPATH.'inc/global.func.php';

/*-------------------------------------------------
 | 开始系统运行基准测试
 *-----------------------------------------------*/
$GLOBALS['sys_start_time'] = get_micro_time();

/*-------------------------------------------------
 | 注销全局变量提高安全
 *-----------------------------------------------*/
unregister_globals();

/*-------------------------------------------------
 | 设置系统时区
 *-----------------------------------------------*/
if(function_exists('date_default_timezone_set')) {
	date_default_timezone_set(SITE_TIMEZONE);
}

/*-------------------------------------------------
 | 自动类加载功能
 *-----------------------------------------------*/
function __autoload($class_name) {
	$clsfile = BASEPATH.'inc/'.strtolower($class_name).'.class.php';
	if(!is_file($clsfile)) {
		die("<p>Load Class {$class_name} Failed.</p>");
	}
	require_once $clsfile;
}
/*-------------------------------------------------
 | 加载全站设置
 *-----------------------------------------------*/
Config::load('site');

/*-------------------------------------------------
 | 初始化SESSION设置
 *-----------------------------------------------*/
if(SESSION_TYPE == 'file') {
	session_save_path(BASEPATH.SESSION_PATH);
}else{
	$session_lib_file = BASEPATH.'inc/session/'.SESSION_TYPE.'.php';
	if(is_file($session_lib_file)) {
		@include_once $session_lib_file;
		session_set_save_handler('sess_open', 'sess_close', 'sess_read', 'sess_write', 'sess_destroy', 'sess_gc');
	}else{
		die('Can not find session library named '.SESSION_TYPE);
	}
}
session_cache_expire(SESSION_EXPIRES);
session_start();

/*-------------------------------------------------
 | 开启页面压缩输出
 *-----------------------------------------------*/
if(SITE_GZIP && function_exists('ob_gzhandler')) {
	ob_start('ob_gzhandler');
}else{
	ob_start();
}

/*-------------------------------------------------
 | 载入要进入的模块
 *-----------------------------------------------*/
$module = empty($_GET['m']) ? 'index' : $_GET['m'];
$action = empty($_GET['a']) ? 'index' : $_GET['a'];

if(!preg_match('/^[a-z0-9-_]+$/i', $module.$action)) {
	$module = $action = 'index';
}

$mod_inc_file = BASEPATH.'module/'.$module.'/'.$action.'.inc.php';
$mod_cls_file = BASEPATH.'module/'.$module.'/'.$module.'.class.php';
$mod_cls_name = 'mod_'.$module;
$mod_cls_action = 'action_'.$action;

define('MOD_PATH', BASEPATH.'module/'.$module.'/');
define('MOD_NAME', $module);

if(is_file($mod_inc_file)) {
	//载入加载文件形式的模型
	include $mod_inc_file;
}elseif(is_file($mod_cls_file)) {
	//载入控制器类形式的模型
	include_once $mod_cls_file;
	if(class_exists($mod_cls_name)) {
		$obj = new $mod_cls_name();
		if(!method_exists($obj, $mod_cls_action)) show_404();
		$obj->$mod_cls_action();
	}else{
		show_404();
	}
}else{
	show_404();
}

//-----------------------------------------
//  执行结束
//-----------------------------------------
exit();

/* End of this file */