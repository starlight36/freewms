<?php
/*
 * 表单类
 * 提供表单验证等相关
 */
class cls_form {
	private $in = NULL;
	private $field_data = array();
	private $error_messages = array();
	private $error_array = array();
	private $error_prefix = '<p>';
	private $error_suffix = '</p>';
	private $postdata = NULL;
	
	public function  __construct() {
		//加载输入类
		$this->in =& load_class('in');
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
		$this->set_message(__FUNCTION__, '%s必须填写.');
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

}