<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 系统设置管理页
 */

//载入公共文件
require_once MOD_PATH.'common.php';

//载入语言文件
Lang::load('admin/config');

//--------------------------------------------
//	用于取得主题下拉选择列表
//--------------------------------------------
$theme_list = array();
$dir_handle = opendir(BASEPATH.'theme');
while(false !== ($file = readdir($dir_handle))) {
	if (preg_match('/^[0-9a-z_-]+$/i', $file) && is_dir(BASEPATH.'theme/'.$file)) {
		$theme_list[] = $file;
	}
}
//--------------------------------------------

//--------------------------------------------
//	用于取得用户组下拉选择列表
//--------------------------------------------
$group_list = array();
$db = DB::get_instance();
$db->select('group_name')->select('group_id')->from('group');
$group_list = $db->get();
//--------------------------------------------

$form = new Form($_POST['config']);

//设置验证规则, 未完成
$form->set_field('site_name', Lang::_('admin_site_name_tip'), 'required', 'trim');
$form->set_field('site_desc', Lang::_('admin_site_profile_tip'), NULL, 'trim');
$form->set_field('site_keywords', Lang::_('admin_site_keywords_tip'), NULL, 'trim');
$form->set_field('site_url', Lang::_('admin_site_URL_tip'), NULL, 'trim');
$form->set_field('site_theme', Lang::_('admin_sys_default_theme_tip'), NULL, 'trim');
$form->set_field('site_state', Lang::_('admin_site_state_tip'), NULL, 'trim');
$form->set_field('site_page_cache', Lang::_('admin_site_page_cache_tip'), NULL, 'trim');
$form->set_field('site_staticize_extname', Lang::_('admin_site_staticize_extname_tip'), NULL, 'trim');
$form->set_field('site_index_staticize', Lang::_('admin_site_index_staticize_tip'), NULL, 'trim');
$form->set_field('site_url_plan', Lang::_('admin_site_url_plan_tip'), NULL, 'trim');

$form->set_field('user_guest_gid', Lang::_('admin_user_guest_gid_tip'), NULL, 'trim');
$form->set_field('user_reg', Lang::_('admin_user_reg_tip'), NULL, 'trim');
$form->set_field('user_regvalidcode',Lang::_('admin_user_regvalidcode_tip'), NULL, 'trim');
$form->set_field('user_emailvalid', Lang::_('admin_user_emailvalid_tip'), NULL, 'trim');
$form->set_field('user_adminvalid', Lang::_('admin_user_adminvalid_tip'), NULL, 'trim');
$form->set_field('user_default_gid', Lang::_('admin_user_default_gid_tip'), NULL, 'trim');
$form->set_field('user_unvalid_gid', Lang::_('admin_user_unvalid_gid_tip'), NULL, 'trim');
$form->set_field('user_name_length', Lang::_('admin_user_name_length_tip'), NULL, 'trim');
$form->set_field('user_name_denylist', Lang::_('admin_user_name_denylist_tip'), NULL, 'trim');

$form->set_field('upload_save_path', Lang::_('admin_upload_save_path_tip'), NULL, 'trim');
$form->set_field('upload_url', Lang::_('admin_upload_url_tip'), NULL, 'trim');
$form->set_field('upload_size', Lang::_('admin_upload_size_tip'), NULL, 'trim');
$form->set_field('upload_extname', Lang::_('admin_upload_extname_tip'), NULL, 'trim');

$form->set_field('pic_thumb', Lang::_('admin_pic_thumb_tip'), NULL, 'trim');
$form->set_field('pic_thumb_size', Lang::_('admin_pic_thumb_size_tip'), NULL, 'trim');
$form->set_field('pic_resize', Lang::_('admin_pic_resize_tip'), NULL, 'trim');
$form->set_field('pic_resize_size', Lang::_('admin_pic_resize_size_tip'), NULL, 'trim');
$form->set_field('pic_watermark', Lang::_('admin_pic_watermark_tip'), NULL, 'trim');
$form->set_field('pic_watermark_size', Lang::_('admin_pic_watermark_size_tip'), NULL, 'trim');
$form->set_field('pic_watermark_path', Lang::_('admin_pic_watermark_path_tip'), NULL, 'trim');
$form->set_field('pic_watermark_pct', Lang::_('admin_pic_watermark_pct_tip'), NULL, 'trim');
$form->set_field('pic_watermark_postion', Lang::_('admin_pic_watermark_postion_tip'), NULL, 'trim');

$form->set_field('mail_lib_tip', Lang::_('admin_mail_lib_tip'), NULL, 'trim');
$form->set_field('mail_account', Lang::_('admin_mail_account_tip'), NULL, 'trim');
$form->set_field('mail_smtp_host', Lang::_('admin_mail_smtp_host_tip'), NULL, 'trim');
$form->set_field('mail_smtp_port', Lang::_('admin_mail_smtp_port_tip'), NULL, 'trim');
$form->set_field('mail_smtp_user', Lang::_('admin_mail_smtp_user_tip'), NULL, 'trim');
$form->set_field('mail_smtp_pass', Lang::_('admin_mail_smtp_pass_tip'), NULL, 'trim');

$form->set_field('safe_wordfilt_plan', Lang::_('admin_safe_wordfilt_plan_tip'), NULL, 'trim');
$form->set_field('safe_denyword', Lang::_('admin_safe_denyword_tip'), NULL, 'trim');
$form->set_field('safe_denyip', Lang::_('admin_safe_denyip_tip'), NULL, 'trim');

if ($form->run()) {
	$config_file = BASEPATH.'config/site.php';
	$config_content = file_get_contents($config_file);
	foreach($_POST['config'] as $key => $value) {
		$value = str_replace("\n", "\\n", $value);
		$value = str_replace('\'', '\\\'', $value);
		$config_content = preg_replace('/\$config\[\''.$key.'\'\] = \'(.*)\';/i', '$config[\''.$key.'\'] = \''.$value.'\';', $config_content);
	}
	file_put_contents($config_file, $config_content);
	echo '保存成功!';
}else{
	include MOD_PATH.'templates/config.tpl.php';
}
/* End of this file */