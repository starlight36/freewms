<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
 * 后台管理控制器
 */

class ctrl_admin extends controller {
	public $form, $user;

	public function  __construct() {
		parent::__construct();
		$this->form =& load_class('form');
		$this->user =& load_class('user');
	}

	public function action_login() {
		if($this->form->run()) {
			$admin = $this->in->post('admin');
			$passwd = $this->in->post('passwd');
			$adminpass = $this->in->post('adminpass');
			if($this->user->login_admin($adminpass, $admin, $passwd)) {
				redirect('admin/main');
			}else{
				echo $this->user->msg;
			}
		}else{
			$this->out->view('admin/index/login');
		}
	}

	public function action_main() {
		if($this->user->check_admin()) {
			$this->out->view('admin/index/index');
		}else{
			echo 'Access Denied.';
		}
	}
}