<?php
/*
 * 前端控制器文件
 */

//设置错误消息等级
error_reporting(E_ERROR | E_WARNING | E_PARSE);

//取得基本路径
$base_dir = str_replace('\\', '/', dirname(__FILE__)).'/';

//定义系统常量
define('IN_SYS', TRUE);
define('DIR_ROOT', $base_dir);
define('DIR_INC', $base_dir.'inc/');

//系统开始运行
require_once DIR_INC.'init.php';
/* End of the file */