<?php if (!defined("IN_SYS")) die("Access Denied.");
class ctrl_index extends controller {

	public function  __construct() {
		parent::__construct();
	}
	
	public function action_index() {
		if($this->config->get('site/page_cache') == TRUE) {
			cache_page_load();
		}
		$this->out->set_title($this->lang->get('pagetitle'));
		$this->out->view('index');
		if($this->config->get('site/page_cache') == TRUE) {
			cache_page_save();
		}
	}
}

/* End of the file */