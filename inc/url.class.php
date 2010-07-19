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
	private static $url_route = NULL;

	public static function base() {
		return Config::get('site_url');
	}

	public static function skin() {
		return self::base().'theme/'.Config::get('site_theme').'/skin/';
	}

	public static function theme() {
		return self::base().'theme/'.Config::get('site_theme').'/';
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
		if(self::$url_route == NULL) {
			if(!is_file(BASEPATH.'config/route.php')) {
				return FALSE;
			}
			include BASEPATH.'config/route.php';
			self::$url_route = $route;
		}
	}

	/**
	 * 预处理URL
	 */
	public static function init() {
		self::load();
		if(self::$url_plan == 'path') {
			$get_query = $_SERVER['PATH_INFO'];
			foreach(self::$url_route as $pattern => $replacement) {
				$get_query = preg_replace("#^\\/{$pattern}$#i", $replacement, $get_query);
			}
			parse_str($get_query, $out);
			$_GET = array_merge($_GET, $out);
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
		if(self::$url_plan == 'normal') {
			return self::base().'index.php?'.$str;
		}else{
			parse_str($str, $in);
			$url_tpl_list = explode('|', self::$url_config[$key]);
			$url = NULL;
			foreach($url_tpl_list as $url_tpl) {
				$count = 0;
				foreach($in as $k => $v) {
					if(strpos($url_tpl, "{{$k}}") !== FALSE || in_array($k, array('m', 'a'))) {
						$count++;
					}
				}
				if($count == count($in)) {
					$url = $url_tpl;
					foreach($in as $k => $v) {
						$url = str_ireplace("{{$k}}", $v, $url);
					}
					break;
				}
			}
			if($url == NULL) {
				return self::base().'index.php?'.$str;
			}
			if(self::$url_plan == 'path') {
				return self::base().'index.php/'.$url;
			}else{
				return self::base().$url;
			}
		}
	}
}

/* End of this file */