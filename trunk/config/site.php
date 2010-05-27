<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 站点设置文件
 */

$config['site_name'] = 'FreeWMS'; //站点名称
$config['site_desc'] = '开源的网站管理系统'; //站点简介
$config['site_keywords'] = 'FreeWMS, Website Management System, CMS'; //站点关键字
$config['site_url'] = 'http://wms.mleaf.org/'; //站点URL
$config['site_theme'] = 'default';
$config['site_state'] = '1'; //站点开放状态

$config['site_page_cache'] = '0';
$config['site_staticize_extname'] = 'html';
$config['site_index_staticize'] = '0'; //首页静态化
$config['site_url_plan'] = 'normal'; //站点URL方案

$config['user_guest_gid'] = '1'; //游客组ID
$config['user_reg'] = '1'; //是否开启用户注册
$config['user_regvalidcode'] = '1'; //是否开启注册验证码
$config['user_emailvalid'] = '1'; //是否开启Email验证
$config['user_adminvalid'] = '1'; //是否开启管理员审核
$config['user_default_gid'] = '5'; //新用户默认组ID
$config['user_unvalid_gid'] = '2'; //未验证用户默认组ID
$config['user_name_length'] = '4|18'; //用户名字符串长度, 最小|最大
$config['user_name_denylist'] = 'admin|manager'; //不可使用的用户名,支持正则表达式

$config['upload_save_path'] = 'upload/'; //存储位置,相对根目录
$config['upload_url'] = 'upload/'; //URL访问位置
$config['upload_size'] = '1024000'; //允许上传的最大文件
$config['upload_extname'] = 'jpg|gif|png|jpge|bmp|zip|rar|gz|txt|doc|docx|wps|ppt|pdf'; //允许上传的文件扩展名

$config['pic_thumb'] = '1'; //是否生成缩略图
$config['pic_thumb_size'] = '300|300'; //生成缩略图的尺寸
$config['pic_resize'] = '1'; //是否将图片缩放
$config['pic_resize_size'] = '1024|1024'; //图片缩放尺寸
$config['pic_watermark'] = '20'; //是否为图片加上水印
$config['pic_watermark_size'] = '450|450'; //加水印的最小图片大小
$config['pic_watermark_path'] = 'images/watermark.png'; //水印图片地址
$config['pic_watermark_pct'] = '50'; //水印透明度
$config['pic_watermark_postion'] = '0'; //水印位置

$config['mail_lib'] = 'socket'; //邮件发送方式
$config['mail_account'] = '';
$config['mail_smtp_host'] = 'smtp.163.com'; //SMTP服务器主机
$config['mail_smtp_port'] = 25; //SMTP服务器端口
$config['mail_smtp_user'] = ''; //SMTP登录名称
$config['mail_smtp_pass'] = ''; //SMTP登录密码

$config['safe_wordfilt_plan'] = '0'; //敏感字处理方案 0 - 不处理, 1-替换, 2-设为待审, 3-拒绝提交
$config['safe_denyword'] = ''; //非法文字过滤列表
$config['safe_denyip'] = ''; //用户登录/注册屏蔽IP

/* End of this file */