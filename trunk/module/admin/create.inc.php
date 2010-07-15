<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 静态生成管理页面
 */

//设置页面超时时间
set_time_limit(3600);

//载入公共文件
require_once MOD_PATH.'common.php';

//载入数据库
$db = DB::get_instance();

//--------------------------------------------
//	生成首页
//--------------------------------------------
if($_REQUEST['do'] == 'index') {
	if(Config::get('site_index_staticize') != '1') {
		show_message('error', '系统没有开启首页生成静态, 使用此功能请先修改站点设置',
			array(
			'返回管理首页' => 'index.php?m=admin&a=main',
			'修改站点设置' => 'index.php?m=admin&a=config'
			)
		);
	}
	//产生首页内容
	Lang::load('index');
	View::set_title(Lang::_('mod_index_title'));
	View::set_keywords(Config::get('site_keywords'));
	View::set_description(Config::get('site_desc'));
	$page_content = View::load('index/index', NULL, TRUE);
	//保存到文件
	file_put_contents(BASEPATH.'index.'.Config::get('site_staticize_extname'), $page_content);
	show_message('success', '生成首页成功!',
			array('返回管理首页' => 'index.php?m=admin&a=main'));
	exit();
}
//--------------------------------------------

//--------------------------------------------
//	生成分类页静态
//--------------------------------------------
if($_REQUEST['do'] == 'category') {
	if(Form::is_post()) {
		$id = $_REQUEST['id'];
		$task = $_REQUEST['task'];
		if(empty($id) || empty($task)) {
			show_message('error', '没有选中任何要生成的分类或者任务.');
		}
		$content = new Content();
		$create_num = 0;
		$create_start_time = get_micro_time();
		foreach($id as $row) {
			$cinfo = $content->get_category($row);
			//检查分类是否需要生成静态
			if(!$cinfo) continue;
			if($cinfo['cate_static'] != '1') continue;
			//设置分页大小/分类目录
			$pagesize = $cinfo['cate_pagesize'];
			$cate_dir = BASEPATH.$cinfo['cate_path'];
			create_dir($cate_dir);
			//列表页URL模板
			$url = $cinfo['cate_path'].'list_{page}.'.Config::get('site_staticize_extname');
			//生成分类首页
			if(in_array('index', $task)) {
				//设置页面标题/关键字等
				View::set_title($cinfo['cate_name']);
				View::set_keywords($cinfo['cate_keywords']);
				View::set_description($pinfo['cate_description']);
				//准备参数/加载页面模板
				$page_content = View::load($cinfo['cate_template'].'/index', $cinfo, TRUE);
				$page_file = $cate_dir.'index.'.Config::get('site_staticize_extname');
				
				file_put_contents($page_file, $page_content);
				$create_num++;
				usleep(100);
			}
			//生成分类列表页
			if(in_array('list', $task)) {
				$args['category'] = $row;
				$args['order'] = array(
					'content_istop ASC',
					'content_time DESC'
				);
				$pagenum = 1;
				$record_count = $pagecount = 0;
				do {
					//读取列表
					$list = $content->get_content_list($args, $pagesize, $pagenum, $record_count, $pagecount);
					//创建分页导航
					Paginate::set_paginate($url, $pagenum, $pagecount, $pagesize);
					//载入视图
					$page_param = array(
						'list' => $list,
						'category_info' => $cinfo,
					);
					View::set_title($cinfo['cate_name']);
					View::set_keywords($cinfo['cate_keywords']);
					View::set_description($cinfo['description']);
					$page_content = View::load($cinfo['cate_template'].'/list', $page_param, TRUE);
					$page_file = BASEPATH.str_replace('{page}', $pagenum, $url);
					file_put_contents($page_file, $page_content);
					$create_num++;
					$pagenum++;
					usleep(100);
				}while ($pagenum < $pagecount);
				@copy($cate_dir.'list_1.'.Config::get('site_staticize_extname'), $cate_dir.'list.'.Config::get('site_staticize_extname'));
			}
		}
		$timecost = round((get_micro_time() - $create_start_time), 4);
		show_message('success', '生成静态页任务完成!<br />共生成'.$create_num.'个静态网页, 耗时'.$timecost.'秒.');
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
		$cate_select_tree = $tree->plant(0, $select_tpl);
		include MOD_PATH.'templates/create.category.tpl.php';
	}
}
//--------------------------------------------

/* End of this file */