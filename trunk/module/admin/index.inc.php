<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 后台首页
 */

//载入公共文件
require_once MOD_PATH.'common.php';

//载入语言文件
Lang::load('admin/index');

//--------------------------------------------
//  添加文章处分类列表树获取
//--------------------------------------------
$db = DB::get_instance();
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
$cate_select_tree = $tree->plant(0, "<option value=\"\$id\"\$selected>\$value</option>\n");
//--------------------------------------------

include MOD_PATH.'templates/index.tpl.php';
/* End of this file */