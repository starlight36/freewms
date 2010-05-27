<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 文章模型类
 */

class Article {

	private $content = NULL;
	public $msg = NULL;
	
	public function  __construct($content) {
		$this->content = $content;
	}

	public function get() {
		$db = DB::get_instance();
		$db->select('*')->from('content_article');
		$db->sql_add('WHERE `article_contentid` = ?', $this->content['content_id']);
		$article = $db->get();
		if($article == NULL) {
			$this->msg = 'ERROR';
			return FALSE;
		}
		return $article[0];
	}
}

/* End of this file */