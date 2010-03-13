<?php
/*
 * 基础类
 * 为其子类提供各种接口
 */

abstract class base {
	public $in, $out, $db, $url;

	public function  __construct() {
		$this->in =& load_class('in');
		$this->out =& load_class('out');
		$this->url =& load_class('url');
		$this->db =& load_db();
	}
}
