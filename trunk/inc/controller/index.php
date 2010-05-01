<?php if (!defined("IN_SYS")) die("Access Denied.");
class ctrl_index extends controller {

	public function  __construct() {
		parent::__construct();
		cache_page_load();
	}

	public function action_index() {
		$this->out->set_title($this->lang->get('pagetitle'));
		$this->out->view('index');
		cache_page_save();
	}
}

/* End of the file */