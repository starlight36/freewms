<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 内容类
 */

class Content {

	public $msg = NULL;

	public function  __construct() {
		Lang::load('content');
	}

	/**
	 * 读取一个分类的信息
	 * @param string $key 分类关键字, ID或KEY
	 * @param bool $cache 是否启用缓存
	 * @return mixed
	 */
	public function get_category($key, $cache = TRUE) {
		//从缓存读取
		$cate = Cache::get('category_'.strtolower($key));
		if($cate != FALSE && $cache) {
			return $cate;
		}

		//检查KEY形式
		if(preg_match( '/^[0-9]+$/', $key)) {
			$sql_where = 'WHERE `cate_id` = ?';
		}else{
			$sql_where = 'WHERE `cate_key` = ?';
		}

		//读取分类信息
		$db = DB::get_instance();
		$db->select('*')->from('category')->from('module')->sql_add($sql_where, $key);
		$db->sql_add('AND `cate_modid` = `mod_id`');
		$cate = $db->get();
		if($cate == NULL) {
			return FALSE;
		}
		$cate = $cate[0];

		//处理默认模板
		$cate['cate_template'] = $cate['cate_template'] ? $cate['mod_template'] : $cate['cate_template'];

		//递归获取当前分类的路径
		if(!empty($cate['cate_parentid'])) {
			$p_cate = $this->get_category($cate['cate_parentid']);
			$cate['cate_path'] = $p_cate['cate_path'].$cate['cate_key'].'/';
		}else{
			$cate['cate_path'] = $cate['cate_key'].'/';
		}

		//取得其下属所有分类的ID
		$sql = "SELECT `c2`.`cate_id` AS `child_id`"
			."FROM `".DB_PREFIX."category` AS `c1`, `".DB_PREFIX."category` AS `c2`"
			."WHERE `c1`.`cate_id` = `c2`.`cate_parentid`"
			."AND (`c1`.`cate_id` = '{$cate['cate_id']}' OR `c1`.`cate_parentid` = '{$cate['cate_id']}')";
		$query = $db->query($sql);
		if($db->num_rows($query) == 0) {
			$cate['cate_childid'] = NULL;
		}else{
			while($row = $db->fetch($query)) {
				$cate['cate_childid'][] = $row['child_id'];
			}
		}
		$db->free($query);

		//存入缓存
		Cache::set('category_'.strtolower($key), $cate);

		//返回分类信息
		return $cate;
	}

	/**
	 * 读取内容
	 * @param string $key 内容KEY/ID
	 * @return mixed
	 */
	public function get_content($key) {
		//检查KEY形式
		if(preg_match('/^[0-9]+$/', $key)) {
			$sql_where = 'WHERE `content_id` = ?';
		}else{
			$sql_where = 'WHERE `content_key` = ?';
		}
		$sql_where .= ' AND user_id = content_userid';

		//从数据库读取
		$db = DB::get_instance();
		$db->select('$prefixcontent.*')->select('$prefixuser.user_name')->from('content')->from('user');
		$db->sql_add($sql_where, $key);
		$content = $db->get();
		if($content == NULL) {
			$this->msg = Lang::_('sys_content_no_such_content');
			return FALSE;
		}
		$content = $content[0];

		$cateinfo = $this->get_category($content['content_cateid']);
		$content = array_merge($content, $cateinfo);

		//读取自定义字段
		$field = new Field();
		$ext_field = $field->get_value($content['content_id']);
		if(is_array($ext_field) && !empty($ext_field)) {
			$content = array_merge($content, $ext_field);
		}
		return $content;
	}

	public function get_content_list($args, $pagesize = NULL, $pagenum = NULL) {
		//先检查是否在缓存中存在
		$cache_name = 'content_list/'.md5($args);
		$list = Cache::get($cache_name);
		if($list != FALSE) {
			return $list;
		}
		//解析参数标记
		$args = path_array(Spyc::YAMLLoadString($args), 'args');

		$db = DB::get_instance();
		$sql_where = array();
		//指定专题
		if(preg_match('/^[0-9]+$/', $args['subject'])) {
			$sql_where[] = "`content_id` IN (SELECT `sc_contentid` FROM `".DB_PREFIX
					."subject_content` WHERE `sc_subjectid` = '{$args['subject']}')";
		}
		//指定推荐位
		if(preg_match('/^[0-9]+$/', $args['recommend'])) {
			$sql_where[] = "`content_id` IN (SELECT `rc_contentid` FROM `".DB_PREFIX
					."recommend_content` WHERE `rc_recid` = '{$args['recommend']}')";
		}
		//指定用户ID
		if(preg_match('/^[0-9]+$/', $args['uid'])) {
			$sql_where[] = "`content_userid` = '{$args['uid']}'";
		}
		//指定分类
		if($args['category']) {
			$cateinfo = $this->get_category($args['category']);
			if($cateinfo == FALSE) {
				return FALSE;
			}
			$cate_sql = "`content_cateid` = '{$cateinfo['cate_id']}'";
			//级联选择
			if($args['cascade'] && !empty($cateinfo['cate_childid'])) {
				$cate_sql .= " OR `content_cateid` IN('".implode("','", $cateinfo['cate_childid'])."')";
			}
			$sql_where[] = $cate_sql;
		}
		//指定状态
		if(preg_match('/^[0-9]+$/', $args['state'])) {
			$sql_where[] = "`content_state` = '{$args['state']}'";
		}
		if(!empty($sql_where)) {
			$sql_where = ' WHERE '.implode(' AND ', $sql_where);
		}
		//结果返回数
		if(preg_match('/^[0-9]+$/', $args['limit'])) {
			$sql_limit = ' LIMIT '.$args['limit'];
		}
		//如果指定了分页, 那么覆盖返回结果数, 同时计算总记录数
		if($pagesize != NULL) {
			$db->select('count(*)')->from('content')->sql_add($sql_where);
			$record_count = $db->result($db->query()); //总记录数
			$pagecount = ceil($record_count); //总分页数
			$pagenum = is_null($pagenum) ? 1 : $pagenum;
			$pagenum = $pagenum > $pagecount ? $pagenum : $pagecount;
			$offset = ($pagenum - 1) * $pagesize;
			$sql_limit = " LIMIT {$offset}, {$pagesize}";
		}

		//排序
		if(!empty($args['order'])) {
			$sql_order = ' ORDER BY ';
			if(is_array($args['order'])) {
				$sql_order .= implode(', ', $args['order']);
			}else{
				$sql_order .= $args['order'];
			}
		}

		//查询数据库
		$db->select('*')->from('content');
		$db->sql_add($sql_where.$sql_order.$sql_limit);
		$list = $db->get();
		if($list == NULL) {
			return FALSE;
		}
		foreach ($list as $row) {
			$cate_info = $this->get_category($row['content_cateid']);
			//处理URL
			//未完成
			$new_list[] = array_merge($row, $cate_info);
		}
		$list = $new_list;
		Cache::set($cache_name, $list);
		return $list;
	}
}

/* End of this file */