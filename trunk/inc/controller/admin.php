<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
 * 后台管理控制器
 */

class ctrl_admin extends controller {
	public $form;

	public function  __construct() {
		parent::__construct();
		$this->form =& load_class('form');
	}

	public function action_login() {
		if($this->form->run()) {
			echo 'OK';
		}else{
			$this->out->view('admin/index/login');
		}
	}

	public function action_main() {
		$this->out->view('admin/index/index');
	}
}