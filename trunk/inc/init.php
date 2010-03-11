<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
 * 系统启动入口文件
 */

//包含必要文件
require_once DIR_ROOT.'config/main.php';
require_once DIR_INC.'library/func.global.php';

//设置魔术引号工作环境
@set_magic_quotes_runtime(0);

//关闭注册全局变量
unregister_globals();

//自动加载的函数库
$lib_array = array('system', 'form', 'safety', 'cache');
foreach ($lib_array as $v) {
	load_library($v);
}
