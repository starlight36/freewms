<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
 * 系统主配置文件
 */

//memcache缓存服务器连接设置
define('MEMCACHE_HOST', 'localhost'); //缓存服务器主机
define('MEMCACHE_PORT', '11211'); //缓存服务器端口

//session设置
define('SESSION_TYPE', 'file'); //session存储类型
define('SESSION_PATH', DIR_ROOT.'temp/'); //session存储位置(文件模式下可用)
define('SESSION_TABLE', 'session'); //session表名(数据库模式下可用)
define('SESSION_PERFIX', 'cms_'); //session前缀
define('SESSION_EXPIRE', 1800); //session生命周期, 单位秒

//cookies设置
define('COOKIES_PERFIX', 'cms_'); //cookies前缀
define('COOKIES_DOMAIN', ''); //cookies作用域
define('COOKIES_PATH', '/'); //cookies作用路径

//缓存设置
define('CACHE_TYPE', 'file'); //缓存方法
define('CACHE_PATH', DIR_ROOT.'cache/'); //缓存文件位置,仅文件缓存时可用
define('CACHE_EXPIRE', 7200); //缓存超时时限, 单位秒, 0为永不超时
define('CACHE_PAGE_EXPIRE', 7200); //页面缓存超时时限, 单位秒, 0为永不超时

//安全字符串设置
define('SAFETY_STRING', 'cms123456'); //用于增加密码强度的随机字符串

//服务器时差设置
define('TIME_DIFF', 8 * 3600); //设置系统显示时间和格林威治时间的差值,单位秒

//URI路由模式设置
//可选:
//  GET				标准GET参数方式
//  PATH			使用PATH_INFO
//  QUERY_STRING	URL参数取值
define('URI_MODE', 'GET');

//是否开启伪静态
define('URL_REWRITE', FALSE);

//MVC设置
define('FRONT_CONTROLLER', 'index.php');
define('DEFAULT_CONTROLLER', 'index'); //默认控制器
define('DEFAULT_ACTION', 'index'); //默认动作

//动态输出压缩设置
define('GZIP', TRUE);

/* End of the file */