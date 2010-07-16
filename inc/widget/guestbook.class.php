<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 部件 留言部件类
 */

class widget_guestbook {
	private $gb;

	public function  __construct() {
		$this->gb = new Guestbook();
	}

	public function get($args) {
		$cache_key = 'gb/'.md5($args);
		$rst = Cache::get($cache_key);
		if($rst) {
			return $rst;
		}
		$rst = $this->gb->get_guestbook_list($args);
		Cache::set($cache_key, $rst);
		return $rst;
	}
}

/* End of this file */