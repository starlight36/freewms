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
		$list = Cache::get('content_list/'.md5($args));
		if($list != FALSE) {
			return $list;
		}
		$args = path_array(Spyc::YAMLLoadString($args), 'args');
		$sql = NULL;
		if(!empty($args['where'])) {
			$sql .= 'WHERE ';

		}
	}
}

/* End of this file */