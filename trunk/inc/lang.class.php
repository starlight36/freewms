<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

class Lang {
	public static $lang = array();

	private function   __construct() {
		return FALSE;
	}

	private function  __clone() {
		return FALSE;
	}

	/**
	 * 加载一个语言设置文件
	 * @param string $file
	 */
	public static function load($file) {
		$file = BASEPATH.'lang/'.SITE_LANG.'/'.strtolower($file).'.lang.php';
		if(is_file($file)) {
			include $file;
			self::$lang = array_merge(self::$lang, $lang);
		}
	}

	/**
	 * 取一个语言标记
	 * @param string $str
	 * @return string
	 */
	public static function _($str) {
		$argcount = func_num_args();
		if($argcount > 1) {
			$arglist = func_get_args();
			for($i = 1; $i < $argcount; $i++) {
				$args[] = "'{$arglist[$i]}'";
			}
			eval('$value=sprintf(path_array(self::$lang, $str), '.implode(',', $args).');');
		}else{
			$value = path_array(self::$lang, $str);
		}
		if(empty($value)) $value = $str;
		return $value;
	}
}

/* End of this file */