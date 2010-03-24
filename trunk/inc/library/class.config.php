<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
 * 配置类
*/
class cls_config {
	public static $value = array();

	/**
	 * 加载一个配置文件
	 * @param string $config_file_name
	 * @return array/bool
	 */
	public function load($config_file_name) {
		if(!isset($this->value[$config_file_name])) {
			$config_file = DIR_ROOT.'config/'.$config_file_name.'.php';
			@include_once $config_file;
			if(!empty($config)) {
				$this->value[$config_file_name] = $config;
			}else{
				return FALSE;
			}
		}
		return $this->value;
	}

	/**
	 * 读取一个配置
	 * 使用PATH形式从数组中读取
	 * @param string $key
	 * @return unknown
	 */
	public function get($key) {
		if(empty($key)) return FALSE;
		$keyarray = explode('/', $key);
		$path = '$this->value';
		foreach($keyarray as $v) {
			$path .= "['{$v}']";
		}
		eval('$value='.$path.';');
		return $value;
	}

	/**
	 * 设置一个设置项
	 * @param string $key PATH形式的路径
	 * @param unknown $value 要设置的值
	 * @return bool
	 */
	public function set($key, $value) {
		if(empty($key)) return FALSE;
		$keyarray = explode('/', $key);
		$path = NULL;
		foreach($keyarray as $v) {
			$path .= "['{$v}']";
		}
		@eval('$this->value'.$path.'=$value;');
		return TRUE;
	}
}
/* End of the file */