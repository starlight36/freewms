<?php
/*
 * 表单函数
*/

/**
 * 设置表单的默认值
 * @param string $field 字段名
 * @param string $default 默认值
 * @return string
 */
function set_value($field = '', $default = '') {
	if(FALSE === ($OBJ =& load_class('form'))) {
		if (!isset($_POST[$field])) {
			return $default;
		}
		return form_prep($_POST[$field], $field);
	}
	return form_prep($OBJ->set_value($field, $default), $field);
}

/**
 * 取一个表单项目的错误消息
 * @param string $field 字段
 * @param string $prefix 开始前缀
 * @param string $suffix 结束后缀
 * @return string
 */
function form_error($field = '', $prefix = '', $suffix = '') {
	if (FALSE === ($OBJ =& load_class('form'))) {
		return '';
	}
	return $OBJ->error($field, $prefix, $suffix);
}

/**
 * 取得全部错误消息
 * @param string $prefix 开始前缀
 * @param string $suffix 结束后缀
 * @return string
 */
function validation_errors($prefix = '', $suffix = '') {
	if (FALSE === ($OBJ =& load_class('form'))) {
		return '';
	}
	return $OBJ->error_string($prefix, $suffix);
}

/**
 * 设置全局错误条目界定符
 * @param string $prefix
 * @param strinf $suffix
 */
function set_error_delimiters($prefix = '', $suffix = '') {
	if (FALSE === ($OBJ =& load_class('form'))) {
		return '';
	}
	return $OBJ->set_error_delimiters($prefix, $suffix);
}

/**
 * 格式化安全的属性
 * @staticvar array/string $prepped_fields
 * @param string $str
 * @param string $field_name
 * @return string
 */
function form_prep($str = '', $field_name = '') {
	static $prepped_fields = array();
	if (is_array($str)) {
		foreach ($str as $key => $val) {
			$str[$key] = form_prep($val);
		}
		return $str;
	}
	if ($str === '') {
		return '';
	}
	if (isset($prepped_fields[$field_name])) {
		return $str;
	}
	$str = htmlspecialchars($str);
	$str = str_replace(array("'", '"'), array("&#39;", "&quot;"), $str);
	if ($field_name != '') {
		$prepped_fields[$field_name] = $str;
	}
	return $str;
}

/* End of the file */