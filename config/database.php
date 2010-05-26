<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-----------------------------------------------*/

/*-------------------------------------------------
 * 数据库连接参数设置
 *-----------------------------------------------*/
define('DB_TYPE', 'mysql'); //数据库连接类型
define('DB_PATH', NULL);
define('DB_HOST', 'localhost'); //服务器地址
define('DB_NAME', 'freewms'); //数据库名称
define('DB_USER', 'freewms'); //数据库用户名
define('DB_PASS', 'freewms'); //数据库密码
define('DB_PCONN', 0); //是否使用数据库持久连接
define('DB_PREFIX', 'freewms_'); //表前缀

/* End of this file */