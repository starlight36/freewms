<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

class URL {

	private static $url_plan = NULL;
	private static $url_config = NULL;

	public static function base() {
		return Config::get('site_url');
	}

	/**
	 * 加载URL基本设置
	 * @return void
	 */
	private static function load() {
		if(self::$url_plan == NULL) {
			self::$url_plan = Config::get('site_url_plan');
		}
		if(self::$url_config == NULL) {
			if(!is_file(BASEPATH.'config/url.php')) {
				return FALSE;
			}
			include BASEPATH.'config/url.php';
			self::$url_config = $url;
		}
	}

	/**
	 * 读取一个URL项目
	 * @param string $key URL项目索引
	 * @param string $str 传入的查询字符串
	 * @return string
	 */
	public static function get_url($key, $str) {
		self::load();
		parse_str($str, $in);
		$url = self::$url_config[self::$url_plan.'_'.$key];
		foreach($in as $key => $value) {
			$url = str_replace('{'.$key.'}', $value, $url);
		}
		return $url;
	}

	/**
	 * 取得一个URL参数
	 * @param string $key URL模版关键字
	 * @param string $path URL参数名
	 * @return string
	 */
	public static function get_args($key, $path = NULL) {
		self::load();
		if(self::$url_plan == 'path') {
			$url = explode('/', self::$url_config['path_'.$key]);
			$path = explode('/', $_SERVER['PATH_INFO']);
			for($i = 1; $i < count($path); $i++) {
				$url[$i] = str_replace(array('{','}'), array(NULL, NULL), $url[$i]);
				$_GET[$url[$i]] = $path[$i];
			}
		}
		return path_array($_GET, $path);
	}
}

/* End of this file */