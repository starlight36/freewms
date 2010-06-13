<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

class Form {
	private static $post = NULL;
	private static $fields = NULL;
	private static $errors = NULL;

	public function  __construct(&$postarray) {
		Lang::load('form');
		if(is_array($postarray) && !empty($postarray)) {
			self::$post =& $postarray;
		}
	}

	public function  __destruct() {
		self::$errors = NULL;
		self::$fields = NULL;
	}

	/**
	 * 设置一个字段过滤
	 * @param string $field 字段名
	 * @param string $lable 字段标签
	 * @param string $rules 验证规则
	 * @param string $filters  过滤规则
	 */
	public function set_field($field, $lable = NULL, $rules = NULL, $filters = NULL) {
		if(is_array($field)) {
			foreach($field as $key => $value) {
				$this->set_field($key, $value['lable'], $value['rules'], $value['filters']);
			}
		}else{
			$lable = empty($lable) ? $field : $lable;
			$rules = explode('|', $rules);
			$filters = explode('|', $filters);
			self::$fields[$field] = array(
				'field' => $field,
				'label' => $lable,
				'rules' => $rules,
				'filters' => $filters,
				'value' => self::$post[$field]
			);
		}
	}

	/**
	 * 检查一个提交是否为POST方法
	 * @return bool
	 */
	public function is_post() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	/**
	 * 执行表单验证
	 * @return bool
	 */
	public function run() {
		if(count(self::$post) == 0 || $_SERVER['REQUEST_METHOD'] != 'POST') {
			return FALSE;
		}
		if(count(self::$fields) == 0) {
			return FALSE;
		}
		self::$post = NULL;
		foreach(self::$fields as $row) {
			//执行表单验证
			if(empty($row['rules'])) {
				continue;
			}
			foreach($row['rules'] as $rule) {
				$param = FALSE;
				if(preg_match("/(.*?)\\[(.*)\\]/", $rule, $match)) {
					$rule	= $match[1];
					$param	= $match[2];
				}
				$is_method = FALSE;
				if(!function_exists($rule)) {
					if(method_exists($this, $rule)) {
						$is_method = TRUE;
					}else{
						continue;
					}
				}
				if($is_method == TRUE) {
					$rst = $this->$rule($row['value'], $param);
				}else{
					$rst = $rule($row['value'], $param);
				}
				if($rst != FALSE) {
					$rst = sprintf($rst, $row['label']);
					self::$errors[$row['field']] = $rst;
					break;
				}
			}
			//执行表单过滤
			if(empty($row['filters'])) {
				continue;
			}
			$value = $row['value'];
			foreach($row['filters'] as $filter) {
				if(function_exists($filter)) {
					$value = $filter($value);
				}
			}
			self::$post[$row['field']] = $value;
		}
		if(count(self::$errors) > 0) {
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * 取得所有错误消息
	 * @return mixed
	 */
	public static function get_all_errors($type = NULL) {
		if(count(self::$errors) > 0) {
			if($type == NULL) {
				return array_values(self::$errors);
			}else{
				return implode($type, array_values(self::$errors));
			}
		}
		return FALSE;
	}

	/**
	 * 取得一个字段的验证出错信息
	 * @param string $field
	 * @return mixed
	 */
	public static function get_error($field, $prefix = NULL, $surfix = NULL) {
		if(!empty(self::$errors[$field])) {
			return $prefix.self::$errors[$field].$surfix;
		}else{
			return NULL;
		}
	}

	/**
	 * 取得一个字段的值
	 * @param string $field
	 * @param string $default
	 * @return string
	 */
	public static function set_value($field, $default = NULL) {
		if(is_null(self::$post[$field])) {
			return $default;
		}else{
			return self::$post[$field];
		}
	}

	//----------------------------------------------------------------
	// 我是华丽的分割线    以下部分是内置验证方法
	//----------------------------------------------------------------

	/**
	 * 表单验证函数-验证是否存在
	 * @param string/array $str 输入的值
	 * @return mixed
	 */
	private function required($str) {
		$msg = Lang::_('form_required');
		if (!is_array($str)) {
			return (trim($str) == '') ? $msg : FALSE;
		}else{
			return (empty($str)) ? $msg : FALSE;
		}
	}

	/**
	 * 检查是否和字段匹配
	 * @param string $str 输入的值
	 * @param string $field 字段名称
	 * @return bool
	 */
	private function matches($str, $field) {
		$fieldname = empty(self::$fields[$field]['label']) ? $field : self::$fields[$field]['label'];
		$msg = str_replace('$1', $fieldname, Lang::_('form_matches'));
		$field = self::$fields[$field]['value'];
		return ($str !== $field) ? $msg : FALSE;
	}

	/**
	 * 检查字段的最小长度
	 * @param string $str 输入字串
	 * @param string $val 输入长度
	 * @return bool
	 */
	private function min_length($str, $val) {
		$msg = str_replace('$1', $val, Lang::_('form_min_length'));
		if(function_exists('mb_strlen')) {
			return (mb_strlen($str) < $val) ? $msg : FALSE;
		}
		return (strlen($str) < $val) ? $msg : FALSE;
	}

	/**
	 * 检查字段的最大长度
	 * @param string $str 输入字串
	 * @param string $val 输入长度
	 * @return bool
	 */
	private function max_length($str, $val) {
		$msg = str_replace('$1', $val, Lang::_('form_max_length'));
		if(function_exists('mb_strlen')) {
			return (mb_strlen($str) > $val) ? $msg : FALSE;
		}
		return (strlen($str) > $val) ? $msg : FALSE;
	}

	/**
	 * 检查数字字段的最大值
	 * @param string $str 输入字串
	 * @param string $val 最大值
	 * @return bool
	 */
	private function max_num($str, $val) {
		$msg = str_replace('$1', $val, Lang::_('form_max_num'));
		if($str > $val) {
			return $msg;
		}else{
			return FALSE;
		}
	}

	/**
	 * 检查数字字段的最小值
	 * @param string $str 输入字串
	 * @param string $val 最小值
	 * @return bool
	 */
	private function min_num($str, $val) {
		$msg = str_replace('$1', $val, Lang::_('form_min_num'));
		if($str < $val) {
			return $msg;
		}else{
			return FALSE;
		}
	}

	/**
	 * 检查输入是否和给定长度相等
	 * @param string $str 输入
	 * @param ini $val 给定长度
	 * @return bool
	 */
	private function exact_length($str, $val) {
		$msg = str_replace('$1', $val, Lang::_('form_exact_length'));
		if (preg_match("/[^0-9]/", $val)) {
			return $msg;
		}
		if (function_exists('mb_strlen')) {
			return (mb_strlen($str) != $val) ? $msg : FALSE;
		}
		return (strlen($str) != $val) ? $msg : FALSE;
	}

	/**
	 * 检查Email格式是否正确
	 * @param string $str 输入字符串
	 * @return bool
	 */
	private function valid_email($str) {
		$msg = Lang::_('form_valid_email');
		return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? $msg : FALSE;
	}


	/**
	 * 检查email组
	 * @param string $str 输入
	 * @return bool
	 */
	private function valid_emails($str) {
		$msg = Lang::_('form_valid_emails');
		if(strpos($str, ',') === FALSE) {
			return $this->valid_email(trim($str));
		}
		foreach(explode(',', $str) as $email) {
			if(trim($email) != '' && $this->valid_email(trim($email)) !== FALSE) {
				return $msg;
			}
		}
		return FALSE;
	}

	/**
	 * 检查是否为合法的IP地址
	 * @param string $ip
	 * @return bool
	 */
	private function valid_ip($ip) {
		$msg = Lang::_('form_valid_ip');
		$ip_segments = explode('.', $ip);
		if (count($ip_segments) != 4) {
			return $msg;
		}
		if ($ip_segments[0][0] == '0') {
			return $msg;
		}
		foreach ($ip_segments as $segment) {
			if ($segment == '' || preg_match("/[^0-9]/", $segment) || $segment > 255 || strlen($segment) > 3) {
				return $msg;
			}
		}
		return FALSE;
	}

	/**
	 * 检查一个安全的名称, 用于目录文件名检查
	 * @param string $str 输入
	 * @return bool
	 */
	private function dir_name($str) {
		$msg = Lang::_('form_dir_name');
		return (!preg_match("/^([a-z0-9_])+$/i", $str)) ? $msg : FALSE;
	}

	/**
	 * 检查一个正确的用户名格式
	 * @param string $str 输入
	 * @return bool
	 */
	private function user_name($str) {
		$msg = Lang::_('form_user_name');
		return (!preg_match('/^[\x{4e00}-\x{9fa5}a-z_A-Z0-9]+$/u', $str)) ? $msg : FALSE;
	}


	/**
	 * 检查是否为数字形式
	 * @param string $str 输入
	 * @return bool
	 */
	private function numeric($str) {
		$msg = Lang::_('form_numeric');
		return preg_match('/^[\-+]?[0-9]*\.?[0-9]+$/', $str) ? FALSE : $msg;
	}

	/**
	 * 检查是为整数形式
	 * @param string $str 输入
	 * @return bool
	 */
	private function integer($str) {
		$msg = Lang::_('form_integer');
		return preg_match( '/^[\-+]?[0-9]+$/', $str) ? FALSE : $msg;
	}

	/**
	 * 检查是否为自然数
	 * @param string $str
	 * @return bool
	 */
	private function natural($str) {
		$msg = Lang::_('form_is_natural');
   		return (bool)preg_match('/^[0-9]+$/', $str) ? FALSE : $msg;
    }

	/**
	 * 检查是否符合正则表达式规则
	 */
	private function regex($str, $pattern) {
		$msg = Lang::_('form_regex');
		return (bool)preg_match('/'.$pattern.'/i', $str) ? FALSE : $msg;
	}

	/**
	 * 检查验证码是否正确
	 */
	private function valid_code($str) {
		$msg = Lang::_('form_valid_code');
		$code = Session::flash('valid_code');
		if(empty($code)) {
			return $msg;
		}else{
			if(strtolower($code) != strtolower($str)) {
				return $msg;
			}
		}
		return FALSE;
	}
}
/* End of this file */