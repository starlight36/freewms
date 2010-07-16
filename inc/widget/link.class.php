<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 部件 友情链接部件类
 */

class widget_link {
	private $link;

	public function  __construct() {
		$this->link = new Link();
	}

	public function get($args) {
		$cache_key = 'link/'.md5($args);
		$rst = Cache::get($cache_key);
		if($rst) {
			return $rst;
		}
		$rst = $this->link->get_link_list($args);
		Cache::set($cache_key, $rst);
		return $rst;
	}
}

/* End of this file */