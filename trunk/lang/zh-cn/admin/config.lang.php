<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 设置编辑语言文件
 */
$lang = array(
	'admin_sys_set_tip' => '系统设置',
	'admin_site_set_title' => '站点基本设置',
	'admin_site_set_tip' => '站点基本设置',
	'admin_user_option_set_title' => '用户选项设置',
	'admin_user_option_set_tip' => '用户选项设置',
	'admin_upload_set_title' => '上传文件设置',
	'admin_upload_set_tip' => '上传文件设置',
	'admin_email_set_title' => '邮件发送设置',
	'admin_email_set_tip' => '邮件发送设置',
	'admin_sys_security_set_title' => '系统安全设置',
	'admin_sys_security_set_tip' => '系统安全设置',
	'admin_site_name_tip' => '站点名称',
	'admin_site_profile_tip' => '站点简介',
	'admin_site_profile_title' => '站点简介',
	'admin_site_keywords_tip' => '站点关键字',
	'admin_site_keywords_title' => '站点关键字',
	'admin_site_URL_tip' => '站点URL',
	'admin_site_URL_title' => '站点URL',
	'admin_sys_default_theme_tip' => '系统默认主题',
	'admin_site_state_tip' => '站点开放状态',
	'admin_site_state_yes' => '开启',
	'admin_site_state_no' => '关闭',
	'admin_site_page_cache_tip' => '页面缓存状态',
	'admin_site_page_cache_yse' => '开启',
	'admin_site_page_cache_no' => '关闭',
	'admin_site_page_cache_title' => '开启此项可以加快页面显示速度, 获得更高的负载量, 但是会造成一定的页面更新延时.',
	'admin_site_staticize_extname_tip' => '静态文件扩展名',
	'admin_site_index_staticize_tip' => '首页静态生成',
	'admin_site_index_staticize_yse' => '开启',
	'admin_site_index_staticize_no' => '关闭',
	'admin_site_url_plan_tip' => '系统URL方案',
	'admin_site_url_plan_normal' => '查询字符串',
	'admin_site_url_plan_php_path' => 'PHP路径',
	'admin_site_url_plan_url_rewrite' => 'URL伪静态',
	'admin_user_guest_gid_tip' => '游客默认用户组',
	'admin_user_reg_tip' => '用户注册开关',
	'admin_user_reg_yes' => '开启',
	'admin_user_reg_no' => '关闭',
	'admin_user_regvalidcode_tip' => '用户注册验证码',
	'admin_user_regvalidcode_yes' => '开启',
	'admin_user_regvalidcode_no' => '关闭',
	'admin_user_emailvalid_tip' => '用户注册邮件验证',
	'admin_user_emailvalid_yes' => '开启',
	'admin_user_emailvalid_no' => '关闭',
	'admin_user_adminvalid_tip' => '用户注册管理员验证',
	'admin_user_adminvalid_yes' => '开启',
	'admin_user_adminvalid_no' => '关闭',
	'admin_user_default_gid_tip' => '新用户默认用户组',
	'admin_user_unvalid_gid_tip' => '待审核/验证用户组',
	'admin_user_name_length_tip' => '用户名长度限制',
	'admin_user_name_denylist_tip' => '用户名限制列表',
	'admin_upload_save_path_tip' => '上传文件存储位置',
	'admin_upload_url_tip' => '上传文件访问根',
	'admin_upload_size_tip' => '上传文件限制(字节)',
	'admin_upload_extname_tip' => '上传文件扩展名',
	'admin_pic_thumb_tip' => '是否生成图片缩略图',
	'admin_pic_thumb_yes' => '开启',
	'admin_pic_thumb_no' => '关闭',
	'admin_pic_thumb_size_tip' => '图片缩略图尺寸',
	'admin_pic_resize_tip' => '是否缩放大图片',
	'admin_pic_resize_yes' => '开启',
	'admin_pic_resize_no' => '关闭',
	'admin_pic_resize_size_tip' => '图片缩放尺寸',
	'admin_pic_watermark_tip' => '是否缩给图片加水印',
	'admin_pic_watermark_yes' => '开启',
	'admin_pic_watermark_no' => '关闭',
	'admin_pic_watermark_size_tip' => '加水印最小尺寸',
	'admin_pic_watermark_path_tip' => '水印图片路径',
	'admin_pic_watermark_pct_tip' => '水印图片透明度',
	'admin_pic_watermark_postion_tip' => '水印图片位置',
	'admin_pic_watermark_postion_0' => '右下',
	'admin_pic_watermark_postion_1' => '左上',
	'admin_pic_watermark_postion_2' => '左下',
	'admin_pic_watermark_postion_3' => '右上',
	'admin_pic_watermark_postion_4' => '居中',
	'admin_pic_watermark_postion_r' => '随机',
	'admin_mail_lib_tip' => '邮件发送组件',
	'admin_mail_lib_none' => '关闭邮件发送',
	'admin_mail_lib_socket' => 'Socket SMTP',
	'admin_mail_lib_mail' => 'mail函数',
	'admin_mail_account_tip' => 'SMTP邮箱帐号',
	'admin_mail_smtp_host_tip' => 'SMTP服务器',
	'admin_mail_smtp_port_tip' => 'SMTP端口',
	'admin_mail_smtp_user_tip' => 'SMTP登录用户名',
	'admin_mail_smtp_pass_tip' => 'SMTP登录密码',
	'admin_safe_wordfilt_plan_tip' => '敏感字处理方案',
	'admin_safe_wordfilt_plan_0' => '不处理',
	'admin_safe_wordfilt_plan_1' => '替换为星号',
	'admin_safe_wordfilt_plan_2' => '设为待审',
	'admin_safe_wordfilt_plan_3' => '拒绝提交',
	'admin_safe_denyword_tip' => '非法文字过滤列表',
	'admin_safe_denyip_tip' => '用户登录/注册屏蔽IP',
	'admin_submit_title' => '保存编辑',
	'admin_reset_title' => '重新编辑',






	
);
/* End of this file */