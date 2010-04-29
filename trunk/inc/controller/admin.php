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

	/*
	 * 登录后台
	 */
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

	/*
	 * 后台首页
	 */
	public function action_main() {
		$this->out->set_title($this->lang->get('pagetitle'));
		if($this->user->check_admin()) {
			$this->out->view('admin/index/index');
		}else{
			$this->out->view('system/error', array('error_msg'=>'您尚未登录,不能访问管理后台.'));
		}
	}
}