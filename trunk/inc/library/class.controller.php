<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
 * 控制器基类
 */
abstract class controller extends base {
	public $out;
	public function  __construct() {
		parent::__construct();
		$this->out =& load_class('out');
	}
}
/* End of the file */