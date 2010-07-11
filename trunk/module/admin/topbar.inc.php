<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

//载入公共文件
require_once MOD_PATH.'common.php';
//载入数据库对象
$db = DB::get_instance();

//--------------------------------------------
//	保存专题修改(增/改)
//--------------------------------------------
if($_REQUEST['do'] == 'edit') {
	$id = $_GET['id'];
	if(!preg_match('/^[0-9]+$/', $id)) {
		$id = 0;
	}
	echo $_GET['subject_desc'];
	$form = new Form($_POST);
	$form->set_field('topbar_name','导航名称', 'required|max_length[50]', 'trim');
	$form->set_field('topbar_desc','导航描述', 'required|max_length[255]', 'trim');
	$form->set_field('topbar_target','打开方式', 'required', 'trim');
	$form->set_field('topbar_type','链接类型', 'required', 'trim');
	$form->set_field('topbar_bindid','绑定ID', NULL, 'trim');
    $form->set_field('topbar_url','URL', NULL, 'trim');
	$form->set_field('topbar_attribute','自定义属性', 'max_length[255]', 'trim');
    $form->set_field('topbar_order','排序', 'required|numeric', 'trim');
	$form->set_field('topbar_hide','显示/隐藏', 'required', 'trim');
	if($form->run()){
       	if($id == 0) {
			$db->set($_POST);
			$db->insert('topbar');
		}else{
			$db->set($_POST);
			$db->sql_add('WHERE `topbar_id` = ?', $id);
			$db->update('topbar');
		}
		show_message('success', '添加导航成功', array('返回导航列表' =>
											'index.php?m=admin&a=topbar'));
	}else {
       if($id > 0) {
			$db->select('*')->from('topbar')->sql_add('WHERE `topbar_id` = ?', $id);
			$tinfo = $db->get();
			if($tinfo == NULL) {
				show_message('error', '要编辑的导航不存在');
			}
			$tinfo = $tinfo[0];
		}
		//读取分类选择树
		$db->select('cate_id, cate_name, cate_parentid')->from('category');
		$query = $db->query();
		$catelist = NULL;
		if($db->num_rows($query) > 0) {
			while($row = $db->fetch($query)) {
				$catelist[$row['cate_id']]['name'] = $row['cate_name'];
				$catelist[$row['cate_id']]['parentid'] = $row['cate_parentid'];
			}
		}
		$db->free($query);
		$tree = new Tree($catelist);
		$cate_select_tree = $tree->plant(0, "<option value=\"\$id\"\$selected>\$value</option>\n", $tinfo['topbar_bindid']);
		//读取自定页列表树
		$db->select('page_id, page_name')->from('page');
		$page_select_tree = $db->get();
		include MOD_PATH.'templates/topbar.edit.tpl.php';
	}
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	删除导航(删)
//--------------------------------------------
if($_REQUEST['do'] == 'del') {
	$id = $_GET['id'];
	if(!preg_match('/^[0-9]+$/', $id)) {
		$id = 0;
	}
	$db->sql_add('WHERE `topbar_id` = ?', $id);
	$db->delete('topbar');
	Cache::clear();
	Cache::delete_page();
	show_message();
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	保存分类排序修改
//--------------------------------------------
if($_GET['do'] == 'order') {
	$orderlist = $_POST['order'];
	foreach($orderlist as $id => $order) {
		if(preg_match('/^[0-9]+$/', $id)) {
			$db->set('topbar_order', $order);
			$db->sql_add('WHERE `topbar_id` = ?', $id);
			$db->update('topbar');
		}
	}
	Cache::clear();
	show_message();
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	显示导航
//--------------------------------------------
//查询记录
$db->select('*')->from('topbar');
$db->sql_add('ORDER BY `topbar_order`');
$tlist = $db->get();
include MOD_PATH.'templates/topbar.list.tpl.php';
//--------------------------------------------
/* End of this file */