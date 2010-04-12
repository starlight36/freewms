<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
 * session类
 */
class cls_session {
	private $session = NULL;

	public function  __construct() {
		$this->session =& $_SESSION;
	}

	/**
	 * 读取一个SESSION的值,使用PATH路径形式
	 * @param string $key
	 * @return unknown
	 */
	public function get($key) {
		return path_array($this->session, $key);
	}

	/**
	 * 设置一个SESSION,使用PATH路径形式
	 * @param string $key
	 * @param unknown $value
	 * @return unknown
	 */
	public function set($key, $value) {
		$array = path_array($this->session, $key);
		$array = $value;
		return TRUE;
	}

	/**
	 * 注销一个SESSION
	 * @param string $key SESSION key
	 * @return bool
	 */
	public function clear($key = NULL) {
		$array = path_array($this->session, $key);
		@eval('unset($array);');
		return TRUE;
	}

	/**
	 * 以FLASH形式取出一个值
	 * @param <type> $key
	 * @return <type>
	 */
	public function flash($key) {
		$value = $this->get($key);
		$this->clear($key);
		return $value;
	}
}
/* End of the file */