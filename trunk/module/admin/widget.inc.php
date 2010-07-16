<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 系统主题管理页
 */

//载入公共文件
require_once MOD_PATH.'common.php';

//载入语言文件
Lang::load('admin/widget');

//载入列表文档
$filedir = BASEPATH.'theme/'.Config::get('site_theme').'/widget/';
$wlist = unserialize(file_get_contents($filedir.'config'));

//--------------------------------------------
//	修改自定义部件(增/改)
//--------------------------------------------
if($_REQUEST['do'] == 'edit') {
	$id = $_REQUEST['id'];
	if(!preg_match('/^\d+$/', $id)) {
		$id = 0;
	}
	$form = new Form($_POST);
	$form->set_field('name', Lang::_('admin_widget_name_tip'), 'required', 'trim');
	$form->set_field('desc', Lang::_('admin_widget_desc_tip'), NULL, 'trim');
	$form->set_field('key', Lang::_('admin_widget_key_tip'), 'required|dir_name', 'trim');
	$form->set_field('content', Lang::_('admin_widget_content_tip'), 'required');
	$item = array(
		'name' => $_POST['name'],
		'desc' => $_POST['desc'],
		'key' => $_POST['key']
	);
	$winfo = $wlist[$id - 1];
	if($form->run()) {
		if($id == 0) {
			$wlist[] = $item;
		}else{
			$wlist[$id - 1] = $item;
		}
		@unlink($filedir.$winfo['key'].'.tpl.html');
		file_put_contents($filedir.$_POST['key'].'.tpl.html', $_POST['content']);
		file_put_contents($filedir.'config', serialize($wlist));
		show_message('success', Lang::_('admin_widget_success_tip'), array(Lang::_('admin_widget_return_tip') =>
											'index.php?m=admin&a=widget'));
	}else{
		$winfo['content'] = file_get_contents($filedir.$winfo['key'].'.tpl.html');
		include MOD_PATH.'templates/widget.edit.tpl.php';
	}
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	删除自定义部件(删)
//--------------------------------------------
if($_REQUEST['do'] == 'rm') {
	$id = $_REQUEST['id'];
	if(!is_array($id)) {
		$id = array($id);
	}
	foreach($id as $row) {
		$key = $wlist[$row - 1]['key'];
		unset($wlist[$row - 1]);
		@unlink($filedir.$key.'.tpl.html');
	}
	file_put_contents($filedir.'config', serialize($wlist));
	show_message('success', Lang::_('admin_widget_success_tip'), array(Lang::_('admin_widget_return_tip') =>
										'index.php?m=admin&a=widget'));
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	显示部件列表
//--------------------------------------------
include MOD_PATH.'templates/widget.list.tpl.php';
//--------------------------------------------

/* End of this file */