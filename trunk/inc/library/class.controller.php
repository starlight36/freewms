<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
 * 控制器基类
 */
abstract class controller extends base {
	public $out;
	public function  __construct() {
		parent::__construct();
		$this->out =& load_class('out');
		$this->out->html_script('js/jquery/jquery.js');
		$this->out->html_style($this->config->get('site/style').'/main.css');
	}
}
/* End of the file */