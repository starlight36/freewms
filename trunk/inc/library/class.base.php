<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
 * 基础类
 * 为其子类提供各种接口
 */

abstract class base {
	public $lang, $in, $db, $url, $config, $session;

	public function  __construct() {
		$this->lang =& load_class('lang');
		$this->in =& load_class('in');
		$this->url =& load_class('url');
		$this->config =& load_class('config');
		$this->session =& load_class('session');
		$this->db =& load_db();
	}
}

/* End of the file */