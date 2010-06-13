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
			show_message('error', '没有找到要编辑的字段.');
		}
		$cate = $cate[0];
		$parentid = $cate['cate_parentid'];
		$cate['cate_role'] = explode(',', $cate['cate_role']);
	}else{
		$parentid = $_GET['parentid'];
	}
	//进行输入验证
	$form = new Form($_POST);
	$form->set_field('cate_parentid', '所属分类', 'required|integer');
	$form->set_field('cate_modid', '绑定内容模型', 'required|integer');
	$form->set_field('cate_name', '分类名称', 'required|max_length[200]', 'trim');
	$form->set_field('cate_key', '分类目录名', 'required|max_length[50]|dir_name', 'trim');
	$form->set_field('cate_keywords', '分类关键字', 'max_length[255]', 'trim');
	$form->set_field('cate_description', '分类简介', 'max_length[255]', 'trim');
	$form->set_field('cate_template', '分类模板目录名称', 'max_length[200]', 'trim');
	$form->set_field('cate_pagesize', '分类内容列表每页条数', 'required|integer|min_num[1]', 'trim');
	$form->set_field('cate_order', '分类排序序号');
	$form->set_field('cate_role', '为用户组赋予管理权');
	$form->set_field('cate_static', '是否开启生成静态');
	if($form->run()) {
		$db->sql_add('WHERE `cate_id` = ?', $id);
		$db->set($_POST);
		if($id == 0) {
			$db->insert('category');
		}else{
			$db->update('category');
		}
		Cache::clear();
		show_message('success', '保存分类成功', array('返回分类列表页' =>
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
		show_message('error', '非法的参数.');
	}
	$db->select('*')->from('category')->sql_add('WHERE `cate_id` = ?', $id);
	$cate = $db->get();
	if($cate == NULL) {
		show_message('error', '要删除的分类不存在或者已被删除.');
	}
	$db->select('*')->from('category')->sql_add('WHERE `cate_parentid` = ?', $id);
	$cate = $db->get();
	if($cate != NULL) {
		show_message('error', '当前分类下存在子分类,要删除此分类请先删除其下的子分类.');
	}
	$db->select('COUNT(*)')->from('content')->sql_add('WHERE `content_cateid` = ?', $id);
	if($db->result($db->query()) > 0) {
		show_message('error', '当前分类下存在内容,要删除此分类请先清空其下的内容.');
	}
	$db->sql_add('WHERE `cate_id` = ?', $id);
	$db->delete('category');
	Cache::clear();
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
		show_message('error', '非法的参数.');
	}
	$db->select('*')->from('category')->sql_add('WHERE `cate_id` = ?', $id);
	$cate = $db->get();
	if($cate == NULL) {
		show_message('error', '要删除的分类不存在或者已被删除.');
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