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
Lang::load('admin/category');

//载入数据库对象
$db = DB::get_instance();

//--------------------------------------------
//	保存分类修改(增/改)
//--------------------------------------------
if($_GET['do'] == 'edit') {
	$id = $_GET['id'];
	if(!preg_match('/^[0-9]+$/', $id)) {
		$id = 0;
	}
	//编辑分类填充表单
	if($id != 0) {
		$db->select('*')->from('category')->sql_add('WHERE `cate_id` = ?', $id);
		$cate = $db->get();
		if($cate == NULL) {
			show_message('error',Lang::_('admin_no_found_edit_tip'));
		}
		$cate = $cate[0];
		$parentid = $cate['cate_parentid'];
		$cate['cate_role'] = explode(',', $cate['cate_role']);
	}else{
		$parentid = $_GET['parentid'];
	}
	//进行输入验证
	$form = new Form($_POST);
	$form->set_field('cate_parentid', Lang::_('admin_cate_parentid_tip'), 'required|integer');
	$form->set_field('cate_modid', Lang::_('admin_cate_modid_tip'), 'required|integer');
	$form->set_field('cate_name', Lang::_('admin_cate_name_tip'), 'required|max_length[200]', 'trim');
	$form->set_field('cate_key',Lang::_('admin_cate_key_tip'), 'required|max_length[50]|dir_name|_check_category_key['.$id.']', 'trim');
	$form->set_field('cate_keywords', Lang::_('admin_cate_keywords_tip'), 'max_length[255]', 'trim');
	$form->set_field('cate_description',Lang::_('admin_cate_description_tip'), 'max_length[255]', 'trim');
	$form->set_field('cate_template', Lang::_('admin_cate_template_tip'), 'max_length[200]', 'trim');
	$form->set_field('cate_pagesize', Lang::_('admin_cate_pagesize_tip'), 'required|integer|min_num[1]', 'trim');
	$form->set_field('cate_order', Lang::_('admin_cate_order_tip'));
	$form->set_field('cate_role', Lang::_('admin_cate_role_tip'));
	$form->set_field('cate_static', Lang::_('admin_cate_static_tip'));
	//处理分类角色部分
	$_POST['cate_role'] = implode(',', $_POST['cate_role']);
	if($form->run()) {
		$db->sql_add('WHERE `cate_id` = ?', $id);
		$db->set($_POST);
		if($id == 0) {
			$db->insert('category');
		}else{
			$db->update('category');
		}
		Cache::clear();
		show_message('success', Lang::_('admin_cate_success_tip'), array(Lang::_('admin_cate_return_tip') =>
											'index.php?m=admin&a=category'));
	}else{
		//创建父分类选择树
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
		$select_tpl = "<option value=\"\$id\"\$selected>\$value</option>\n";
		$cate_select_tree = $tree->plant(0, $select_tpl, $parentid);
		//创建模型选择选择列表
		$db->select('mod_id, mod_name')->from('module');
		$mod_select_list = $db->get();
		//创建管理角色用户组列表
		$db->select('group_id, group_name')->from('group')->sql_add('WHERE `group_isadmin` = 1');
		$role_select_list = $db->get();
		//输出列表
		include MOD_PATH.'templates/category.edit.tpl.php';
	}
	exit();
}
/**
 * 用于检查分类目录关键是否存在的函数
 * @global object $db 数据库对象
 * @param string $name 检查值
 * @return mixed
 */
function _check_category_key($name, $id) {
	global $db;
	if($id == 0){
	    $db->select('COUNT(*)')->from('category')->sql_add('WHERE `cate_key`= ?', $name);
	}else {
		$db->select('COUNT(*)')->from('category')->sql_add('WHERE `cate_key`= ? AND `cate_id` != ?', $name,$id);
	}
	if($db->result($db->query()) == 0) {
		return;
	}else{
		return '这个惟一标识符已被使用.';
	}
}
//--------------------------------------------

//--------------------------------------------
//	保存分类排序修改
//--------------------------------------------
if($_GET['do'] == 'order') {
	$orderlist = $_POST['order'];
	foreach($orderlist as $id => $order) {
		if(preg_match('/^[0-9]+$/', $id)) {
			$db->set('cate_order', $order);
			$db->sql_add('WHERE `cate_id` = ?', $id);
			$db->update('category');
		}
	}
	Cache::clear();
	show_message();
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	删除分类(删)
//--------------------------------------------
if($_GET['do'] == 'rm') {
	$id = $_GET['id'];
	if(!preg_match('/^[0-9]+$/', $id)) {
		show_message('error',  Lang::_('admin_show_message_error_1'));
	}
	$db->select('*')->from('category')->sql_add('WHERE `cate_id` = ?', $id);
	$cate = $db->get();
	if($cate == NULL) {
		show_message('error',  Lang::_('admin_show_message_error_2'));
	}
	$db->select('*')->from('category')->sql_add('WHERE `cate_parentid` = ?', $id);
	$cate = $db->get();
	if($cate != NULL) {
		show_message('error', Lang::_('admin_show_message_error_3'));
	}
	$db->select('COUNT(*)')->from('content')->sql_add('WHERE `content_cateid` = ?', $id);
	if($db->result($db->query()) > 0) {
		show_message('error',  Lang::_('admin_show_message_error_4'));
	}
	$db->sql_add('WHERE `cate_id` = ?', $id);
	$db->delete('category');
	Cache::clear();
	Cache::delete_page();
	show_message();
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	清空分类内容(删)
//--------------------------------------------
if($_GET['do'] == 'del') {
	$id = $_GET['id'];
	if(!preg_match('/^[0-9]+$/', $id)) {
		show_message('error', Lang::_('admin_show_message_error_1'));
	}
	$db->select('*')->from('category')->sql_add('WHERE `cate_id` = ?', $id);
	$cate = $db->get();
	if($cate == NULL) {
		show_message('error', Lang::_('admin_show_message_error_2'));
	}
	$db->sql_add('WHERE `content_cateid` = ?', $id);
	$db->delete('content');
	show_message();
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	列出所有分类(查)
//--------------------------------------------
$db->select('*')->from('category')->from('module');
$db->sql_add('WHERE `cate_modid` = `mod_id` ORDER BY `cate_order`');
$clist = $db->get();

/**
 * 读取一个分类的子分类
 * @param int $id 子分类id
 * @return mixed
 */
function _get_child_category($id) {
	global $clist;
	$temp = NULL;
	if(!is_array($clist)) {
		return NULL;
	}
	foreach ($clist as $k => $v) {
		if($v['cate_parentid'] == $id) {
			$temp[$k] = $v;
		}
	}
	return $temp;
}
include MOD_PATH.'templates/category.list.tpl.php';
//--------------------------------------------

/* End of this file */