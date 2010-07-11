<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 部件 内容部件类
 */

class widget_content {
	private $content;
	public function  __construct() {
		$this->content = new Content();
	}

	/**
	 * 内容列表部件
	 * @param string $param YAML形式的字串
	 * @return mixed 查询结果记录集
	 */
	public function get($param) {
		$cache_key = 'content_widget/'.md5($param);
		$list = Cache::get($cache_key);
		if(!$list) {
			$list = $this->content->get_content_list($param);
			Cache::set($cache_key, $list);
		}
		return  $list;
	}

	/**
	 * 分类列表部件
	 * @param int $param
	 * @return mixed
	 */
	public function category_list($param) {
		return $this->content->get_category_list($param ? $param : 0);
	}
}

/* End of this file */