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
		$db->select('*')->from('category')->sql_add($sql_where, $key);
		$cate = $db->get();
		if($cate == NULL) {
			return FALSE;
		}
		$cate = $cate[0];

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
}

/* End of this file */