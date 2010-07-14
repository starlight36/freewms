<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 部件 评论部件类
 */

class widget_comment {
	private $comment;

	public function  __construct() {
		$this->comment = new Comment();
	}

	public function get() {
		return $this->comment->get_comment_list($args);
	}
}

/* End of this file */