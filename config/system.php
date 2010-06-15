<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

define('SYS_VERSION', '0.1.1 dev');

//Debug开关
define('DEBUG', TRUE);

//站点基本配置
define('SITE_TIMEZONE', 'PRC'); //时区设置,使用时区标识符
define('SITE_GZIP', FALSE); //是否采用GZIP输出
define('SITE_LANG', 'zh-cn'); //系统使用的语言包
define('SITE_DATE_FORMAT', 'Y-m-d'); //系统日期显示格式
define('SITE_TIME_FORMAT', 'H:i:s'); //系统时间显示格式
define('SITE_DATETIME_FORMAT', 'Y-m-d H:i:s'); //系统日期时间显示格式

//mencache服务器配置
define('MEMCACHE_HOST', 'localhost'); //memcache服务器主机
define('MEMCACHE_PORT', 11211); //memcache服务器端口
define('MEMCACHE_TIMEOUT', 1); //memcache服务器连接超时

//缓存配置
define('CACHE_TYPE', 'file'); //缓存方式, 可选file文件缓存或mencache
define('CACHE_EXPIRES', 7200); //数据缓存寿命, 单位秒, 0为不缓存
define('CACHE_PATH', 'cache/'); //文件缓存位置
define('CACHE_PAGE_EXPIRES', 7200); //页面缓存寿命, 单位秒, 0为不缓存

//SESSION配置
define('SESSION_TYPE', 'file'); //session存储方式, 包括file文件, db数据库, mencache缓存服务器
define('SESSION_EXPIRES', 1800); //session生命周期, 单位秒
define('SESSION_PATH', BASEPATH.'temp/'); //session文件方式存储位置

//COOKIE配置
define('COOKIE_PREFIX', 'freewms_'); //cookie前缀
define('COOKIE_DOMAIN', ''); //cookie作用域
define('COOKIE_PATH', '/'); //cookie 作用路径

define('SAFETY_STRING', 'freewms'); //安全加密字符串

/* End of this file */