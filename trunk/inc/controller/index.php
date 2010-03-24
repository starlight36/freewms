<?php if (!defined("IN_SYS")) die("Access Denied.");
class index extends controller {

	public function  __construct() {
		parent::__construct();
	}
	
	public function action_index() {
		$this->out->set_title('hello');
		$this->out->view('index');
	}
}

/* End of the file */