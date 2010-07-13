<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 部件 顶部导航栏部件类
 */

class widget_topbar {
	private $topbar;

	public function  __construct() {
		$this->topbar = new Topbar();
	}

	public function get() {
		return $this->topbar->get();
	}
}

/* End of this file */