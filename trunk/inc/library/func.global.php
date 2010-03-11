<?php if (!defined("IN_SYS")) die("Access Denied.");
//-------------------------------------------
//全局基础函数库
//-------------------------------------------

/**
 * 注销全局变量,保证安全
 * 依赖于unset_globals
 * @return bool
 */
function unregister_globals() {
	if (!ini_get('register_globals')) {
		return FALSE;
	}
	$arr_pass_unset = array('_GET', '_POST', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
	$arr_input = array_merge($_GET, $_POST,	$_COOKIE, $_SERVER, $_ENV, $_FILES, isset($_SESSION) && is_array($_SESSION) ? $_SESSION : array());
	foreach ($arr_input as $key => $value) {
		if ($key == 'GLOBALS') {
			unset_globals($arr_input[$key]);
		}elseif (!in_array($key, $arr_pass_unset) && isset($GLOBALS[$key])) {
			unset($GLOBALS[$key]);
		}
	}
	unset($HTTP_GET_VARS, $HTTP_POST_VARS, $HTTP_COOKIE_VARS, $HTTP_SERVER_VARS, $HTTP_ENV_VARS);
	return TRUE;
}
/**
 * 清空全局变量数组,保证安全
 * @param array $arr_global 输入的数组
 */
function unset_globals($arr_global) {
	if (is_array($arr_global)) {
		foreach ($arr_global as $key => $value) {
			if ($key == "GLOBALS") unset_globals($arr_global[$key]);
			unset($GLOBALS[$key]);
		}
	}
}
/**
 * 加载类
 * 依赖于instantiate_class
 * @param string $name 类名称
 * @param bool $return 是否返回实例
 * @return object
 */
function &load_class($name, $return = TRUE) {
	static $objects = array();

	if(isset($objects[$name])) {
		return $objects[$name];
	}

	if(strpos($name, '/') > 0) {
		$path = DIR_INC.str_replace('\\', '/', dirname($name)).'/';
		$name = basename($name, '.php');
		$class_file = $path.$name.'.php';
	}else{
		$class_file = strtolower($name).'.php';
		if(is_file(DIR_INC.'library/class.'.$class_file)) {
			$class_file = DIR_INC.'library/class.'.$class_file;
		}elseif(is_file(DIR_INC.'controller/'.$class_file)){
			$class_file = DIR_INC.'controller/'.$class_file;
		}else{
			die('Load class '.$name.' fail.');
		}
	}
	include_once $class_file;
	
	if($return) {
		$objects[$name] = &instantiate_class(new $name());
		return $objects[$name];
	}else{
		return TRUE;
	}
}
/**
 * 类实例化
 * @param object $class_object
 * @return object
 */
function &instantiate_class(&$class_object) {
	return $class_object;
}
/**
 * 载入函数库文件
 * @param string $name 库名称
 * @return bool
 */
function load_library($name) {
	static $libraries = array();
	if(isset($libraries[$name])) {
		return TRUE;
	}
	$lib_file = strtolower($name).'.php';
	if(is_file(DIR_INC.'library/func.'.$lib_file)) {
		include_once DIR_INC.'library/func.'.$lib_file;
	}else{
		if(is_file(DIR_INC.'interface/'.$lib_file)) {
			include_once DIR_INC.'interface/'.$lib_file;
		}else{
			die('Load library '.$name.' fail.');
		}
	}
	$libraries[$name] = TRUE;
	return TRUE;
}
/* End of the file */