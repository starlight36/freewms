<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
 * 配置类
*/
class cls_config {
	private static $config_array = array();
	public $value = NULL;

	/**
	 * 加载一个配置文件
	 * @param string $config_file_name
	 * @return array/bool
	 */
	public function load($config_file_name) {
		if(!isset($this->config_array[$config_file_name])) {
			$config_file = DIR_ROOT.'config/'.$config_file_name.'.php';
			@include_once $config_file;
			if(!empty($config)) {
				$this->config_array[$config_file_name] = $config;
			}else{
				return FALSE;
			}
		}
		$this->value = $this->config_array;
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
		$path = NULL;
		foreach($keyarray as $v) {
			$path .= "['{$v}']";
		}
		@eval('$value=$this->value'.$path.';');
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
		$this->config_array = $this->value;
		return TRUE;
	}
}
/* End of the file */