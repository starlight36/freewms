<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
 * 输入类
 * 为系统提供用户输入数据
 * 依赖于safety库
*/
class cls_in {

	public $get = NULL;
	public $post = NULL;
	private $controller = NULL;
	private $action = NULL;

	public function  __construct() {
		$this->post = $this->clean_input_data($_POST);
		$this->load_get();
		$this->get = $this->clean_input_data($this->get);
		if(!check_safety_name($this->controller) || !check_safety_name($this->action)) {
			show_404();
			return FALSE;
		}
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

	/**
	 * 加载GET参数
	 * @return bool
	 */
	private function load_get() {
		if(URI_MODE == 'GET') {
			$this->get =& $_GET;
			$this->controller = empty($_GET['c'])?DEFAULT_CONTROLLER:$_GET['c'];
			$this->action = empty($_GET['a'])?DEFAULT_ACTION:$_GET['a'];
			unset($this->get['c'], $this->get['a']);
			return TRUE;
		}elseif(URI_MODE == 'PATH') {
			$str = @$_SERVER['PATH_INFO'];
			if(substr($str, 0, 1) == '/') {
				$str = substr($str, 1);
			}
		}elseif(URI_MODE == 'QUERY_STRING') {
			$str = @$_SERVER['QUERY_STRING'];
		}
		$this->get = $this->get_segment_array($str);
		return TRUE;
	}

	/**
	 * 读取URI分段数组
	 * @param string $str URI分段
	 * @return array
	 */
	private function get_segment_array($str) {
		//处理URL路由重定向
		@include DIR_ROOT.'config/route.php';
		if(!empty($route)) {
			foreach($route as $k => $v) {
				if(check_str_in($k, '#')) {
					$str = preg_replace($k, $v, $str);
				}else{
					$str = str_replace($k, $v, $str);
				}
			}
		}
		$arr_segment = explode('/', $str);
		$this->controller = empty($arr_segment[0])?DEFAULT_CONTROLLER:$arr_segment[0];
		$this->action = empty($arr_segment[1])?DEFAULT_ACTION:$arr_segment[1];
		if(count($arr_segment) > 2) {
			for($i = 2; $i < count($arr_segment); $i += 2) {
				if(isset($arr_segment[$i + 1])) {
					$segment[$arr_segment[$i]] = $arr_segment[$i + 1];
				}
			}
		}
		return $segment;
	}

	/**
	 * 读取控制器名称
	 * @return string
	 */
	public function controller() {
		return $this->controller;
	}

	/**
	 * 读取动作名称
	 * @return string
	 */
	public function action() {
		return $this->action;
	}

	/**
	 * 读取GET参数
	 * @param string $key 读取路径
	 * @return unknown
	 */
	public function get($key = NULL) {
		return path_array($this->get, $key);
	}

	/**
	 * 读取POST参数
	 * @param string $key
	 * @return unknown
	 */
	public function post($key = NULL) {
		return path_array($this->get, $key);
	}

	/**
	 * 取得一个COOKIE
	 * @param string $key COOKIE索引
	 * @return string
	 */
	public function cookie($key) {
		return  $this->clean_input_data($_COOKIE[COOKIES_PERFIX.$key]);
	}

	/**
	* 取得IP地址
	* @return string
	*/
	public function ip() {
		if($_SERVER['HTTP_X_FORWARDED_FOR']) {
			$t_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}elseif($_SERVER['HTTP_CLIENT_IP']){
			$t_ip = $_SERVER['HTTP_CLIENT_IP'];
		}else{
			$t_ip = $_SERVER['REMOTE_ADDR'];
		}
		return $t_ip;
	}

	/**
	 * 重新加载POST数组, 供表单验证器重写POST内容
	 */
	public function reload_post() {
		$this->post = $this->clean_input_data($_POST);
	}
}

/* End of the file */