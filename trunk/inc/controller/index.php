<?php if (!defined("IN_SYS")) die("Access Denied.");
class index extends controller {

	public function  __construct() {
		parent::__construct();
	}
	
	public function action_index() {
		echo 'Hello world!';
	}
}