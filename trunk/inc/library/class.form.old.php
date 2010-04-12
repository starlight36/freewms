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

	public function  __construct() {
		$this->in =& load_class('in');
		$config_file = DIR_ROOT.'config/form_rule.php';
		if(is_file($config_file)) {
			@include_once $config_file;
			if(is_array($form_rule)) {
				$form_rule = $form_rule[$this->in->controller().'/'.$this->in->action()];
				$this->set_rule($form_rule);
			}
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
	 * 设置表单验证规则
	 * @param string/array $field 表单字段
	 * @param string $label 表单名称
	 * @param string $rules 表单规则
	 * @return bool
	 */
	public function set_rule($field, $label = NULL, $rules = NULL) {
		if(is_array($field)) {
			foreach ($field as $row) {
				if (!isset($row['field']) || !isset($row['rules'])) {
						continue;
				}
				$label = (!isset($row['label'])) ? $row['field'] : $row['label'];
				$this->set_rule($row['field'], $label, $row['rules']);
			}
		}else{
			$label = ($label == '') ? $field : $label;
			if (strpos($field, '[') !== FALSE && preg_match_all('/\[(.*?)\]/', $field, $matches)) {
				$x = explode('[', $field);
				$indexes[] = current($x);
				for ($i = 0; $i < count($matches['0']); $i++) {
					if ($matches['1'][$i] != '') {
						$indexes[] = $matches['1'][$i];
					}
				}
				$is_array = TRUE;
			}else{
				$indexes = array();
				$is_array = FALSE;
			}
			$this->field_data[$field] = array(
				'field' => $field,
				'label' => $label,
				'rules' => $rules,
				'is_array' => $is_array,
				'keys' => $indexes,
				'postdata'=> NULL,
				'error' => ''
			);
		}
		return TRUE;
	}

	/**
	 * 为用户自己的回调函数提供设置消息的接口
	 * @param string $lang 回调函数名
	 * @param string $val 消息内容
	 */
	public function set_message($lang, $val = '') {
		if(!is_array($lang)) {
			$lang = array($lang => $val);
		}
		$this->error_messages = array_merge($this->error_messages, $lang);
	}

	/**
	 * 设置错误限定符
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
	public function error($field = '', $prefix = '', $suffix = '') {
		if(!isset($this->field_data[$field]['error']) || $this->field_data[$field]['error'] == '') {
			return '';
		}
		if($prefix == '') {
			$prefix = $this->error_prefix;
		}
		if($suffix == '') {
			$suffix = $this->error_suffix;
		}
		return $prefix.$this->field_data[$field]['error'].$suffix;
	}

	/**
	 * 一次性读取全部错误信息
	 * @param string $prefix 错误信息条目限定符(开始)
	 * @param string $suffix 错误信息条目限定符(结束)
	 * @return string
	 */
	public function error_string($prefix = '', $suffix = '\n') {
		if(count($this->_error_array) === 0) {
			return '';
		}
		if($prefix == '') {
			$prefix = $this->_error_prefix;
		}
		if($suffix == '') {
			$suffix = $this->_error_suffix;
		}
		$str = '';
		foreach($this->_error_array as $val) {
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
		foreach($this->field_data as $field => $row) {
			if($row['is_array'] == TRUE) {
				$this->field_data[$field]['postdata'] = $this->reduce_array($_POST, $row['keys']);
			}else{
				if(isset($_POST[$field]) && $_POST[$field] != "") {
					$this->field_data[$field]['postdata'] = $_POST[$field];
				}
			}
			$this->execute($row, explode('|', $row['rules']), $this->field_data[$field]['postdata']);
		}
		$total_errors = count($this->error_array);
		if($total_errors == 0) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * 从数组中读取值
	 * @param array $array 目标数组
	 * @param array $keys 键值路径
	 * @param array $i 路径起始序号
	 * @return unknow
	 */
	private function reduce_array($array, $keys, $i = 0) {
		if(is_array($array)) {
			if(isset($keys[$i])) {
				if(isset($array[$keys[$i]])) {
					$array = $this->reduce_array($array[$keys[$i]], $keys, ($i+1));
				}else{
					return NULL;
				}
			}else{
				return $array;
			}
		}
		return $array;
	}

	/**
	 * 表单验证执行器
	 * @param array $row 字段设置数组
	 * @param array $rules 字段规则数组
	 * @param string/array $postdata 字段内容
	 * @param int $cycles
	 * @return unknown
	 */
	private function execute($row, $rules, $postdata = NULL, $cycles = 0) {
		if(is_array($postdata)) {
			foreach ($postdata as $key => $val) {
				$this->execute($row, $rules, $val, $cycles);
				$cycles++;
			}
			return;
		}

		$callback = FALSE;
		if(!in_array('required', $rules) AND is_null($postdata)) {
			if(preg_match("/(callback_\w+)/", implode(' ', $rules), $match)) {
				$callback = TRUE;
				$rules = (array('1' => $match[1]));
			}else{
				return;
			}
		}
		if(is_null($postdata) && $callback == FALSE) {
			if(in_array('isset', $rules, TRUE) || in_array('required', $rules)) {
				$type = (in_array('required', $rules)) ? 'required' : 'isset';
				$line = "%s不能为空。";
				$message = sprintf($line, $row['label']);
				$this->field_data[$row['field']]['error'] = $message;
				if(!isset($this->error_array[$row['field']])) {
					$this->error_array[$row['field']] = $message;
				}
			}
			return;
		}
		foreach ($rules As $rule) {
			$in_array = FALSE;
			if($row['is_array'] == TRUE && is_array($this->field_data[$row['field']]['postdata'])) {
				if (!isset($this->field_data[$row['field']]['postdata'][$cycles])) {
					continue;
				}
				$postdata = $this->field_data[$row['field']]['postdata'][$cycles];
				$in_array = TRUE;
			}else{
				$postdata = $this->field_data[$row['field']]['postdata'];
			}
			$callback = FALSE;
			if(substr($rule, 0, 9) == 'callback_') {
				$rule = substr($rule, 9);
				$callback = TRUE;
			}
			$param = FALSE;
			if(preg_match("/(.*?)\\[(.*)\\]/", $rule, $match)) {
				$rule	= $match[1];
				$param	= $match[2];
			}
			if($callback === TRUE) {
				if(!function_exists($rule)) {
					continue;
				}
				$result = $rule($rule, $postdata, $param);
				if($in_array == TRUE) {
					$this->field_data[$row['field']]['postdata'][$cycles] = (is_bool($result)) ? $postdata : $result;
				}else{
					$this->field_data[$row['field']]['postdata'] = (is_bool($result)) ? $postdata : $result;
				}
				if(!in_array('required', $rules, TRUE) || $result !== FALSE) {
					continue;
				}
			}else{
				if (!method_exists($this, $rule)) {
					continue;
				}
				$result = $this->$rule($postdata, $param);
				if($in_array == TRUE) {
					$this->field_data[$row['field']]['postdata'][$cycles] = (is_bool($result)) ? $postdata : $result;
				}else{
					$this->field_data[$row['field']]['postdata'] = (is_bool($result)) ? $postdata : $result;
				}
			}
			if($result === FALSE) {
				$line = $this->error_messages[$rule];
			}
			if(isset($this->field_data[$param]) && isset($this->field_data[$param]['label'])) {
				$param = $this->field_data[$param]['label'];
			}
			$message = sprintf($line, $row['label'], $param);
			$this->field_data[$row['field']]['error'] = $message;
			if ( ! isset($this->error_array[$row['field']])) {
				$this->error_array[$row['field']] = $message;
			}
			return;
		}
	}

	/**
	 * 设置一个表单的值
	 * @param string $field 表单字段
	 * @param string $default 默认值
	 * @return string
	 */
	public function set_value($field = '', $default = '') {
		if(!isset($this->field_data[$field])) {
			return $default;
		}
		return $this->field_data[$field]['postdata'];
	}

	/**
	 * 设置一个SELECT的选中项
	 * @param string $field 字段名
	 * @param string $value 字段值
	 * @param string $default 默认选择
	 * @return string
	 */
	public function set_select($field = '', $value = '', $default = FALSE) {
		if(!isset($this->field_data[$field]) || ! isset($this->field_data[$field]['postdata'])) {
			if($default === TRUE && count($this->field_data) === 0) {
				return ' selected="selected"';
			}
			return '';
		}
		$field = $this->field_data[$field]['postdata'];
		if(is_array($field)) {
			if (!in_array($value, $field)) {
				return '';
			}
		}else{
			if(($field == '' || $value == '') || ($field != $value)) {
				return '';
			}
		}
		return ' selected="selected"';
	}

	/**
	 * 设置一个单选按钮的默认值
	 * @param string $field 字段名
	 * @param string $value 字段值
	 * @param string $default 默认选择
	 * @return string
	 */
	public function set_radio($field = '', $value = '', $default = FALSE) {
		if(!isset($this->field_data[$field]) || ! isset($this->field_data[$field]['postdata'])) {
			if($default === TRUE AND count($this->field_data) === 0) {
				return ' checked="checked"';
			}
			return '';
		}
		$field = $this->field_data[$field]['postdata'];
		if(is_array($field)) {
			if(!in_array($value, $field)) {
				return '';
			}
		}else{
			if(($field == '' OR $value == '') || ($field != $value)) {
				return '';
			}
		}
		return ' checked="checked"';
	}

	/**
	 * 设置一个复选框
	 * @param string $field 字段名
	 * @param string $value 字段值
	 * @param string $default 默认选中
	 * @return string
	 */
	public function set_checkbox($field = '', $value = '', $default = FALSE) {
		if(!isset($this->field_data[$field]) || ! isset($this->field_data[$field]['postdata'])) {
			if($default === TRUE && count($this->field_data) === 0) {
				return ' checked="checked"';
			}
			return '';
		}
		$field = $this->field_data[$field]['postdata'];
		if(is_array($field)) {
			if( ! in_array($value, $field)) {
				return '';
			}
		}else{
			if(($field == '' || $value == '') || ($field != $value)) {
				return '';
			}
		}
		return ' checked="checked"';
	}

	/**
	 * 检查是否存在
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
		$fields = '';
		while(1){
			if (preg_match("/(.*?)\\[(.*)\\]/", $field, $match)) {
				$fields .= "['{$match[1]}']";
				$field	= $match[2];
			}else{
				$fields .= "['{$field}']";
				break;
			}
		}
		eval('$field=@$_POST'.$fields.';');
		if(empty($field)) {
			return FALSE;
		}
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
/* End of the file */