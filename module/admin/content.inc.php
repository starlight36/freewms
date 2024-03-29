<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 内容管理页
 */

//载入公共文件
require_once MOD_PATH.'common.php';

//载入语言文件
Lang::load('admin/content');

//载入数据库对象
$db = DB::get_instance();

//--------------------------------------------
//	保存内容(增/改)
//--------------------------------------------
if($_GET['do'] == 'save') {
	$id = $_GET['id'];
	if(!preg_match('/^[0-9]+$/', $id)) {
		$id = 0;
	}
	$refer_url = $_POST['refer_url'];
	unset ($_POST['refer_url']);

	$content = new Content();
	
	//读取内容填充表单
	if($id > 0) {
		$cinfo = $content->get_content($id);
		if(!$cinfo) {
			show_message('error', Lang::_('admin_show_message_error_tip'));
		}

		//加载所属推荐位列表
		$db->select('rc_recid')->from('recommend_content');
		$db->sql_add('WHERE `rc_contentid` = ?', $id);
		$rc_list = $db->get();
		if($rc_list != NULL) {
			foreach($rc_list as $row) {
				$cinfo['recmd_list'][] = $row['rc_recid'];
			}
		}

		//加载所属专题列表
		$db->select('sc_subjectid')->from('subject_content');
		$db->sql_add('WHERE `sc_contentid` = ?', $id);
		$subj_list = $db->get();
		if($subj_list != NULL) {
			foreach($subj_list as $row) {
				$cinfo['subj_list'][] = $row['sc_subjectid'];
			}
		}
	}else{
		$cid = $_GET['cid']?$_GET['cid']:$_REQUEST['content_cateid'];
		$cinfo = $content->get_category($cid);
		if(!$cinfo) {
			show_message('error',  Lang::_('admin_admin_show_message_error_2'));
		}
		$cate_select_tree = NULL;
	}

	//设置表单验证
	$form = new Form($_POST);
	$form->set_field('content_title', Lang::_('admin_content_title_tip'), 'required|max_length[255]', 'trim');
	$form->set_field('content_cateid',Lang::_('admin_content_cateid_tip'), 'required|integer', 'trim');
    $form->set_field('content_titlestyle', '', ' required|max_length[200]', 'trim');
    $form->set_field('content_tags',Lang::_('admin_content_tags_tip'), 'max_length[255]', 'trim');
    $form->set_field('content_key', Lang::_('admin_content_key_tip'), 'dir_name|_check_content_key['.$id.']', 'trim');
    $form->set_field('content_thumb', Lang::_('admin_content_thumb_pic_tip'), NULL, 'trim');
    $form->set_field('content_intro', Lang::_('admin_introduction_tip'), 'required', 'trim');
    $form->set_field('content_author',Lang::_('admin_mod_itemname_tip'), NULL, 'trim');
    $form->set_field('content_from', Lang::_('admin_mod_source_tip'), NULL, 'trim');
    $form->set_field('content_time', Lang::_('admin_content_time_tip'), 'required', 'trim|strtotime');
    $form->set_field('content_readnum',Lang::_('admin_content_readnum_tip'), NULL, 'trim');
    $form->set_field('content_istop', Lang::_('admin_content_istop_tip'), 'required|numeric|exact_length[1]|min_num[1]|max_num[6]', 'trim');
    $form->set_field('content_iscomment', Lang::_('admin_content_iscomment_tip'), 'required|natural|exact_length[1]|max_num[1]', 'trim');
    $form->set_field('content_viewrole', Lang::_('admin_content_viewrole_tip'), NULL, 'serialize');
    $form->set_field('content_viewpass', Lang::_('admin_content_viewpass_tip'), 'max_length[16]', 'trim');
    $form->set_field('content_id', '', 'required|integer', 'trim');

	//添加自定义字段的表单验证
	$field = new Field();
	$fieldlist = $field->get_field($cinfo['mod_id']);
	foreach($fieldlist as $row) {
		$form->set_field($row['field_key'], $row['field_name'], $row['field_rules'], $row['field_filters']);
	}

	//捕获推荐位和专题选择列表
	$post_recmd_list = $_POST['content_recmd_list'];
	$post_subj_list = $_POST['content_subj_list'];


	//验证并保存
	if($form->run()) {
		//设置用户ID
		if($id == 0) {
			$_POST['content_userid'] = User::get_info('user_id');
		}

		//保存数据
		if(!$content->set_content($_POST)) {
			show_message('error', $content->msg);
		}

		//添加到推荐位
		$db->sql_add('WHERE `rc_contentid` = ?', $_POST['content_id']);
		$db->delete('recommend_content');
		if(!empty($post_recmd_list)) {
			foreach($post_recmd_list as $recmd_id) {
				$db->set('rc_recid', $recmd_id);
				$db->set('rc_contentid', $_POST['content_id']);
				$db->insert('recommend_content');
			}
		}

		//添加到专题
		$db->sql_add('WHERE `sc_contentid` = ?', $_POST['content_id']);
		$db->delete('subject_content');
		if(!empty($post_subj_list)) {
			foreach($post_subj_list as $subj_id) {
				$db->set('sc_subjectid', $subj_id);
				$db->set('sc_contentid', $_POST['content_id']);
				$db->insert('subject_content');
			}
		}
		//清空缓存
		Cache::clear();
		Cache::delete_page();
		//返回操作成功消息
		if($id == 0){
				show_message('success',  Lang::_('admin_admin_show_message_success_1_tip'),
				array(Lang::_('admin_admin_show_message_return_tip') => 'index.php?m=admin&a=content&state=0&cid='.$_POST['content_cateid']));
		}else{
				show_message('success',  Lang::_('admin_admin_show_message_success_1_tip'),
				array(Lang::_('admin_admin_show_message_return_tip') => $refer_url));
		}
	}else{
		//创建推荐位选择列表
		$db->select('rec_id, rec_name')->from('recommend');
		$recmd_select_list = $db->get();

		//创建专题选择列表
		$db->select('subject_id, subject_title')->from('subject');
		$subject_select_list = $db->get();

		//创建用户组列表
		$db->select('group_id, group_name')->from('group');
		$role_select_list = $db->get();

		//读取分类选择树
		$db->select('cate_id, cate_name, cate_parentid')->from('category');
		$db->sql_add('WHERE `cate_modid` = ?', $cinfo['mod_id']);
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
		$cate_select_tree = $tree->plant(0, "<option value=\"\$id\"\$selected>\$value</option>\n", $cinfo['cate_id']);

		//加载编辑页面模板
		include MOD_PATH.'templates/content.edit.tpl.php';
	}
	exit();
}
/**
 * 用于检查内容URL关键是否存在的函数
 * @global object $db 数据库对象
 * @param string $name 检查值
 * @return mixed
 */
function _check_content_key($name, $id) {
	global $db;
	if(!$name) return;
	if($id == 0){
	    $db->select('COUNT(*)')->from('content')->sql_add('WHERE `content_key`= ?', $name);
	}else {
		$db->select('COUNT(*)')->from('content')->sql_add('WHERE `content_key`= ? AND `content_id` != ?', $name,$id);
	}
	if($db->result($db->query()) == 0) {
		return;
	}else{
		return '这个惟一标识符已被使用.';
	}
}
//--------------------------------------------

//--------------------------------------------
//	TAG列表拉取
//--------------------------------------------
if($_REQUEST['do'] == 'taglist') {
	$db->select('`tag_name`, count(tc_tagid) AS `tag_usenum`')->from('tags')->from('tag_content');
	$db->sql_add('WHERE `tag_id` = `tc_tagid` GROUP BY `tc_tagid` ORDER BY `tag_usenum` DESC LIMIT 30');
	$taglist = $db->get();
	include MOD_PATH.'templates/content.taglist.tpl.php';
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	批量设置属性/删除(改/删)
//--------------------------------------------
if(in_array($_REQUEST['do'], array('normal', 'lock', 'recycle', 'drafts', 'rm'))) {
	$id = $_REQUEST['id'];
	if(empty($id)) {
		show_message('error',Lang::_('admin_admin_show_message_error_3_tip'));
	}
	if(!is_array($id)) $id=array($id);
	$clist = $id;

	$i = 0;
	$content = new Content();
	foreach($clist as $id) {
		$cinfo = $content->get_content($id);
		if(!$cinfo) {
			continue;
		}
		//删除静态文件
		if($cinfo['cate_static']) {
			rm_file(BASEPATH.$cinfo['content_url']);
		}
		$db->sql_add('WHERE `content_id` = ?', $id);
		switch($_REQUEST['do']) {
			case 'rm':
				$db->delete('content');
				break;
			case 'normal':
				$db->set('content_state', 0);
				$db->update('content');
				break;
			case 'lock':
				$db->set('content_state', 2);
				$db->update('content');
				break;
			case 'recycle':
				$db->set('content_state', 4);
				$db->update('content');
				break;
			case 'drafts':
				$db->set('content_state', 3);
				$db->update('content');
				break;
			default:
				break;
		}
		$i++;
	}
	Cache::clear();
	Cache::delete_page();
	show_message('success', Lang::_('admin_admin_show_message_success_2_tip', $i));
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	去出当前专题文章
//--------------------------------------------
if($_GET['do'] == 'cls'){
	$sid=$_GET['sid'];
	$id = $_GET['id'];
	$db->sql_add("WHERE `sc_contentid` = ? AND `sc_subjectid` = ?", $id,$sid);
	$db->delete('subject_content');
	show_message('success',  '取出该文章成功',
				array(Lang::_('admin_admin_show_message_return_tip') => $_SERVER['HTTP_REFERER']));
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	取消当前推荐
//--------------------------------------------
if($_GET['do'] == 'cl'){
	$rid=$_GET['rid'];
	$id = $_GET['id'];
	$db->sql_add("WHERE `rc_contentid` = ? AND `rc_recid` = ?", $id,$rid);
	$db->delete('recommend_content');
	show_message('success',  '取消推荐成功t',
				array(Lang::_('admin_admin_show_message_return_tip') => $_SERVER['HTTP_REFERER']));
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	显示内容列表(查)
//--------------------------------------------
$cate_id = $_REQUEST['cid']; //分类ID
$user_id = $_REQUEST['uid']; //用户ID
$state = $_REQUEST['state']; //状态
$search_type = $_REQUEST['search_type']; //搜索类型
$keywords = $_REQUEST['keywords']; //查找关键字
$start_time = $_REQUEST['start_time']; //开始时间
$end_time = $_REQUEST['end_time']; //结束时间
$sid = $_REQUEST['sid']; //专题ID
$rid = $_REQUEST['rid']; //推荐位ID
$pagesize = $_REQUEST['pagesize'] ? $_REQUEST['pagesize'] : 20; //每页显示数
$pagenum = $_REQUEST['page'] ? $_REQUEST['page'] : 1; //页码
$record_count = 0; //总记录数
$pagecount = 0; //总分页数
$args = array();

//筛选分类
if(preg_match('/^[0-9]+$/', $cate_id)) {
	$args['category'] = $cate_id;
}

//筛选用户
if(preg_match('/^[0-9]+$/', $user_id)) {
	$args['uid'] = $user_id;
}

//筛选状态
if(preg_match('/^[0-9]+$/', $state)) {
	$args['state'] = $state;
}

//筛选专题
if(preg_match('/^[0-9]+$/', $sid)) {
	$args['subject'] = $sid;
}

//筛选推荐位
if(preg_match('/^[0-9]+$/', $rid)) {
	$args['recommend'] = $rid;
}

//筛选起始时间
$start_time = strtotime($start_time);
if(!empty($start_time)) {
	$args['where'][] = 'content_time >= '.$start_time;
}

//筛选结束时间
$end_time = strtotime($end_time);
if(!empty ($end_time)) {
	$args['where'][] = 'content_time <= '.$end_time;
}

//设置排序方式
$args['order'][] = '`content_istop` ASC';
$args['order'][] = '`content_time` DESC';

//关键字搜索
if(!empty($keywords)) {
	if($search_type == 'id') {
		$args['where'][] = 'content_id = \''.addslashes($keywords).'\'';
	}elseif($search_type == 'key') {
		$args['where'][] = 'content_key = \''.addslashes($keywords).'\'';
	}elseif($search_type == 'title') {
		$args['where'][] = 'content_title LIKE \'%'.addslashes($keywords).'%\'';
	}elseif($search_type == 'desc') {
		$args['where'][] = 'content_intro LIKE \'%'.addslashes($keywords).'%\'';
	}elseif($search_type == 'tag') {
		$args['tag'] = $keywords;
	}
}

//创建内容对象
$content = new Content();
$clist = $content->get_content_list($args, $pagesize, $pagenum, $record_count, $pagecount);

//处理翻页URL
$url = 'index.php?'.$_SERVER["QUERY_STRING"];
if(strpos($url, 'page=') === FALSE) {
	$url .= empty($url) ? 'page={page}':'&page={page}';
}else{
	$url = preg_replace('/page=(\d+)/i', 'page={page}', $url);
}

//生成一个翻页导航条
Paginate::set_paginate($url, $pagenum, $pagecount, $pagesize, 2);

//分类选择树生成
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
$cate_select_tree = $tree->plant(0, "<option value=\"\$id\"\$selected>\$value</option>\n", $cate_id);

//载入模板
include MOD_PATH.'templates/content.list.tpl.php';

//--------------------------------------------

/* End of this file */