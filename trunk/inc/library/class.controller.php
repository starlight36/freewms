<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
 * 控制器基类
 */
abstract class controller extends base {
	public $out, $user;
	public function  __construct() {
		parent::__construct();
		$this->lang->load();
		$this->out =& load_class('out');
		$this->user =& load_class('user');
		if ($this->config->get('site/page_cache') == TRUE) {
			cache_page_init();
		}
	}
}
/* End of the file */