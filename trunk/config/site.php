<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
| -------------------------------------------------------------------
| 站点配置文件
| -------------------------------------------------------------------
 */

/*
 * 站点基本设置
 */

//站点名
$config['sitename'] = 'FreeWMS - 开源网站管理系统';

//URL根,以/结尾
$config['base_url'] = 'http://wms.mleaf.org/';

//站点介绍
$config['description'] = '自由的网站管理系统';

//站点关键字
$config['keywords'] = 'FreeWMS,WMS,CMS,开源,内容,网站,管理系统';

//管理员邮箱
$config['webemail'] = 'yourname@domain.com';

//站点模板
$config['template'] = 'default';

//站点风格
$config['style'] = 'default';

//页面缓存
$config['page_cache'] = TRUE;

//静态化
//可选项有
//	close	关闭静态化
//	文件扩展名, 如.html .php
$config['staticize'] = 'close';

/*
 * 用户相关设置
 */

//用户注册验证方式
//可选项有
//	none	不进行验证
//	email	邮件激活验证
//	admin	管理员审核验证
$config['user']['reg_valid'] = 'none';

/* End of the file */


