<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
| -------------------------------------------------------------------
| 站点基本信息配置文件
| -------------------------------------------------------------------
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

//负载策略
//可选项有
//	timely		最及时更新内容, 适用于负载较小的网站
//	balanced	较均衡的负载策略, 兼顾内容及时性和负载能力, 适合绝大多数网站
//	highload	高负载的策略, 适用于访问量巨大的网站
$config['loadplan'] = 'balanced';

//静态化
//可选项有
//	close	关闭静态化
//	文件扩展名, 如.html .php
$config['staticize'] = 'close';

/* End of the file */


