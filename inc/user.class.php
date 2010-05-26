<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 用户类
 * --单例类
 */
class User {
	private static $instance;
	private static $userinfo = NULL;
	public $msg = NULL;

	private function  __construct() {
		Lang::load('user');
	}

	private function  __clone() {
		return FALSE;
	}

	/**
	 * 获取用户对象
	 * @return object
	 */
	public static function get_instance() {
		if(!(self::$instance instanceof self)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * 读取用户信息
	 * @param string $uid 用户ID或名称
	 * @return array
	 */
	public function get_user($uid = NULL) {
		if($uid == NULL) {
			self::$userinfo = Session::get('user');
			if(empty(self::$userinfo)) {
				self::$userinfo = array(
					'user_id' => 0,
					'user_name' => Lang::_('user_guest'),
					'user_groupid' => Config::get('user_guest_gid'),
					'user_state' => 0
				);
			}
			return self::$userinfo;
		}else{
			if(preg_match( '/^[0-9]+$/', $uid)) {
				$sql_where = 'WHERE `user_id` = ?';
			}else{
				$sql_where = 'WHERE `user_name` = ?';
			}
			$db = DB::get_instance();
			$db->select('*')->from('user')->sql_add($sql_where, $uid);
			$userinfo = $db->get();
			if($userinfo == NULL) {
				return FALSE;
			}
			$userinfo = $userinfo[0];

			//根据审核情况重置用户组ID
			if($userinfo['user_emailvalid'] == 0 && Config::get('user_emailvalid')) {
				$userinfo['user_groupid'] = Config::get('user_unvalid_gid');
			}
			if($userinfo['user_adminvalid'] == 0 && Config::get('user_adminvalid')) {
				$userinfo['user_groupid'] = Config::get('user_unvalid_gid');
			}

			$db->select('acl_key, uacl_value, acl_type, uacl_type')->from('acl')->from('user_acl');
			$db->sql_add('WHERE `uacl_id` = `acl_id` AND `uacl_uid` = ?', $userinfo['user_id']);
			$uacl = $db->get();
			if($uacl != NULL) {
				foreach ($uacl as $row) {
					$userinfo['acl'][$row['acl_key']] = ($row['uacl_type'] == 1) ? FALSE : $row['uacl_value'];
				}
			}
			return $userinfo;
		}
	}

	/**
	 * 读取用户组信息
	 * @param int $gid 用户组ID
	 * @return array
	 */
	public function get_group($gid) {
		if(empty($gid)) {
			return FALSE;
		}
		$ginfo = Cache::get('group/'.$gid);
		if($ginfo == FALSE) {
			$db = DB::get_instance();
			$db->select('*')->from('group')->sql_add('WHERE `group_id` = ?', $gid);
			$ginfo = $db->get();
			if($ginfo == NULL) {
				return FALSE;
			}
			$ginfo = $ginfo[0];
			$db->select('acl_key, gacl_value, acl_type, gacl_type')->from('acl')->from('group_acl');
			$db->sql_add('WHERE `gacl_id` = `acl_id` AND `gacl_gid` = ?', $gid);

			$gacl = $db->get();
			if($gacl != NULL) {
				foreach ($gacl as $row) {
					$ginfo['acl'][$row['acl_key']] = ($row['gacl_type'] == 1) ? FALSE : $row['gacl_value'];
				}
			}
			Cache::set('group/'.$gid, $ginfo);
		}
		return $ginfo;
	}

	/**
	 * 读取一个用户权限验证
	 * @param string $aclkey 权限属性关键码
	 * @param string $defalut 默认值
	 * @return mixed
	 */
	public function get_auth($aclkey, $defalut = FALSE) {
		if(is_null(self::$userinfo)) {
			$this->get_user();
		}
		$gid = self::$userinfo['user_groupid'];
		$ginfo = $this->get_group($gid);
		$result = is_null(self::$userinfo['acl'][$aclkey]) ? $ginfo['acl'][$aclkey] : self::$userinfo['acl'][$aclkey];
		if(is_null($result)) {
			return $defalut;
		}
		return $result;
	}

	/**
	 * 检查是否为管理组成员
	 * @return bool
	 */
	public function check_admin() {
		if(is_null(self::$userinfo)) {
			$this->get_user();
		}
		if(self::$userinfo['user_isadmin'] == TRUE) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	/**
	 * 检查当前用户是否已经登录
	 * @return bool
	 */
	public function check_login() {
		if(is_null(self::$userinfo)) {
			$this->get_user();
		}
		if(self::$userinfo['user_groupid'] == Config::get('user_guest_gid')) {
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * 用户登录
	 * @param string $username 用户名
	 * @param string $password 密码
	 * @return bool
	 */
	public function login($username, $password, $admin_login = FALSE) {
		if($username == '' || $password == '') {
			$this->msg = Lang::_('user_name_or_pass_not_null');
			return FALSE;
		}

		$password = (strlen($password) != 32) ? md5($password) : $password;

		$userinfo = $this->get_user($username);

		if($userinfo == FALSE) {
			$this->msg = Lang::_('user_not_exisit');
			return FALSE;
		}

		if($userinfo['user_pass'] != $password) {
			$this->msg = Lang::_('user_passwd_wrong');
			return FALSE;
		}

		$db = DB::get_instance();
		$db->sql_add('WHERE `user_id` = ?', $userinfo['user_id']);
		$db->update('user', array('user_lastlogintime' => time(), 'user_lastloginip' => get_ip()));

		//判断是否是管理员登录
		$ginfo = $this->get_group($userinfo['user_groupid']);

		if($ginfo['group_isadmin'] == 1 && $admin_login) {
			$userinfo['user_isadmin'] = TRUE;
		}elseif($ginfo['group_isadmin'] != 1 && $admin_login){
			$this->msg = Lang::_('user_not_admin');
			return FALSE;
		}else{
			$userinfo['user_isadmin'] = FALSE;
		}

		Session::set('user', $userinfo);
		return TRUE;
	}

	/**
	 * 退出用户登录
	 * @return bool
	 */
	public function logout() {
		Session::clear('user');
		return TRUE;
	}

	/**
	 * 检查用户名是否已经存在
	 * @param string $uname
	 * @return mixed
	 */
	public static function check_username($uname) {
		$msg = Lang::_('user_name_exisited');
		$db = DB::get_instance();
		$db->select('user_id')->from('user')->sql_add('WHERE `user_name` = ?', $uname);
		$userinfo = $db->get();
		if($userinfo != NULL) {
			return $msg;
		}
		return FALSE;
	}

	/**
	 * 取得邮箱验证码
	 * @param int $uid
	 * @return string
	 */
	private function get_emailvalid_code($uid) {
		if(!preg_match( '/^[0-9]+$/', $uid)) {
			$this->msg = Lang::_('user_input_param_error');
			return FALSE;
		}
		$uinfo = $this->get_user($uid);
		if($uinfo == NULL) {
			$this->msg = Lang::_('user_input_param_error');
			return FALSE;
		}
		return substr(md5($uinfo['user_name'].SAFETY_STRING.$uinfo['user_regtime']), 6, 12);
	}

	/**
	 * 发送验证邮件
	 * @param int $uid
	 */
	public function send_valid_mail($uid) {
		$uinfo = $this->get_user($uid);
		$viewdata = array(
			'validcode' => self::get_emailvalid_code($uid),
			'username' => $uinfo['user_name'],
			'email' => $uinfo['user_email'],
			'uid' => $uid
		);
		
		View::set_title(Lang::_('user_validemail_title').' - '.Config::get('site_name'));
		$content = View::load('system/validmail', $viewdata, TRUE);

		$email = new Email();
		$email->set_to($uinfo['user_email'], $uinfo['user_name']);
		$email->set_subject(Lang::_('user_validemail_title').' - '.Config::get('site_name'));
		$email->set_content($content);
		return $email->send();
	}

	/**
	 * 新用户注册
	 * @param array $u 传入信息数组
	 * @return bool
	 */
	public function register($u) {
		if(empty($u) || !is_array($u)) {
			$this->msg = Lang::_('user_input_param_error');
			return FALSE;
		}
		$u['user_groupid'] = Config::get('user_default_gid');
		$u['user_regtime'] = time();
		$u['user_regip'] = get_ip();
		$db = DB::get_instance();
		$uid = $db->insert('user', $u);
		return TRUE;
	}
}
/* End of this file */