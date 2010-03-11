<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
 * 输入类
 * 为系统提供用户输入数据
 * 依赖于safety库
*/
class cls_in {

	public $get = NULL;
	public $post = NULL;

	public function  __construct() {
		$this->post = $this->clean_input_data($_POST);
		$this->get = $this->load_get();
	}

	/**
	 * 安全化输入数据
	 * @param str/array $str
	 * @return str/array
	 */
	private function clean_input_data($str) {
		if(is_array($str)) {
			$new_array = array();
			foreach ($str as $key => $val) {
				$new_array[$this->clean_input_keys($key)] = $this->clean_input_data($val);
			}
			return $new_array;
		}
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		if(strpos($str, "\r") !== FALSE) {
			$str = str_replace(array("\r\n", "\r"), "\n", $str);
		}
		return $str;
	}

	/**
	 * 安全化输入数组键名
	 * @param str $str
	 * @return str
	 */
	private function clean_input_keys($str) {
		if(!preg_match("/^[a-z0-9:_\/-]+$/i", $str)) {
			exit('Disallowed Key Characters.');
		}
		return $str;
	}

	private function load_get() {
		
	}

}