<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 部件类 为模版标签提供接口
 */

class Widget {
	private static $instance;
	private static $objs = array();

	private function  __construct() {
		return FALSE;
	}

	private function  __clone() {
		return FALSE;
	}

	/**
	 * 获取部件库实例
	 * @return object
	 */
	public static function get_instance() {
		if(!(self::$instance instanceof self)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * 魔术方法载入部件
	 * @param <type> $name
	 * @return <type>
	 */
	public function  __get($name) {
		if(is_object(self::$objs[$name])) {
			return self::$objs[$name];
		}
		$class_name = 'widget_'.$name;
		if(!class_exists($class_name, FALSE)) {
			if(is_file(BASEPATH.'inc/widget/'.$name.'.class.php')) {
				@include_once BASEPATH.'inc/widget/'.$name.'.class.php';
			}else{
				return FALSE;
			}
		}
		$objs[$name] = new $class_name;
		return $objs[$name];
	}
}
/* End of this file */