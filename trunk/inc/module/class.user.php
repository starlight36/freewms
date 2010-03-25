<?php
/*
 * USER模型
 * 为系统提供基本的用户接口
 */
class mod_user extends module {

	public $msg = NULL;
	public static $userinfo = array();
	public static $is_admin = FALSE;
	public static $user_power = array();
	public static $admin_power = array();

	public function  __construct() {
		parent::__construct();
	}

	/**
	 * 用户注册
	 * @param array $userdata
	 * @return bool
	 */
	public function register($userdata) {
		if (!is_array($userdata)) {
			$this->msg = 'No input value';
			return FALSE;
		}
		if($this->config->get('site/user/reg_valid') == 'none') {
			$userdata['state'] = 0;
		}else{
			$userdata['state'] = 1;
		}
		$data = array(
				'user_name' => $userdata['name'],
				'user_pass' => $userdata['pass'],
				'user_groupid' => 1,
				'user_regtime' => now(),
				'user_regip' => $this->in->ip(),
				'user_state' => $userdata['state']
			);
		$this->db->insert('user', $data);
		return $this->db->insert_id();
	}

	/**
	 * 验证邮件激活
	 * @param string $uname 用户名
	 * @param string $key 验证key
	 * @return bool
	 */
	public function valid_email($uname, $key = NULL) {
		if(empty($uname) || empty($key)) {
			$this->msg = '没有任何输入数据.';
			return FALSE;
		}
		if($this->config->get('site/reg_valid') == 'email') {
			if($key == $this->get_email_vcode($uname)) {
				$this->db->where('user_name', $uname);
				$this->db->where('user_state', 1);
				$this->db->set('user_state', 0);
				$this->db->update('user');
				return TRUE;
			}else{
				$this->msg = '邮箱激活码不正确,未能完成邮箱验证.';
				return FALSE;
			}
		}else{
			$this->msg = '系统没有开启邮箱验证.';
			return FALSE;
		}
	}

	/**
	 * 取得邮箱验证码
	 * @param string $uname
	 * @return string
	 */
	public function get_email_vcode($uname) {
		$userinfo = $this->get_user_info($uname);
		if($userinfo == FALSE) {
			$this->msg = '没找到此用户.';
			return FALSE;
		}else{
			$key = substr(md5($userinfo['name'].SAFETY_STRING.$userinfo['regtime']), 12);
			return $key;
		}
	}

	/**
	 * 读取用户信息
	 * @param unknow $str
	 * @return bool/array
	 */
	public function get_user_info($str = NULL) {
		if(is_null($str)){
			$userinfo = $this->session->get('user');
			if(empty($userinfo)) {
				$this->get_group();
				$userinfo['name'] = '游客';
				$userinfo['state'] = 3;
				$this->session->set('user', $userinfo);
			}
			$this->userinfo = $userinfo;
			return $userinfo;
		}elseif(is_array($str)) {
			$this->db->where($str);
		}elseif(is_numeric($str)) {
			$this->db->where('user_id', $str);
		}elseif(is_string($str)) {
			$this->db->where('user_name', $str);
		}else{
			return FALSE;
		}
		$q_userinfo = $this->db->get('user');
		if ($q_userinfo->num_rows() == 1) {
			$userinfo = $q_userinfo->row_array();
		}else{
			return FALSE;
		}
		foreach($user_array as $k => $v) {
			$k = substr($k, 5);
			$temp[$k] = $v;
		}
		return $temp;
	}

	/**
	 * 读取用户组信息
	 * @param int $gid
	 * @param bool $is_curr_user
	 * @return bool/array
	 */
	public function get_group($gid = 1, $is_curr_user = TRUE) {
		if(empty($gid) || !is_numeric($gid)) {
			return FALSE;
		}
		$group_array = cache_get('group_'.$gid);
		if($group_array === FALSE) {
			$this->db->where('group_id', $gid);
			$q_group = $this->db->get('group');
			if ($q_group->num_rows() == 1) {
				$group_array = $q_group->row_array();
			}else{
				return FALSE;
			}
			$group_array['name'] = $group_array['group_name'];
			$group_array['isadmin'] = $group_array['group_isadmin'];
			$group_array['admin_power'] = $group_array['group_admin_power'];
			$group_array['user_power'] = $group_array['group_user_power'];
			unset($group_array['group_name'], $group_array['group_isadmin'],
				$group_array['group_admin_power'], $group_array['group_user_power']);
			cache_put('group_'.$gid, $group_array);
		}
		if($is_curr_user == TRUE) {
			$this->is_admin = $group_array['isadmin'];
			$this->user_power = $group_array['admin_power'];
			$this->admin_power = $group_array['user_power'];
		}
		return $group_array;
	}

	/**
	 * 检查用户对控制器动作的访问权
	 * @param string $powertype
	 * @param string $c
	 * @param string $a
	 * @return bool
	 */
	public function check_power($powertype = 'user', $c = NULL, $a = NULL) {
		if(is_null($c)|| is_null($a)) {
			$c = $this->in->controller();
			$a = $this->in->action();
		}
		$key = $c.'/'.$a;
		if(empty($this->user_power) && empty($this->admin_power)) {
			$this->get_user_info();
		}
		if($powertype == 'user') {
			if($this->user_power[$key] == TRUE) {
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			if($this->admin_power[$key] == TRUE) {
				return TRUE;
			}else{
				return FALSE;
			}
		}
	}

	/**
	 * 保存用户信息
	 * @param string $data
	 * @param array $condition
	 * @return bool
	 */
	public function update($data, $condition = NULL) {
		if(is_null($condition)) {
			$userinfo = $this->session->get('user');
			if(empty($userinfo)) {
				return FALSE;
			}else{
				$this->db->where('user_id', $userinfo['id']);
			}
		}elseif(is_array($condition)){
			$this->db->where_in('user_id', $condition);
		}else{
			$this->db->where('user_id', $condition);
		}
		foreach($data as $k => $v) {
			$k = 'user_'.$k;
			$temp[$k] = $v;
		}
		$this->db->set($data);
		return $this->db->update('user');
	}
}
/* End of the file */