<?php if (!defined("IN_SYS")) die("Access Denied.");
class index extends controller {

	public function  __construct() {
		parent::__construct();
	}
	
	public function action_index() {
		if($this->config->get('site/page_cache') == TRUE) {
			cache_page_load();
		}
		$this->out->set_title('首页');
		$this->out->view('index');
		if($this->config->get('site/page_cache') == TRUE) {
			cache_page_save();
		}
	}
}

/* End of the file */