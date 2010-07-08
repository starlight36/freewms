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
		$cate['cate_template'] = $cate['cate_template'] ? $cate['cate_template'] : $cate['mod_template'];

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
	 * 取得子分类列表
	 * @param int $parentid
	 * @return mixed
	 */
	public function get_category_list($parentid = 0) {
		$catelist = Cache::get('category_list_'.$parentid);
		if($catelist != FALSE) {
			return $catelist;
		}
		$db = DB::get_instance();
		$db->select('cate_id')->from('category')->sql_add('WHERE `cate_parentid` = ?', $parentid);
		$catelist = $db->get();
		if($catelist == NULL) {
			return FALSE;
		}
		foreach($catelist as $row) {
			$list[] = $this->get_category($row['cate_id']);
		}
		$catelist = $list;
		Cache::set('category_list_'.$parentid, $catelist);
		return $catelist;
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

		//对读出数据进行预处理
		$content['content_viewrole'] = unserialize($content['content_viewrole']);

		//加载内容分类及关联模型信息
		$cateinfo = $this->get_category($content['content_cateid']);
		$content_key = $row['content_key'] ? $row['content_key'] : $row['content_id'];
		if($cateinfo['cate_static'] && empty($content['content_viewrole']) &&
				empty($content['content_viewpass'])) {
			$url = $cateinfo['cate_path'].$content_key.'.'.Config::get('site_staticize_extname');
		}else{
			$url = URL::get_url('content_view', 'm=view&k='.$content_key);
			$cateinfo['cate_static'] = 0;
		}
		$content['content_url'] = $url;
		$content = array_merge($content, $cateinfo);

		//加载自定义字段信息
		$field = new Field();
		$ext_field = $field->get_value($content['content_id']);
		if(is_array($ext_field) && !empty($ext_field)) {
			$content = array_merge($content, $ext_field);
		}

		//加载TAG信息
		$db->select('*')->from('tags')->from('tag_content');
		$db->sql_add('WHERE `tc_tagid` = `tag_id` AND `tc_cid` = ?', $content['content_cateid']);
		$taglist = $db->get();
		if($taglist != NULL) {
			foreach($taglist as $row) {
				$tags[] = $row['tag_name'];
			}
			$content = array_merge($content, array('content_tags' => $tags));
		}

		//套用内容过滤器
		$this->get_filter($content['mod_filter'])->out($content);
		return $content;
	}

	/**
	 * 取得一个分页列表
	 * @param string $args YAML风格的查询参数
	 * @param int $pagesize 每页内容条数
	 * @param int $pagenum 要显示的内容列表页码
	 * @param int $record_count 总共记录数
	 * @param int $pagecount 总共分页数
	 * @return mixed
	 */
	public function get_content_list($args, $pagesize = NULL, &$pagenum = NULL, &$record_count = NULL, &$pagecount = NULL) {
		//解析参数标记
		if(!is_array($args)) {
			$args = path_array(Spyc::YAMLLoadString($args), 'args');
		}
		
		$db = DB::get_instance();
		$sql_where = NULL;
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
		//指定TAG
		if(!empty($args['tag'])) {
			$args['tag'] = addslashes($args['tag']);
			$sql_where[] = "`content_id` IN (SELECT `tc_cid` FROM `".DB_PREFIX."tag_content`, `"
					.DB_PREFIX."tags` WHERE `tc_tagid` = `tag_id` AND `tag_name` = '{$args['tag']}'";
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
		//附加查询条件
		if(!empty($args['where'])) {
			if(is_array($args['where'])) {
				foreach($args['where'] as $row) {
					$sql_where[] = $row;
				}
			}else{
				$sql_where[] = $args['where'];
			}
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
			$pagenum = $pagenum > $pagecount ? $pagecount : $pagenum;
			$offset = ($pagenum - 1) * $pagesize;
			if($offset < 0) $offset = 0;
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
		$db->select('$prefixcontent.*, $prefixuser.user_name')->from('content')->from('user');
		if(empty($sql_where)) {
			$sql_where = 'WHERE `content_userid` = `user_id`';
		}else{
			$sql_where = $sql_where. ' AND ' . '`content_userid` = `user_id`';
		}

		$db->sql_add($sql_where.$sql_order.$sql_limit);
		$list = $db->get();

		//处理结果
		if($list == NULL) {
			return FALSE;
		}
		foreach ($list as $row) {
			$row['content_viewrole'] = unserialize($row['content_viewrole']);
			$cate_info = $this->get_category($row['content_cateid']);
			$content_key = $row['content_key'] ? $row['content_key'] : $row['content_id'];
			if($cate_info['cate_static'] && empty($row['content_viewrole']) &&
					empty($row['content_viewpass'])) {
				$url = $cate_info['cate_path'].$content_key.'.'.Config::get('site_staticize_extname');
			}else{
				$url = URL::get_url('content_view', 'm=view&k='.$content_key);
				$cate_info['cate_static'] = 0;
			}
			$row['content_url'] = $url;
			$content_add = array(
				'cate_name' => $cate_info['cate_name'],
				'cate_key' => $cate_info['cate_key'],
				'cate_template' => $cate_info['cate_template'],
				'cate_static' => $cate_info['cate_static'],
				'mod_id' => $cate_info['mod_id'],
				'mod_name' => $cate_info['mod_name']
			);
			$new_list[] = array_merge($row, $content_add);
		}
		return $new_list;
	}

	/**
	 * 保存内容
	 * @param array $in 内容基本字段
	 * @return mixed
	 */
	public function set_content($in) {
		//验证输入是否为数组
		if(!is_array($in)) {
			return FALSE;
		}

		//初始化局部ID
		$id = $in['content_id'];
		if(!preg_match('/^[0-9]+$/', $id)) {
			$id = 0;
		}

		//载入数据库对象
		$db = DB::get_instance();

		//检查分类是否存在
		$cate = $this->get_category($in['content_cateid']);
		if(!$cate) {
			$this->msg = Lang::_('sys_content_no_such_category');
			return FALSE;
		}
		$modid = $cate['mod_id'];
		$mod_filter = $cate['mod_filter'];

		//分离TAG列表
		$tags = explode(' ', trim($in['content_tags']));
		unset($in['content_tags']);
		
		//执行内容过滤器
		$this->get_filter($mod_filter)->in($in);

		//设置内容写入
		$content_list = array(
			'title', 'titlestyle', 'cateid', 'userid', 'author', 'from',
			'key', 'intro', 'time', 'thumb', 'readnum', 'commentnum', 'istop', 'iscomment',
			'state', 'viewrole', 'viewpass'
		);

		foreach($content_list as $content_field) {
			if(!isset($in['content_'.$content_field])) continue;
			$set_value['content_'.$content_field] = $in['content_'.$content_field];
		}

		if($id != 0) {
			//检查要编辑的内容是否存在
			$old_content = $this->get_content($id);
			if(!$old_content) {
				return FALSE;
			}
			//更新内容主体
			$db->set($set_value);
			$db->sql_add('WHERE `content_id` = ?', $id);
			$db->update('content');
		}else{
			$db->set($set_value);
			$db->insert('content');
			$id = $db->insert_id();
		}

		//更新自定义字段
		$field = new Field();
		$field->set_value($in, $modid, $id);

		//更新TAG列表
		if(!empty($tags)) {
			$db->sql_add('WHERE `tc_cid` = ?', $id);
			$db->delete('tag_content');
			foreach($tags as $row) {
				if(empty($row)) continue;
				$db->select('tag_id')->from('tags')->sql_add('WHERE `tag_name` = ?', $row);
				$tagid = $db->result($db->query());
				if($tagid == NULL) {
					$db->set('tag_name' ,$row);
					$db->insert('tags');
					$tagid = $db->insert_id();
				}
				$db->set('tc_cid', $id);
				$db->set('tc_tagid', $tagid);
				$db->insert('tag_content');
			}
		}

		//更新缓存
		Cache::clear();

		//返回更新的内容的ID
		return $id;
	}

	/**
	 * 取得内容过滤器
	 * @param string $filtername 过滤器名称
	 * @return filtername 
	 */
	private function &get_filter($filtername) {
		require_once BASEPATH.'inc/content/'.$filtername.'.filter.php';
		$filtername = 'filter_'.$filtername;
		return new $filtername();
	}
}

/*
 * 内容过滤器接口
 */
interface if_content_filter {
	
	/**
	 * 对将要输出的内容进行过滤
	 * @param array $content_info
	 */
	public function out(&$content_info);

	/**
	 * 对将要保存进入数据库的内容进行过滤
	 * @param array $content_info
	 */
	public function in(&$content_info);
}

/* End of this file */