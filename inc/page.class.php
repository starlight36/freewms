<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 自定义页面类
 */

class Page {
	public static function get($key) {
		$pinfo = Cache::get('page/'.$key);
		if($pinfo) return $pinfo;
		$db = DB::get_instance();
		if(preg_match('/^[0-9]+$/', $key)) {
			$db->sql_add('WHERE `page_id` = ?', $key);
		}else{
			$db->sql_add('WHERE `page_key` = ?', $key);
		}
		$db->select('*')->from('page');
		$pinfo = $db->get();
		if($pinfo == NULL) {
			return FALSE;
		}
		$pinfo = $pinfo[0];
		if($pinfo['page_static'] == '1') {
			$pinfo['page_url'] = URL::base().'page/'.$pinfo['page_key'].'.'.Config::get('site_staticize_extname');
		}else{
			$pinfo['page_url'] = URL::get_url('page', 'm=page&key='.$pinfo['page_key']);
		}
		Cache::set('page/'.$key, $pinfo);
		return $pinfo;
	}
}