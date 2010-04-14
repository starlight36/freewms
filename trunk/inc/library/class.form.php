<?php
/*
 * 表单类
 * 提供表单验证等相关
 */
class cls_form {
	private $in = NULL;
	private $lang = NULL;
	private $field_data = array();
	private $error_messages = array();
	private $error_array = array();
	private $error_prefix = '<p>';
	private $error_suffix = '</p>';
	private $postdata = NULL;
	
	public function  __construct() {
		//加载输入类
		$this->in =& load_class('in');
		$this->lang =& load_class('lang');
		$this->lang->load('system/form');
		$this->postdata =& $this->in->post;
		$this->load_rules();
	}

	/**
	 * 从配置文件加载一个验证规则
	 * @param string $rulekey 验证规则关键字
	 */
	public function load_rules($rulekey = NULL) {
		if(empty($rulekey)) {
			$rule_file = DIR_ROOT.'config/form/'.$this->in->controller().'/'.$this->in->action().'.php';
		}else{
			$rule_file = DIR_ROOT.'config/form/'.$rulekey.'.php';
		}
		if(is_file($rule_file)) {
			@include_once $rule_file;
			if(!empty($form_rule)) {
				$this->set_rule($form_rule);
			}
		}
	}

	/**
	 * 设置一条或一组表单验证规则
	 * @param string $field 字段PATH
	 * @param string $label 字段提示标签
	 * @param string $rules 规则字符串
	 * @return bool
	 */
	public function set_rule($field, $label = NULL, $rules = NULL, $filter = NULL) {
		if(is_array($field)) {
			foreach ($field as $row) {
				if (!isset($row['field']) || !isset($row['rules'])) {
						continue;
				}
				$label = (!isset($row['label'])) ? $row['field'] : $row['label'];
				$this->set_rule($row['field'], $label, $row['rules'], $row['filter']);
			}
		}else{
			$label = ($label == '') ? $field : $label;
			$this->field_data[$field] = array(
				'field' => $field,
				'label' => $label,
				'value' => $this->in->post($field),
				'rule' => explode('|', $rules),
				'filter' => explode('|', $filter)
			);
		}
		return TRUE;
	}

	/**
	 * 为验证回调函数提供设置消息的接口
	 * @param string $lang 回调函数名
	 * @param string $val 消息内容
	 */
	public function set_message($lang, $val = NULL) {
		if(!is_array($lang)) {
			$lang = array($lang => $val);
		}
		$this->error_messages = array_merge($this->error_messages, $lang);
	}

	/**
	 * 设置全局错误定界符
	 * @param string $prefix 开始标记
	 * @param string $suffix 介绍标记
	 */
	public function set_error_delimiters($prefix = '<p>', $suffix = '</p>') {
		$this->error_prefix = $prefix;
		$this->error_suffix = $suffix;
	}

	/**
	 * 取得一个字段的错误消息
	 * @param string $field 字段名
	 * @param string $prefix 限定符开始
	 * @param string $suffix 限定符结束
	 * @return string
	 */
	public function error($field = NULL, $prefix = NULL, $suffix = NULL) {
		if(empty($this->error_array[$field])) {
			return FALSE;
		}
		if($prefix == NULL) {
			$prefix = $this->error_prefix;
		}
		if($suffix == NULL) {
			$suffix = $this->error_suffix;
		}
		return $prefix.$this->error_array[$field].$suffix;
	}

	/**
	 * 一次性读取全部错误信息
	 * @param string $prefix 错误信息条目限定符(开始)
	 * @param string $suffix 错误信息条目限定符(结束)
	 * @return string
	 */
	public function error_string($prefix = NULL, $suffix = NULL) {
		if(count($this->error_array) === 0) {
			return FALSE;
		}
		if($prefix == NULL) {
			$prefix = $this->error_prefix;
		}
		if($suffix == NULL) {
			$suffix = $this->error_suffix;
		}
		$str = NULL;
		foreach($this->error_array as $val) {
			if($val != '') {
				$str .= $prefix.$val.$suffix;
			}
		}
		return $str;
	}

	/**
	 * 执行表单验证器
	 * @return bool
	 */
	public function run() {
		if(count($_POST) == 0 || $_SERVER['REQUEST_METHOD'] != 'POST') {
			return FALSE;
		}
		if(count($this->field_data) == 0) {
			return FALSE;
		}
		foreach($this->field_data as $row) {
			$value =& path_array($this->postdata, $row['field']);
			//执行表单验证
			if(empty($row['rule'])) {
				continue;
			}
			foreach($row['rule'] as $rule) {
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
				if($param == FALSE) {
					if($is_method == TRUE) {
						$rst = $this->$rule($value);
					}else{
						$rst = $rule($value);
					}
					if($rst != TRUE) {
						$err_msg = sprintf($this->error_messages[$rule], $row['label']);
						$this->error_array[$row['field']] = $err_msg;
						break;
					}
				}else{
					if($is_method == TRUE) {
						$rst = $this->$rule($value, $param);
					}else{
						$rst = $rule($value, $param);
					}
					if($rst != TRUE) {
						$param = isset($this->field_data[$param])?$this->field_data[$param]['label']:$param;
						$err_msg = sprintf($this->error_messages[$rule], $row['label'], $param);
						$this->error_array[$row['field']] = $err_msg;
						break;
					}
				}
			}
			//执行表单过滤
			if(empty($row['filter'])) {
				continue;
			}
			foreach($row['filter'] as $filter) {
				if(function_exists($filter)) {
					$value = $filter($value);
				}
			}
		}
		if(count($this->error_array) > 0) {
			return FALSE;
		}else{
			return TRUE;
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
	 * 设置一个表单的值
	 * @param string $field 表单字段
	 * @param string $default 默认值
	 * @return string
	 */
	public function set_value($field = '', $default = '') {
		$value = $this->field_data[$field]['value'];
		if(empty($value)) {
			return $default;
		}
		return $value;
	}

	/**
	 * 表单验证函数-验证是否存在
	 * @param string/array $str 输入的值
	 * @return bool
	 */
	private function required($str) {
		$this->set_message(__FUNCTION__, $this->lang->get('form_rule/required'));
		if (!is_array($str)) {
			return (trim($str) == '') ? FALSE : TRUE;
		}else{
			return (!empty($str));
		}
	}

	/**
	 * 检查是否和字段匹配
	 * @param string $str 输入的值
	 * @param string $field 字段名称
	 * @return bool
	 */
	private function matches($str, $field) {
		$this->set_message(__FUNCTION__, '%s和%s不匹配.');
		if(!isset($str) || !isset($field)) {
			return FALSE;
		}
		$field = $this->in->post($field);
		return ($str !== $field) ? FALSE : TRUE;
	}

	/**
	 * 检查字段的最小长度
	 * @param string $str 输入字串
	 * @param string $val 输入长度
	 * @return bool
	 */
	private function min_length($str, $val) {
		$this->set_message(__FUNCTION__, '%s必须大于%s个字符.');
		if(preg_match("/[^0-9]/", $val)) {
			return FALSE;
		}
		if(function_exists('mb_strlen')) {
			return (mb_strlen($str) < $val) ? FALSE : TRUE;
		}
		return (strlen($str) < $val) ? FALSE : TRUE;
	}

		/**
	 * 检查字段的最大长度
	 * @param string $str 输入字串
	 * @param string $val 输入长度
	 * @return bool
	 */
	private function max_length($str, $val) {
		$this->set_message(__FUNCTION__, '%s必须小于%s个字符.');
		if (preg_match("/[^0-9]/", $val)) {
			return FALSE;
		}
		if (function_exists('mb_strlen')) {
			return (mb_strlen($str) > $val) ? FALSE : TRUE;
		}
		return (strlen($str) > $val) ? FALSE : TRUE;
	}

	/**
	 * 检查数字字段的最大值
	 * @param string $str 输入字串
	 * @param string $val 最大值
	 * @return bool
	 */
	private function max_num($str, $val) {
		$this->set_message(__FUNCTION__, '%s不能大于%s.');
		if (preg_match("/[^0-9]/", $val)) {
			return FALSE;
		}
		return ($s > $val) ? FALSE : TRUE;
	}

	/**
	 * 检查数字字段的最小值
	 * @param string $str 输入字串
	 * @param string $val 最小值
	 * @return bool
	 */
	private function min_num($str, $val) {
		$this->set_message(__FUNCTION__, '%s不能小于%s.');
		if (preg_match("/[^0-9]/", $val)) {
			return FALSE;
		}
		return ($s < $val) ? FALSE : TRUE;
	}

	/**
	 * 检查输入是否和给定长度相等
	 * @param string $str 输入
	 * @param ini $val 给定长度
	 * @return bool
	 */
	private function exact_length($str, $val) {
		$this->set_message(__FUNCTION__, '%s必须为%s个字符.');
		if (preg_match("/[^0-9]/", $val)) {
			return FALSE;
		}
		if (function_exists('mb_strlen')) {
			return (mb_strlen($str) != $val) ? FALSE : TRUE;
		}
		return (strlen($str) != $val) ? FALSE : TRUE;
	}

	/**
	 * 检查Email格式是否正确
	 * @param string $str 输入字符串
	 * @return bool
	 */
	private function valid_email($str) {
		$this->set_message(__FUNCTION__, '%s必须是一个合法的Email地址.');
		return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
	}


	/**
	 * 检查email组
	 * @param string $str 输入
	 * @return bool
	 */
	private function valid_emails($str) {
		$this->set_message(__FUNCTION__, '%s必须一个合法的Email地址组.');
		if(strpos($str, ',') === FALSE) {
			return $this->valid_email(trim($str));
		}
		foreach(explode(',', $str) as $email) {
			if(trim($email) != '' && $this->valid_email(trim($email)) === FALSE) {
				return FALSE;
			}
		}
		return TRUE;
	}

	/**
	 * 检查是否为合法的IP地址
	 * @param string $ip
	 * @return bool
	 */
	private function valid_ip($ip) {
		$this->set_message(__FUNCTION__, '%s必须是一个有效的IP地址.');
		$ip_segments = explode('.', $ip);
		if (count($ip_segments) != 4) {
			return FALSE;
		}
		if ($ip_segments[0][0] == '0') {
			return FALSE;
		}
		foreach ($ip_segments as $segment) {
			if ($segment == '' || preg_match("/[^0-9]/", $segment) || $segment > 255 || strlen($segment) > 3) {
				return FALSE;
			}
		}
		return TRUE;
	}

	/**
	 * 检查一个安全的名称, 用于目录文件名检查
	 * @param string $str 输入
	 * @return bool
	 */
	private function dir_name($str) {
		$this->set_message(__FUNCTION__, '%s中只能包含字母数字和下划线.');
		return (!preg_match("/^([a-z0-9_])+$/i", $str)) ? FALSE : TRUE;
	}

	/**
	 * 检查是否为数字形式
	 * @param string $str 输入
	 * @return bool
	 */
	private function numeric($str) {
		$this->set_message(__FUNCTION__, '%s必须是一个合法的数字形式.');
		return (bool)preg_match('/^[\-+]?[0-9]*\.?[0-9]+$/', $str);
	}

	/**
	 * 检查是为整数形式
	 * @param string $str 输入
	 * @return bool
	 */
	private function integer($str) {
		$this->set_message(__FUNCTION__, '%s必须是一个合法的整数形式.');
		return (bool)preg_match( '/^[\-+]?[0-9]+$/', $str);
	}

	/**
	 * 检查是否为自然数
	 * @param string $str
	 * @return bool
	 */
	private function is_natural($str) {
		$this->set_message(__FUNCTION__, '%s必须是一个合法的自然数形式.');
   		return (bool)preg_match('/^[0-9]+$/', $str);
    }
}