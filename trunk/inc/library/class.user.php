<?php
/*
 * USER类
 * 为系统提供基本的用户接口
 */
class cls_user extends base {

	public $msg = NULL;

	public function  __construct() {
		parent::__construct();
	}

	public function register($userdata) {
		if (!is_array($userdata)) {
			$this->msg = 'No input value';
			return FALSE;
		}
		$data = array(
					'user_name' => $userdata['email'],
					'user_pass' => $userdata['pass'],
					'user_regtime' => now(),
					'user_regip' => $this->in->ip(),
				);
		$this->db->insert('user', $data);
		return TRUE;
	}
}
/* End of the file */