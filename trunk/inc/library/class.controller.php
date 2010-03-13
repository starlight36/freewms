<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
 * 控制器基类
 */
abstract class controller extends base {
	public function  __construct() {
		parent::__construct();
	}
}